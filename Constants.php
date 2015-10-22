<?php
/**
 * @package      Prism
 * @subpackage   Constants
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

defined('JPATH_PLATFORM') or die;

/**
 * Prism constants
 *
 * @package      Prism
 * @subpackage   Constants
 */
class Constants
{
    // States
    const PUBLISHED   = 1;
    const UNPUBLISHED = 0;
    const TRASHED     = -2;

    const APPROVED     = 1;
    const NOT_APPROVED = 0;

    const FEATURED = 1;
    const NOT_FEATURED = 0;

    const ENABLED = 1;
    const DISABLED = 0;

    const VERIFIED     = 1;
    const NOT_VERIFIED = 0;

    const FOLLOWED     = 1;
    const UNFOLLOWED   = 0;

    const DISPLAY          = 1;
    const DO_NOT_DISPLAY   = 0;

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

    // State replace
    const REPLACE = 1;
    const DO_NOT_REPLACE = 0;
}
