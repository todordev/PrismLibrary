<?php
/**
 * @package         Prism
 * @subpackage      Helpers
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Helper;

defined('JPATH_PLATFORM') or die;

/**
 * Helper command bus class.
 *
 * @package         Prism
 * @subpackage      Helpers
 */
class HelperBus implements HelperHandlerInterface
{
    use HelperHandlerTrait;

    /**
     * Initialize the object.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
