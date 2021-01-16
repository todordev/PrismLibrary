<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

trait ExtractingToArray
{
    /**
     * Extract object properties to array.
     * <code>
     * $object = new ExampleObject();
     * $data = $object->toArray();
     * </code>
     *
     * @param array $excludes
     * @return array
     */
    public function toArray(array $excludes = []): array
    {
        if (!$excludes) {
            return get_object_vars($this);
        }

        $properties = get_object_vars($this);
        foreach ($properties as $key => $value) {
            if (in_array($key, $excludes, true)) {
                unset($properties[$key]);
            }
        }

        return $properties;
    }
}
