<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Profile;

use Prism\Database\TableImmutable;

defined('JPATH_PLATFORM') or die;

/**
 * Abstract class of the social profiles.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
abstract class ProfileAbstract extends TableImmutable
{
    abstract public function getLink($route = true);
    abstract public function getAvatar();
    abstract public function getLocation();
    abstract public function getCountryCode();
}
