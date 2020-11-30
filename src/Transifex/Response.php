<?php
/**
 * @package      Prism
 * @subpackage   Transifex
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Transifex;

/**
 * This class provides methods for managing Transifex Response.
 *
 * @package      Prism
 * @subpackage   Transifex
 */
class Response
{
    /**
     * Set values to the parameters of the object.
     *
     * <code>
     * $data = array(
     *     "property_name" => 1,
     *     "property_name2" => 2
     * );
     *
     * $response = new Prism\Library\Transifex\Response();
     * $response->bind($data);
     *
     * </code>
     *
     * @param array $data
     * @param array $excluded
     */
    public function bind(array $data, array $excluded = array())
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $excluded, true)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Get a value of a parameter.
     *
     * <code>
     * $response = new Prism\Library\Transifex\Response();
     *
     * $response->get("property_name");
     * </code>
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return (!isset($this->$name)) ? $default : $this->$name;
    }

    /**
     * Set a value to a parameter.
     *
     * <code>
     * $response = new Prism\Library\Transifex\Response();
     *
     * $response->set("property_name", 123);
     * </code>
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function set($name, $value)
    {
        $this->$name = $value;

        return $this;
    }

    /**
     * Get a value of a parameter.
     *
     * <code>
     * $response = new Prism\Library\Transifex\Response();
     *
     * echo $response->property_name;
     * </code>
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return (!isset($this->$name)) ? null : $this->$name;
    }
}
