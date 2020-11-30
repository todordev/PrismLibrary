<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Profile;

use Prism\Library\Prism\Database\TableImmutable;

defined('JPATH_PLATFORM') or die;

/**
 * Abstract class of the social profiles.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 *
 * @deprecated v1.20
 */
abstract class ProfileAbstract extends TableImmutable
{
    abstract public function getLink($route = true);
    abstract public function getAvatar();
    abstract public function getLocation();
    abstract public function getCountryCode();
}
