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
interface RendererInterface
{
    /**
     * Method to get an element.
     *
     * @param   array  $data  Data to be passed into the rendering of the element.
     *
     * @return  string  A string containing the html for the element.
     */
    public function render(array $data = array());
}
