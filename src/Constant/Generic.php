<?php
/**
 * @package      Prism
 * @subpackage   Constants
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Constant;

/**
 * Generic constants
 *
 * @package      Prism
 * @subpackage   Constants
 */
class Generic
{
    public const YES = 1;
    public const OK  = 1;
    public const NO  = 0;

    public const LEGACY  = true;
    public const NOT_LEGACY  = false;

    public const VALID    = true;
    public const INVALID  = false;

    public const APPROVED     = 1;
    public const NOT_APPROVED = 0;

    public const ALLOWED      = 1;
    public const NOT_ALLOWED  = 0;

    public const FEATURED = 1;
    public const NOT_FEATURED = 0;

    public const ENABLED = 1;
    public const DISABLED = 0;

    public const VERIFIED     = 1;
    public const NOT_VERIFIED = 0;

    public const FAVORITE     = 1;
    public const NOT_FAVORITE = 0;

    public const DISPLAY          = 1;
    public const DO_NOT_DISPLAY   = 0;

    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public const LEFT   = 0;
    public const RIGHT  = 1;

    public const DECODE_AS_OBJECT = false;
    public const DECODE_AS_ARRAY  = true;

    // Mail modes - html and plain text.
    public const MAIL_MODE_HTML  = true;
    public const MAIL_MODE_PLAIN = false;

    // Logs
    public const ENABLE_SYSTEM_LOG  = true;
    public const DISABLE_SYSTEM_LOG = false;

    // Notification statuses
    public const SENT     = 1;
    public const NOT_SENT = 0;

    public const READ     = 1;
    public const NOT_READ = 0;

    // Categories
    public const CATEGORY_ROOT = 1;

    // Return values
    public const RETURN_DEFAULT = 1;
    public const DO_NOT_RETURN_DEFAULT = 0;

    // State default
    public const STATE_DEFAULT = 1;
    public const STATE_NOT_DEFAULT = 0;

    // Time
    public const TIME_SECONDS_24H = 86400;

    // Date
    public const DATE_DEFAULT_SQL_DATE = '1000-01-01';
    public const DATE_DEFAULT_SQL_DATETIME = '1000-01-01 00:00:00';
    public const DATE_FORMAT_SQL_DATE  = 'Y-m-d';
    public const DATE_FORMAT_SQL_DATETIME  = 'Y-m-d H:i:s';

    // Numbers
    public const NUMBER_DEFAULT_FORMAT = '#0.00';
    public const NUMBER_DEFAULT_MONEY_FORMAT = '#,##0.00';

    // Locale
    public const LOCALE_DEFAULT_LANGUAGE_CODE = 'en_GB';
}
