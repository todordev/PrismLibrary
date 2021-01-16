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
 * Payment constants.
 *
 * @package      Prism\Library\Prism
 * @subpackage   Constant
 */
class Payment
{
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_PENDING = 'pending';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_FAILED = 'failed';

    public const STATUS_COMPLETED_BIT = 1;
    public const STATUS_PENDING_BIT = 2;
    public const STATUS_CANCELED_BIT = 4;
    public const STATUS_REFUNDED_BIT = 8;
    public const STATUS_FAILED_BIT = 16;
}
