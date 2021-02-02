<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\CMS\Router\Router;
use Joomla\CMS\Uri\Uri;

/**
 * Route helper used in Joomla! CMS.
 *
 * @package Prism\Library\Prism\Utility
 */
final class RouteHelper
{
    /**
     * Route URI to front-end.
     *
     * @param string $url
     * @return string
     * @throws \RuntimeException
     */
    public static function siteRoute(string $url): string
    {
        $routerSite = Router::getInstance('site');

        $uri        = Uri::getInstance();
        $website    = $uri->toString(array('scheme', 'host'));

        $routedUri = $routerSite->build($url);
        if ($routedUri instanceof Uri) {
            $routedUri = $routedUri->toString();
        }

        if (str_contains($routedUri, '/administrator')) {
            $routedUri = str_replace('/administrator', '', $routedUri);
        }

        return $website . $routedUri;
    }
}
