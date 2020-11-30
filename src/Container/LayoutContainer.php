<?php
/**
 * @package      Prism
 * @subpackage   Container
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */
namespace Prism\Library\Container;

/**
 * This class transfers data between layouts.
 *
 * @package      Prism
 * @subpackage   Container
 */
final class LayoutContainer
{
    private $items = [];

    public function set($key, $value)
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function get($key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }
}
