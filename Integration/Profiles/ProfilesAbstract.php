<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profiles;

use Prism\Database\Collection;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to
 * integrate extensions with social profiles.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 *
 * @deprecated v1.20
 */
abstract class ProfilesAbstract extends Collection
{
    abstract public function getLink($userId, $route = true);
    abstract public function getAvatar($userId, $size, $returnDefault = true);
    abstract public function getLocation($userId);
    abstract public function getCountryCode($userId);
}
