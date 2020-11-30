<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

interface EntityParams
{
    /**
     * Returns a parameter of the object or the default value if the parameter is not set.
     *
     * @param   string $index The name of the index.
     * @param   mixed  $default  The default value.
     *
     * @return  mixed    The value of the property.
     */
    public function getParam($index, $default = null);

    /**
     * Modifies a parameter of the object, creating it if it does not already exist.
     *
     * @param   string $index    The name of the parameter.
     * @param   mixed  $value    The value of the parameter to set.
     *
     * @return  mixed  Previous value of the parameter.
     */
    public function setParam($index, $value = null);

    /**
     * Return the parameters of the object.
     *
     * @return  array
     */
    public function getParams();
}
