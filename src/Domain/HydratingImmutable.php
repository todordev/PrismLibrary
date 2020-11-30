<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

use Joomla\Registry\Registry;

trait HydratingImmutable
{
    /**
     * @var bool
     */
    protected $hydrated = false;

    /**
     * Set notification data to object parameters.
     *
     * <code>
     * $data = array(
     *     'title'    => 'EURO',
     *     'code'     => 'EUR',
     *     'symbol'   => '€',
     *     'position' => '0'
     * );
     *
     * $currency = new Prism\Library\Money\Currency();
     * $currency->hydrated($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     *
     * @throws BindException
     */
    public function hydrate(array $data, array $ignored = []): void
    {
        if ($this->hydrated) {
            throw new BindException('The properties of this immutable object has already been initialized.');
        }

        $properties = get_object_vars($this);

        // Parse parameters of the object if they exists.
        if (array_key_exists('params', $data) && array_key_exists('params', $properties) && !in_array('params', $ignored, true)) {
            if ($data['params'] instanceof Registry) {
                $this->params = $data['params'];
            } else {
                $this->params = new Registry($data['params']);
            }
            unset($data['params']);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties) && !in_array($key, $ignored, true)) {
                $this->$key = $value;
            }
        }

        $this->hydrated = true;
    }
}
