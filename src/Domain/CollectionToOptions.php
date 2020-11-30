<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

/**
 * Interface CollectionToOptions
 * @package Prism\Library\Prism\Domain
 * @deprecated
 */
interface CollectionToOptions
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
    public function toOptions($key, $text, $suffix = '');
}
