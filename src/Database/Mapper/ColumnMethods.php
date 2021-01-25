<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Mapper;

trait ColumnMethods
{
    /**
     * Prepare columns that will be used in a query.
     *
     * @param array $columns
     * @param array $required
     * @param array $excluded
     * @return array
     */
    public function prepareColumns(array $columns, array $required = [], array $excluded = []): array
    {
        if (count($columns) > 0) {
            if ($required) {
                $columns = array_merge($columns, $required);
            }

            if ($excluded) {
                $columns = array_diff($columns, $excluded);
            }
        }

        return array_unique($columns);
    }
}
