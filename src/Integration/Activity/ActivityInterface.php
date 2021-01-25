<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Integration\Activity;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality
 * to integrate extensions with activity services.
 *
 * @package      Prism
 * @subpackage   Integrations\Activities
 */
interface ActivityInterface
{
    public function store();
    public function setContent($content);
    public function getContent();
    public function setUserId($userId);
    public function getUserId();
}
