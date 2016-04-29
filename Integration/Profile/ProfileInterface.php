<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with social profiles.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
interface ProfileInterface
{
    public function getLink($route = true);
    public function getAvatar();
    public function getLocation();
    public function getCountryCode();
}
