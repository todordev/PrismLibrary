<?php
/**
 * @package      Prism\Library\Prism
 * @subpackage   Constant
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Constant;

/**
 * Status constants.
 *
 * @package      Prism\Library\Prism
 * @subpackage   Constant
 */
class Status
{
    public const PUBLISHED = 1;
    public const UNPUBLISHED = 0;
    public const TRASHED = -2;
    public const AWAITING_APPROVAL = -3;
}
