<?php
/**
 * @package      Prism
 * @subpackage   Database
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database;

use Exception;
use Joomla\Database\DatabaseDriver;
use Prism\Library\Prism\Contract\Database\TransactionalSession;

/**
 * Joomla database gateway for a session.
 *
 * @package      Prism
 * @subpackage   Database
 */
class DatabaseSession implements TransactionalSession
{
    private DatabaseDriver $db;

    public function __construct(DatabaseDriver $db)
    {
        $this->db = $db;
    }

    public function executeAtomically(callable $operation): void
    {
        $this->db->transactionStart();

        try {
            $operation();

            $this->db->transactionCommit();
        } catch (Exception) {
            $this->db->transactionRollback();
        }
    }
}
