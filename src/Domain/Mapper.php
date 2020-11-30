<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

/**
 * @package     Prism\Library\Prism\Domain
 *
 * @deprecated
 */
abstract class Mapper
{
    /**
     * Create a new instance of the domain object. If the $data parameter is specified
     * then the object will be populated with it.
     *
     * @param array $data
     *
     * @return Entity
     */
    public function create(array $data = null)
    {
        $object = $this->createObject();
        if ($data) {
            $object = $this->populate($object, $data);
        }

        return $object;
    }

    /**
     * Save the domain object
     *
     * @param Entity $object
     */
    public function save(Entity $object)
    {
        if (!$object->getId()) {
            $this->insertObject($object);
        } else {
            $this->updateObject($object);
        }
    }

    /**
     * Delete the domain object
     *
     * @param Entity $object
     */
    public function delete(Entity $object)
    {
        $this->deleteObject($object);
    }

    /**
     * Populate the domain object with the values from the data array.
     *
     * @param Entity $object
     * @param array                $data
     *
     * @return Entity
     */
    abstract public function populate(Entity $object, array $data);

    /**
     * Create a new instance of a domain object
     *
     * @return Entity
     */
    abstract protected function createObject();

    /**
     * Insert the domain object into the database
     *
     * @param Entity $object
     */
    abstract protected function insertObject(Entity $object);

    /**
     * Update the domain object in persistent storage
     *
     * @param Entity $object
     */
    abstract protected function updateObject(Entity $object);

    /**
     * Delete the domain object from persistent Storage
     *
     * @param Entity $object
     */
    abstract protected function deleteObject(Entity $object);
}
