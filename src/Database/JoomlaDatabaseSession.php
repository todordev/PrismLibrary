<?php
/**
 * @package      Prism
 * @subpackage   Database
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database;

use Joomla\Database\DatabaseDriver;
use Prism\Library\Prism\Domain\TransactionalSession;

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
