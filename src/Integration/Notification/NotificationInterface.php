<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Notification;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality
 * to integrate extensions with notification services.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
interface NotificationInterface
{
    public function send();
    public function setContent($content);
    public function getContent();
    public function getUserId();
    public function setUserId($userId);
}
