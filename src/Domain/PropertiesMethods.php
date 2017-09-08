<?php
/**
 * @package      Prism
 * @subpackage   Data
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

/**
 * Methods used to interact with object properties.
 *
 * @package      Prism
 * @subpackage   Data
 */
trait PropertiesMethods
{
    /**
     * Returns object properties as associative array.
     *
     * @return  array
     */
    public function getProperties()
    {
        $vars = get_object_vars($this);

        if (array_key_exists('params', $vars) and method_exists($this, 'getParams')) {
            $vars['params'] = $this->getParams();
        }

        foreach ($vars as $key => $v) {
            if (is_object($v) and method_exists($v, 'getProperties')) {
                $vars[$key] = $v->getProperties();
            }
        }

        return $vars;
    }
}
