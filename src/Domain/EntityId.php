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
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the ID for this object.
     *
     * @param int $id
     * @return self
     *
     * @throws \BadMethodCallException
     * @throws \InvalidArgumentException
     */
    public function setId($id)
    {
        if ($this->id !== null) {
            throw new \BadMethodCallException('The ID for this entity has been set already.');
        }

        if ($id === null || (is_numeric($id) && (int)$id < 1)) {
            throw new \InvalidArgumentException('The entity ID is invalid.');
        }

        $this->id = is_numeric($id) ? (int)$id : (string)$id;

        return $this;
    }
}
