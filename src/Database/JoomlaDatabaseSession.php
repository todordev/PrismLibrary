<?php
/**
 * @package      Prism
 * @subpackage   Database
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Database;

use Prism\Domain\TransactionalSession;

/**
 * Joomla database gateway for a session.
 *
 * @package      Prism
 * @subpackage   Database
 */
class JoomlaDatabaseSession implements TransactionalSession
{
    private $db;

    public function __construct(\JDatabaseDriver $db)
    {
        $this->db = $db;
    }

    public function executeAtomically(callable $operation)
    {
        $this->db->transactionStart();

        try {
            $operation();

            $this->db->transactionCommit();
        } catch (\Exception $e) {
            $this->db->transactionRollback();
        }
    }
}
