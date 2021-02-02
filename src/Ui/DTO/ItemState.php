<?php
/**
 * @package  Prism\Library\Prism\Ui\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Ui\Dto;

/**
 * Data transfer object of item state.
 *
 * @package  Prism\Library\Prism\Ui\Dto
 */
final class ItemState
{
    private string $method;
    private string $tooltip;
    private string $icon;
    private string $activeClass;

    /**
     * ItemState constructor.
     *
     * @param string $method
     * @param string $tooltip
     * @param string $icon
     * @param string $activeClass
     */
    public function __construct(string $method, string $tooltip, string $icon, string $activeClass)
    {
        $this->method = $method;
        $this->tooltip = $tooltip;
        $this->icon = $icon;
        $this->activeClass = $activeClass;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getTooltip(): string
    {
        return $this->tooltip;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getActiveClass(): string
    {
        return $this->activeClass;
    }
}
