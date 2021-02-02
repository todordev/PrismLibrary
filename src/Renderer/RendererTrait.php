<?php
/**
 * @package      Prism\Library\Prism\Renderer
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Renderer;

use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutInterface;

/**
 * Provides interface and functionality for objects
 * that render output by a layout.
 *
 * @package Prism\Library\Prism\Renderer
 */
trait RendererTrait
{
    /**
     * The layout that will be used to display an element.
     *
     * @var string
     */
    protected string $layout = '';

    /**
     * The paths from where the system will load the layout of the element.
     *
     * @var array
     */
    protected array $layoutPaths = [];

    /**
     * State of debug functionality.
     *
     * @var bool
     */
    protected bool $debug  = false;

    /**
     * Set a layout.
     * <code>
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     * $progressBadges = Gamification\User\Progress\ProgressBadges(\JFactory::getDbo, $keys);
     * $progressBar    = new Gamification\User\ProgressBar($progressBadges);
     * $progressBar->setLayout('other.progressbar');
     * </code>
     *
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * Set a layout.
     * <code>
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     * $progressBadges = Gamification\User\Progress\ProgressBadges(\JFactory::getDbo, $keys);
     * $progressBar    = new Gamification\User\ProgressBar($progressBadges);
     * $progressBar->setLayout('other.progressbar');
     * </code>
     *
     * @param string $fullPath
     */
    public function addLayoutPath(string $fullPath): void
    {
        $this->layoutPaths[] = $fullPath;
    }

    /**
     * Render specific layout of this element.
     * <code>
     * $data = array();
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     * $progressBadges = Gamification\User\Progress\ProgressBadges(\JFactory::getDbo, $keys);
     * $progressBar    = new Gamification\User\ProgressBar($progressBadges);
     * $progressBar->renderLayout('element.progressbar', $data);
     * </code>
     *
     * @param string $layout Layout identifier
     * @param array $data Optional data for the layout
     * @return  string
     */
    public function renderLayout(string $layout, array $data = array()): string
    {
        return $this->getRenderer($layout)->render($data);
    }

    /**
     * Allow to override renderer include paths in child elements.
     *
     * @return  array
     */
    protected function getLayoutPaths(): array
    {
        return $this->layoutPaths;
    }

    /**
     * Get the renderer
     *
     * @param   string  $layout  Id to load
     *
     * @return  LayoutInterface
     */
    protected function getRenderer($layout = 'default'): LayoutInterface
    {
        $renderer = new FileLayout($layout);

        $renderer->setDebug($this->isDebugEnabled());

        $layoutPaths = $this->getLayoutPaths();

        if ($layoutPaths) {
            $renderer->setIncludePaths($layoutPaths);
        }

        return $renderer;
    }

    /**
     * Is debug enabled for this element.
     *
     * @return  boolean
     */
    protected function isDebugEnabled(): bool
    {
        return (bool)$this->debug;
    }

    /**
     * Enable debug.
     *
     * @return  boolean
     */
    public function enableDebug(): bool
    {
        return $this->debug = true;
    }

    /**
     * Disable debug.
     *
     * @return  boolean
     */
    public function disableDebug(): bool
    {
        return $this->debug = false;
    }
}
