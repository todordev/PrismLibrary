<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Integration\Notification;

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
