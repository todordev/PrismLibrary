<?php
/**
 * @package      Prism
 * @subpackage   Data
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

use Joomla\Registry\Registry;

/**
 * Methods used to interact with object properties.
 *
 * @package      Prism
 * @subpackage   Data
 */
trait ParamsMethods
{
    /**
     * @var Registry
     */
    protected $params;

    /**
     * Returns a parameter of the object or the default value if the parameter is not set.
     *
     * @param   string $index The name of the index.
     * @param   mixed  $default  The default value.
     *
     * @return  mixed    The value of the property.
     */
    public function getParam($index, $default = null)
    {
        return $this->params->get($index, $default);
    }

    /**
     * Modifies a parameter of the object, creating it if it does not already exist.
     *
     * @param   string $index    The name of the parameter.
     * @param   mixed  $value    The value of the parameter to set.
     *
     * @return  mixed  Previous value of the parameter.
     */
    public function setParam($index, $value = null)
    {
        $previous = $this->params->get($index);
        $this->params->set($index, $value);

        return $previous;
    }

    /**
     * Return the parameters of the object.
     *
     * @return  array
     */
    public function getParams()
    {
        return $this->params->toArray();
    }
}
