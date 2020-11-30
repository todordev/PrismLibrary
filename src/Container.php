<?php
/**
 * @package      Prism
 * @subpackage   Extensions
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism;

/**
 * This class provides DI container everywhere where we need it, especially in ITPrism's extensions.
 * NOTE: It will be removed when Joomla! PLT implements DI containers in the CMS.
 *
 * @package     Prism
 * @subpackage  Containers
 * @deprecated
 */
abstract class Container
{
    private static $container;

    /**
     * Return DI Container.
     *
     * <code>
     * $container = Prism\Library\Prism\Container::getContainer();
     * </code>
     *
     * @return \Joomla\DI\Container
     */
    public static function getContainer()
    {
        if (self::$container === null) {
            self::$container = new \Joomla\DI\Container();
        }

        return self::$container;
    }
}
