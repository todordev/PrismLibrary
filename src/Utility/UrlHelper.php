<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Uri\Uri;

/**
 * This class provides methods for interacting with URL data.
 *
 * @package Prism\Library\Prism\Utility
 */
final class UrlHelper
{
    /**
     * Generate a URI string by a given list of parameters.
     *
     * @param array $params
     *
     * @return string
     */
    public static function generateParams(array $params): string
    {
        $result = '';
        foreach ($params as $key => $param) {
            $result .= '&' . rawurlencode($key) . '=' . rawurlencode($param);
        }

        return $result;
    }

    /**
     * Generate URL to folder.
     *
     * @param string $path
     *
     * @return string
     */
    public static function generateUrlToFolder(string $path): string
    {
        return Uri::root() . Path::clean($path, '/');
    }
}
