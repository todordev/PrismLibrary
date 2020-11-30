<?php
/**
 * @package      Prism
 * @subpackage   Constants
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism;

/**
 * Prism constants
 *
 * @package      Prism
 * @subpackage   Constants
 */
class Constants
{
    // States
    const PUBLISHED          = 1;
    const UNPUBLISHED        = 0;
    const TRASHED            = -2;
    const AWAITING_APPROVAL  = -3;

    const YES = 1;
    const OK  = 1;
    const NO  = 0;

    const LEGACY  = true;
    const NOT_LEGACY  = false;

    const VALID    = true;
    const INVALID  = false;

    const APPROVED     = 1;
    const NOT_APPROVED = 0;

    const ALLOWED      = 1;
    const NOT_ALLOWED  = 0;

    const FEATURED = 1;
    const NOT_FEATURED = 0;

    const ENABLED = 1;
    const DISABLED = 0;

    const VERIFIED     = 1;
    const NOT_VERIFIED = 0;

    const FAVORITE     = 1;
    const NOT_FAVORITE = 0;

    const DISPLAY          = 1;
    const DO_NOT_DISPLAY   = 0;

    const INACTIVE = 0;
    const ACTIVE = 1;

    const LEFT   = 0;
    const RIGHT  = 1;

    const DECODE_AS_OBJECT = false;
    const DECODE_AS_ARRAY  = true;

    // Mail modes - html and plain text.
    const MAIL_MODE_HTML  = true;
    const MAIL_MODE_PLAIN = false;

    // Logs
    const ENABLE_SYSTEM_LOG  = true;
    const DISABLE_SYSTEM_LOG = false;

    // Notification statuses
    const SENT     = 1;
    const NOT_SENT = 0;

    const READ     = 1;
    const NOT_READ = 0;

    // Categories
    const CATEGORY_ROOT = 1;

    // Return values
    const RETURN_DEFAULT = 1;
    const DO_NOT_RETURN_DEFAULT = 0;

    // State default
    const STATE_DEFAULT = 1;
    const STATE_NOT_DEFAULT = 0;

    // Time
    const TIME_SECONDS_24H = 86400;

    // Date
    const DATE_DEFAULT_SQL_DATE = '1000-01-01';
    const DATE_DEFAULT_SQL_DATETIME = '1000-01-01 00:00:00';
    const DATE_FORMAT_SQL_DATE  = 'Y-m-d';
    const DATE_FORMAT_SQL_DATETIME  = 'Y-m-d H:i:s';

    // Numbers
    const NUMBER_DEFAULT_FORMAT = '#0.00';
    const NUMBER_DEFAULT_MONEY_FORMAT = '#,##0.00';

    // Payment statuses
    const PAYMENT_STATUS_COMPLETED = 'completed';
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_CANCELED = 'canceled';
    const PAYMENT_STATUS_REFUNDED = 'refunded';
    const PAYMENT_STATUS_FAILED = 'failed';

    const PAYMENT_STATUS_COMPLETED_BIT = 1;
    const PAYMENT_STATUS_PENDING_BIT = 2;
    const PAYMENT_STATUS_CANCELED_BIT = 4;
    const PAYMENT_STATUS_REFUNDED_BIT = 8;
    const PAYMENT_STATUS_FAILED_BIT = 16;

    // Locale
    const LOCALE_DEFAULT_LANGUAGE_CODE = 'en_GB';

    // Images
    const QUALITY_MAXIMUM = 100;
    const QUALITY_VERY_HIGH = 80;
    const QUALITY_HIGH = 60;
    const QUALITY_MEDIUM = 30;
    const QUALITY_LOW = 10;
}
