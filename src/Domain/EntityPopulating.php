<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

interface EntityPopulating
{
    /**
     * Populate data to the object properties.
     *
     * @param array $data
     * @param array $ignored List with properties that should be ignored during the process of populating.
     */
    public function bind(array $data, array $ignored = array());
}
