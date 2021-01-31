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
use Joomla\Registry\Registry;
use Prism\Library\Prism\Category\Category;
use Prism\Library\Prism\Category\CategoryEntity;
use Prism\Library\Prism\Contract\Database\CollectionFilters;
use Prism\Library\Prism\Utility\ArrayHelper;
use Joomla\Utilities\ArrayHelper as JoomlaArrayHelper;
use Prism\Library\Prism\Database\Mapper\ColumnMethods;
use Prism\Library\Prism\Database\Dto\ItemByIdRequest;
use Prism\Library\Prism\Domain\Identifier\IdentifierInt;
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

    public function fetchById(ItemByIdRequest $request): ?CategoryEntity
    {
        $query = $this->db->getQuery(true);

        // Prepare columns for retrieving.
        $columns = $this->prepareColumns($request, ['id']);
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
            $item = $this->populate($item, $result);
        }

        return $item;
    }

    public function fetchCollection(CategoryCollectionRequest $request): Collection
    {
        $items = collect([]);

        $ids = JoomlaArrayHelper::toInteger($request->getIdentifiers());
        $ids = array_filter($ids);
        if (!$ids) {
            return $items;
        }

        // Prepare columns for retrieving.
        $columns = $this->prepareColumns($request, ['id']);
        $columns = $columns ? $this->db->quoteName($columns) : '*';

        $query = $this->db->getQuery(true);
        $query
            ->select($columns)
            ->from($this->db->quoteName('#__categories'))
            ->whereIn($this->db->quoteName('id'), $ids);

        if ($request->getFilters()) {
            $this->assignFilters($query, $request->getFilters());
        }

        $this->db->setQuery($query);

        $results = $this->db->loadAssocList();
        if ($results) {
            foreach ($results as $result) {
                $item = $this->populate($result);

                $items->add($item);
            }
        }

        return $items;
    }

    /**
     * Hydrate data to the object.
     *
     * @param array $result
     * @return CategoryEntity
     */
    private function populate(array $result): CategoryEntity
    {
        $title = JoomlaArrayHelper::getValue($result, 'title', '', 'string');
        $alias = JoomlaArrayHelper::getValue($result, 'alias', '', 'string');
        $description = JoomlaArrayHelper::getValue($result, 'description', '', 'string');
        $published = JoomlaArrayHelper::getValue($result, 'published', '', 'int');
        $access = JoomlaArrayHelper::getValue($result, 'access', '', 'int');
        $userId = JoomlaArrayHelper::getValue($result, 'created_user_id', '', 'int');
        $params = JoomlaArrayHelper::getValue($result, 'params', '', 'string');
        $params = new Registry($params);

        $slug = $result['id'] . ':' . $alias;

        $category = new Category($title, $alias, $slug, $description, $published, $access, $userId, $params);

        return new CategoryEntity(
            new IdentifierInt($result['id']),
            $category
        );
    }

    /**
     * @param DatabaseQuery $query
     * @param CollectionFilters $filters
     *
     * @since version
     */
    private function assignFilters(DatabaseQuery $query, CollectionFilters $filters): void
    {
        // Filter by extension name.
        if ($filters->getExtensions()) {
            $extensions = ArrayHelper::clean($filters->getExtensions(), 'string');

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
        if ($filters->getState()) {
            $boundStatus = $filters->getState();
            $query
                ->where($this->db->quoteName('published') . '= :published')
                ->bind(':published', $boundStatus, ParameterType::INTEGER);
        }

        if ($filters->getLimit()) {
            if ($filters->getOffset()) {
                $query->setLimit($filters->getLimit(), $filters->getOffset());
            } else {
                $query->setLimit($filters->getLimit());
            }
        }
    }
}
