<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

use Prism\Library\Database\Request\Request;

/**
 * Interfaces for fetching data including the method for fetching collection.
 *
 * @package Prism\Library\Domain
 */
interface RichFetcher
{
    /**
     * Return an item by its ID.
     *
     * @param int $id
     * @param Request $request
     *
     * @return array
     */
    public function fetchById($id, Request $request = null);

    /**
     * Return an item filtering the result by conditions.
     *
     * @param Request $request
     *
     * @return array
     */
    public function fetch(Request $request);

    /**
     * Return collection of items filtering the results by conditions.
     *
     * @param Request $request
     *
     * @return Collection
     */
    public function fetchCollection(Request $request);
}
