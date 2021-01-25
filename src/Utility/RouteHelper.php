<?php
/**
 * @package      Prism
 * @subpackage   Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

/**
 * Route helper used in Joomla! CMS.
 *
 * @package     Prism
 * @subpackage  Utility
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
