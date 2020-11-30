<?php
/**
 * @package         Prism
 * @subpackage      Logs\Interfaces
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Log;

defined('JPATH_PLATFORM') or die;

/**
 * This is the interface of log writer classes.
 *
 * @package         Prism
 * @subpackage      Logs\Interfaces
 */
interface WriterInterface
{
    public function setTitle($title);
    public function setType($type);
    public function setData($data);
    public function setDate($date);
    public function store();
}
