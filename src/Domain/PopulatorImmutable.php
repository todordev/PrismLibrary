<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

use Joomla\Registry\Registry;

trait PopulatorImmutable
{
    /**
     * @var bool
     */
    protected $bound = false;

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
     * $currency  = new Prism\Money\Currency();
     * $currency->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     *
     * @throws BindException
     */
    public function bind(array $data, array $ignored = array())
    {
        if ($this->bound) {
            throw new BindException('The properties of this immutable object has already been initialized.');
        }

        $properties = get_object_vars($this);

        // Parse parameters of the object if they exists.
        if (array_key_exists('params', $data) and array_key_exists('params', $properties) and !in_array('params', $ignored, true)) {
            if ($data['params'] instanceof Registry) {
                $this->params = $data['params'];
            } else {
                $this->params = new Registry($data['params']);
            }
            unset($data['params']);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties) and !in_array($key, $ignored, true)) {
                $this->$key = $value;
            }
        }

        $this->bound = true;
    }
}
