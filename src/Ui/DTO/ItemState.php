<?php
/**
 * @package      Prism\Library
 * @subpackage   Ui
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Ui\DTO;

/**
 * Data transfer object of item state.
 *
 * @package       Prism\Library
 * @subpackage    Ui
 */
final class ItemState
{
    private $method;
    private $tooltip;
    private $icon;
    private $activeClass;

    /**
     * ItemState constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->method = array_key_exists('method', $data) ? (string)$data['method'] : '';
        $this->tooltip = array_key_exists('tooltip', $data) ? (string)$data['tooltip'] : '';
        $this->icon = array_key_exists('icon', $data) ? (string)$data['icon'] : '';
        $this->activeClass = array_key_exists('active_class', $data) ? (string)$data['active_class'] : '';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return ItemState
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getTooltip(): string
    {
        return $this->tooltip;
    }

    /**
     * @param string $tooltip
     * @return ItemState
     */
    public function setTooltip(string $tooltip): ItemState
    {
        $this->tooltip = $tooltip;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return ItemState
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getActiveClass()
    {
        return $this->activeClass;
    }

    /**
     * @param string $activeClass
     * @return ItemState
     */
    public function setActiveClass($activeClass)
    {
        $this->activeClass = $activeClass;
        return $this;
    }
}
