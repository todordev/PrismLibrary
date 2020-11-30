<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Profiles;

use Prism\Library\Prism\Database\Collection;

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
