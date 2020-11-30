<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

use Prism\Library\Prism\Database\Request\Request;

/**
 * @package     Prism\Library\Prism\Domain
 *
 * @deprecated
 */
abstract class Repository
{
    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * Set a mapper.
     *
     * @param Mapper $mapper
     */
    public function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param Request $request
     *
     * @return Entity
     */
    abstract public function fetch(Request $request);

    /**
     * @param int $id
     * @param Request $request
     *
     * @return Entity
     */
    abstract public function fetchById($id, Request $request = null);
}
