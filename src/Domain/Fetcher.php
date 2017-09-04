<?php
/**
 * @package         Prism
 * @subpackage      Domain
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

use Prism\Database\Request\Request;

/**
 * Interface with main fetch methods.
 *
 * @package Prism\Domain
 */
interface Fetcher
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
}
