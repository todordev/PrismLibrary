<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Profile;

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
}
