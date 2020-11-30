<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Utilities;

/**
 * Route helper used in Joomla! CMS.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class RouteHelper
{
    /**
     * Route URI to front-end.
     *
     * @param string  $url
     *
     * @return string
     * @throws \RuntimeException
     */
    public static function siteRoute($url)
    {
        $routerSite = \JRouter::getInstance('site');

        $uri        = \JUri::getInstance();
        $website    = $uri->toString(array('scheme', 'host'));

        $routedUri = $routerSite->build($url);
        if ($routedUri instanceof \JUri) {
            $routedUri = $routedUri->toString();
        }

        if (false !== strpos($routedUri, '/administrator')) {
            $routedUri = str_replace('/administrator', '', $routedUri);
        }

        return $website.$routedUri;
    }
}
