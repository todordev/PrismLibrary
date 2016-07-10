<?php
/**
 * @package         Prism\Renderer
 * @subpackage      Renderers
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Renderer;

defined('JPATH_PLATFORM') or die;

/**
 * Provides interface and functionality for objects
 * that render output by a layout.
 *
 * @package         Prism\Renderer
 * @subpackage      Renderers
 */
trait RendererTrait
{
    /**
     * The layout that will be used to display an element.
     *
     * @var string
     */
    protected $layout = '';

    /**
     * The paths from where the system will load the layout of the element.
     *
     * @var string
     */
    protected $layoutPaths = array();

    /**
     * State of debug functionality.
     *
     * @var string
     */
    protected $debug  = false;

    /**
     * Set a layout.
     *
     * <code>
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     * $progressBadges = Gamification\User\Progress\ProgressBadges(\JFactory::getDbo, $keys);
     *
     * $progressBar    = new Gamification\User\ProgressBar($progressBadges);
     * $progressBar->setLayout('other.progressbar');
     * </code>
     *
     * @param string $layout
     *
     * @return string
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Set a layout.
     *
     * <code>
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     * $progressBadges = Gamification\User\Progress\ProgressBadges(\JFactory::getDbo, $keys);
     *
     * $progressBar    = new Gamification\User\ProgressBar($progressBadges);
     * $progressBar->setLayout('other.progressbar');
     * </code>
     *
     * @param string $fullPath
     *
     * @return string
     */
    public function addLayoutPath($fullPath)
    {
        $this->layoutPaths[] = $fullPath;

        return $this;
    }

    /**
     * Render specific layout of this element.
     *
     * <code>
     * $data = array();
     *
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     * $progressBadges = Gamification\User\Progress\ProgressBadges(\JFactory::getDbo, $keys);
     *
     * $progressBar    = new Gamification\User\ProgressBar($progressBadges);
     * $progressBar->renderLayout('element.progressbar', $data);
     * </code>
     *
     * @param   string  $layoutId  Layout identifier
     * @param   array   $data      Optional data for the layout
     *
     * @return  string
     */
    public function renderLayout($layoutId, array $data = array())
    {
        $data = array_merge($this->getLayoutData(), $data);

        return $this->getRenderer($layoutId)->render($data);
    }

    /**
     * Method to get the data to be passed to the layout for rendering.
     *
     * @return  array
     */
    protected function getLayoutData()
    {
        return array();
    }

    /**
     * Allow to override renderer include paths in child elements.
     *
     * @return  array
     */
    protected function getLayoutPaths()
    {
        return $this->layoutPaths;
    }

    /**
     * Get the renderer
     *
     * @param   string  $layoutId  Id to load
     *
     * @return  \JLayout
     */
    protected function getRenderer($layoutId = 'default')
    {
        $renderer = new \JLayoutFile($layoutId);

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
    protected function isDebugEnabled()
    {
        return (bool)$this->debug;
    }

    /**
     * Enable debug.
     *
     * @return  boolean
     */
    public function enableDebug()
    {
        return $this->debug = true;
    }

    /**
     * Disable debug.
     *
     * @return  boolean
     */
    public function disableDebug()
    {
        return $this->debug = false;
    }
}
