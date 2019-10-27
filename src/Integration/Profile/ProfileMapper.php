<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
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
