<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

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
