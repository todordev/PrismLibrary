<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use ReflectionProperty;
use Joomla\Registry\Registry;

trait HydratingImmutable
{
    /**
     * @var bool
     */
    protected bool $hydrated = false;

    /**
     * Set notification data to object parameters.
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     * $currency = new Prism\Library\Prism\Money\Currency();
     * $currency->hydrated($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     * @throws HydrationException
     */
    public function hydrate(array $data, array $ignored = []): void
    {
        if ($this->hydrated) {
            throw new HydrationException('The properties of this immutable object has already been initialized.');
        }

        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(
            ReflectionProperty::IS_PUBLIC |
            ReflectionProperty::IS_PROTECTED |
            ReflectionProperty::IS_PRIVATE
        );

        $properties = [];
        foreach ($props as $prop) {
            $typeName = null;
            $propType = $prop?->getType();
            if ($propType) {
                if ($propType instanceof ReflectionNamedType) {
                    $typeName = $propType->getName();
                } elseif ($propType instanceof ReflectionUnionType) {
                    $propTypes = $propType->getTypes();

                    $types = [];
                    foreach ($propTypes as $unionType) {
                        $types[] = $unionType->getName();
                    }

                    $typeName = $types;
                } else {
                    $typeName = null;
                }
            }

            $properties[$prop->getName()] = $typeName;
        }

        // Parse parameters of the object if they exists.
        if (
            array_key_exists('params', $data) &&
            array_key_exists('params', $properties) &&
            !in_array('params', $ignored, true)
        ) {
            if ($data['params'] instanceof Registry) {
                $this->params = $data['params'];
            } else {
                $this->params = new Registry($data['params']);
            }
            unset($data['params']);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties) && !in_array($key, $ignored, true)) {
                if (is_array($properties[$key])) {
                    if (is_numeric($value) && in_array('int', $properties[$key], true)) {
                        $this->$key = (int)$value;
                    } elseif (is_string($value) && in_array('string', $properties[$key], true)) {
                        $this->$key = $value;
                    } else {
                        $this->$key = $value;
                    }
                } else {
                    $this->$key = match($properties[$key]) {
                        'string' => (string)$value,
                        'int' => (int)$value,
                        default => $value
                    };
                }
            }
        }

        $this->hydrated = true;
    }
}
