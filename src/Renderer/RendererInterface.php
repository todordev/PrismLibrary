<?php
/**
 * @package         Prism\Library\Prism\Renderer
 * @subpackage      Renderers
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Renderer;

/**
 * Provides interface and functionality for objects
 * that render output by a layout.
 *
 * @package         Prism\Library\Prism\Renderer
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
