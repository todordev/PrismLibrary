<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

trait EntityId
{
    protected $id;

    /**
     * Get the ID of this object (unique to the object type)
     *
     * @return int
     */
    public function getId()
    {
        return (int)$this->id;
    }

    /**
     * Set the ID for this object.
     *
     * @param int $id
     * @return self
     *
     * @throws \Exception If the id on the object is already set
     */
    public function setId($id)
    {
        if ($this->id !== null) {
            throw new \BadMethodCallException('The ID for this entity has been set already.');
        }

        if (!is_int($id) || $id < 1) {
            throw new \InvalidArgumentException('The entity ID is invalid.');
        }

        $this->id = (int)$id;

        return $this;
    }
}
