<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Integration\Profile;

defined('JPATH_PLATFORM') or die;

/**
 * The interface of profile mapper.
 *
 * @package      Prism
 * @subpackage   Integrations\Profiles
 */
interface ProfileMapper
{
    public function getMapping();
}
