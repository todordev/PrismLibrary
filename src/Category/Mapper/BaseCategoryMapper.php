<?php
/**
 * @package      Prism\Library\Prism\Category
 * @subpackage   Mapper
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Category\Mapper;

use Illuminate\Support\Collection;
use Joomla\Database\DatabaseQuery;
use Joomla\Database\ParameterType;
use Joomla\Database\DatabaseDriver;
use Prism\Library\Prism\Category\Category;
use Prism\Library\Prism\Utility\ArrayHelper;
use Joomla\Utilities\ArrayHelper as JoomlaArrayHelper;
use Prism\Library\Prism\Database\Mapper\ColumnMethods;
use Prism\Library\Prism\Database\Dto\ItemByIdRequest;
use Prism\Library\Prism\Domain\Identifier\IdentifierInt;
use Prism\Library\Prism\Category\Dto\CategoryCollectionFilters;
use Prism\Library\Prism\Category\Dto\CategoryCollectionRequest;

/**
 * Base category mapper.
 *
 * @package      Prism\Library\Prism\Category
 * @subpackage   Mapper
 */
final class BaseCategoryMapper implements CategoryMapper
{
    use ColumnMethods;

    /**
     * @var DatabaseDriver
     */
    private DatabaseDriver $db;

    public function __construct(DatabaseDriver $db)
    {
        $this->db = $db;
    }

    public function fetchById(ItemByIdRequest $request): ?Category
    {
        $query = $this->db->getQuery(true);

        // Prepare columns for retrieving.
        $columns = [];
        if ($request->getColumns()) {
            $columns = $request->getColumns();
            $columns = ArrayHelper::clean($columns, 'string');

            $columns = $this->prepareColumns($columns, ['id']);
        }
        $columns = $columns ? $this->db->quoteName($columns) : '*';

        $query
            ->select($columns)
            ->from($this->db->quoteName('#__categories'))
            ->where($this->db->quoteName('id') . ' = ' . $request->getIdentifier())
            ->setLimit(1);

        $this->db->setQuery($query);

        $result = $this->db->loadAssoc();

        $item = null;
        if ($result) {
            $item = new Category(new IdentifierInt($result['id']));
            $this->populate($item, $result);
        }

        return $item;
    }

    public function fetchCollection(CategoryCollectionRequest $request): Collection
    {
        $items = collect([]);

        $ids = JoomlaArrayHelper::toInteger($request->identifiers());
        $ids = array_filter($ids);
        if (!$ids) {
            return $items;
        }

        $query = $this->db->getQuery(true);

        // Prepare columns for retrieving.
        $columns = [];
        if ($request->columns()) {
            $columns = ArrayHelper::clean($request->columns());
            $columns = $this->prepareColumns($columns, ['id']);
        }
        $columns = $columns ? $this->db->quoteName($columns) : '*';

        $query
            ->select($columns)
            ->from($this->db->quoteName('#__categories'))
            ->whereIn($this->db->quoteName('id'), $ids);

        if ($request->filters()) {
            $this->assignFilters($query, $request->filters());
        }

        $this->db->setQuery($query);

        $results = $this->db->loadAssocList();

        if ($results) {
            foreach ($results as $result) {
                $item = new Category(new IdentifierInt($result['id']));
                $this->populate($item, $result);

                $items->add($item);
            }
        }

        return $items;
    }

    /**
     * Hydrate data to the object.
     *
     * @param Category $item
     * @param array $result
     */
    private function populate(Category $item, array $result): void
    {
        if (array_key_exists('title', $result)) {
            $item->setTitle($result['title']);
        }
    }

    /**
     * @param DatabaseQuery $query
     * @param CategoryCollectionFilters $filters
     *
     * @since version
     */
    private function assignFilters(DatabaseQuery $query, CategoryCollectionFilters $filters): void
    {
        // Filter by extension name.
        if ($filters->extensions()) {
            $extensions = ArrayHelper::clean($filters->extensions(), 'string');

            // Filter by multiple values.
            if (count($extensions) > 1) {
                $query->whereIn($this->db->quoteName('extension'), $extensions, ParameterType::STRING);
            }

            // Filter by single value.
            if (count($extensions) === 1) {
                $boundExtension = array_key_first($extensions);
                $query
                    ->where($this->db->quoteName('extension') . '= :extension')
                    ->bind(':extension', $boundExtension, ParameterType::INTEGER);
            }
        }

        // Filter by state.
        if ($filters->state()) {
            $boundStatus = $filters->state();
            $query
                ->where($this->db->quoteName('published') . '= :published')
                ->bind(':published', $boundStatus, ParameterType::INTEGER);
        }

        if ($filters->limit()) {
            if ($filters->offset()) {
                $query->setLimit($filters->limit(), $filters->offset());
            } else {
                $query->setLimit($filters->limit());
            }
        }
    }
}
