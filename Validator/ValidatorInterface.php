<?php
/**
 * @package      Prism
 * @subpackage   Validators\Interfaces
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Validator;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This interface describes validator methods.
 *
 * @package      Prism
 * @subpackage   Validators\Interfaces
 */
interface ValidatorInterface
{
    public function isValid();
}
