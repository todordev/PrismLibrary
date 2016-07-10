<?php
/**
 * @package      Prism
 * @subpackage   Extensions
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides DI container everywhere where we need it, especially in ITPrism's extensions.
 * NOTE: It will be removed when Joomla! PLT implements DI containers in the CMS.
 *
 * @package     Prism
 * @subpackage  Containers
 */
abstract class Container
{
    private static $container;

    /**
     * Return DI Container.
     *
     * <code>
     * $container = Prism\Container::getContainer();
     * </code>
     */
    public static function getContainer()
    {
        if (self::$container === null) {
            self::$container = new \Joomla\DI\Container();
        }

        return self::$container;
    }
}
