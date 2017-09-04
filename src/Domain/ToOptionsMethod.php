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
 * Method that generate associative array from collection items.
 *
 * @package      Prism
 * @subpackage   Data
 */
trait ToOptionsMethod
{
    /**
     * Returns object properties as associative array.
     *
     * @param string $key The name of the property used for value.
     * @param string $text The name of the property used for text.
     * @param string $suffix The name of the property that can be included to the text.
     *
     * @return  array
     */
    public function toOptions($key, $text, $suffix = '')
    {
        $options = array();

        /** @var EntityProperties $item */
        foreach ($this->items as $item) {
            $properties = is_object($item) ? $item->getProperties() : $item;

            if ($suffix !== '' && (array_key_exists($suffix, $properties) && (string)$properties[$suffix] !== '')) {
                $options[] = array('value' => $properties[$key], 'text' => $properties[$text] . ' ['.(string)$properties[$suffix].']');
            } else {
                $options[] = array('value' => $properties[$key], 'text' => $properties[$text]);
            }
        }

        return $options;
    }
}
