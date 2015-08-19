<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Interfaces
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Integration\Activity;

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
