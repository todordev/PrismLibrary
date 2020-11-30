<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utilities;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Uri\Uri;

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
