<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

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
