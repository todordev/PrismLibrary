<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Database\Mapper;

use Prism\Library\Prism\Contract\Database\ColumnsSelector;
use Prism\Library\Prism\Utility\ArrayHelper;

trait ColumnMethods
{
    /**
     * Prepare columns that will be used in a query.
     *
     * @param ColumnsSelector $request
     * @param array $required
     * @param string $alias
     * @return array
     */
    protected function prepareColumns(ColumnsSelector $request, array $required = [], string $alias = ''): array
    {
        $columns = [];
        if ($request->getColumns()) {
            $columns = ArrayHelper::clean($request->getColumns(), 'string');
            $columns = ArrayHelper::clean($columns, 'string');

            $columns = $this->mergeColumns($columns, $required);
        }

        array_walk($columns, function (&$value, $key, $prefix) {
            $value = $prefix . $value;
        }, $alias);

        return $columns;
    }

    /**
     * Merge columns that will be used in a query.
     *
     * @param array $columns
     * @param array $required
     * @param array $excluded
     * @return array
     */
    protected function mergeColumns(array $columns, array $required = [], array $excluded = []): array
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
