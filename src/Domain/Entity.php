<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

interface Entity
{
    /**
     * Get the ID of this object (unique to the object type)
     *
     * @return int
     */
    public function getId();

    /**
     * Set the ID for this object.
     *
     * @param int $id
     * @return self
     *
     * @throws \Exception If the id on the object is already set
     */
    public function setId($id);
}
