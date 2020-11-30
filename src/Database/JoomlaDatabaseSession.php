<?php
/**
 * @package      Prism
 * @subpackage   Database
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Database;

use Joomla\Database\DatabaseDriver;
use Prism\Library\Domain\TransactionalSession;

/**
 * Joomla database gateway for a session.
 *
 * @package      Prism
 * @subpackage   Database
 */
class JoomlaDatabaseSession implements TransactionalSession
{
    private $db;

    public function __construct(DatabaseDriver $db)
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
