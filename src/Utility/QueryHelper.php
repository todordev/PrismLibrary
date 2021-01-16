<?php
/**
 * @package      Prism
 * @subpackage   Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides methods used in the process of preparing database query.
 *
 * @package     Prism
 * @subpackage  Utility
 */
abstract class QueryHelper
{
    /**
     * Translate an order code to a field for primary category ordering.
     *
     * @param   string $orderBy The ordering code.
     *
     * @return  string  The SQL field(s) to order by.
     */
    public static function orderbyPrimary($orderBy)
    {
        switch ($orderBy) {
            case 'alpha':
                $orderBy = 'c.path';
                break;

            case 'ralpha':
                $orderBy = 'c.path DESC';
                break;

            case 'order':
                $orderBy = 'c.lft';
                break;

            default:
                $orderBy = '';
                break;
        }

        return $orderBy;
    }
}
