<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

use Joomla\Registry\Registry;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use ReflectionProperty;

trait Hydrating
{
    /**
     * Set data to properties of an object.
     *
     * <code>
     * $data = array(
     *     "note"    => "...",
     *     "image"   => "picture.png",
     *     "url"     => "https://funfex.com",
     *     "user_id" => 1
     * );
     *
     * $object = new ExampleObject();
     * $object->hydrate($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     */
    public function hydrate(array $data, array $ignored = []): void
    {
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
    }
}
