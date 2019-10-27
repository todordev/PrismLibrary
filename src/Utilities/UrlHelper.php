<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Utilities;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides methods for interacting with URL data.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class UrlHelper
{
    /**
     * Generate a URI string by a given list of parameters.
     *
     * @param array $params
     *
     * @return string
     */
    public static function generateParams($params): string
    {
        $result = '';
        foreach ($params as $key => $param) {
            $result .= '&' . rawurlencode($key) . '=' . rawurlencode($param);
        }

        return $result;
    }
}
