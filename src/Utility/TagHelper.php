<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Helper\CMSHelper;
use Joomla\Database\DatabaseDriver;
use Prism\Library\Prism\Constant\Status;
use Joomla\Utilities\ArrayHelper as JoomlaArrayHelper;

/**
 * This class provides methods used for interaction with the tags.
 *
 * @package Prism\Library\Prism\Utility
 */
final class TagHelper
{
    private array $itemTags = [];
    private CMSHelper $cmsHelper;
    private DatabaseDriver $db;

    public function __construct(CMSHelper $helper, DatabaseDriver $db)
    {
        $this->cmsHelper = $helper;
        $this->db = $db;
    }

    /**
     * Method to get a list of tags for an item, optionally with the tag data.
     *
     * <code>
     * $keys = array(1,2,3,4);
     *
     * $options = array(
     *     'content_type' => 'com_userideas.item',
     *     'access_groups' => \JFactory::getUser()->getAuthorisedViewLevels(),
     *     'language' => 'en_GB',
     *     'get_tag_data' => true
     * );
     *
     * $tagHelper = new TagHelper($keys, $options);
     * </code>
     *
     * @param   int|array  $keys
     * @param   array  $options
     *
     * @return  array Array of tag objects
     */
    public function getItemTags(int | array $keys, array $options = []): array
    {
        $contentType = JoomlaArrayHelper::getValue($options, 'content_type');
        if (!$contentType) {
            throw new \InvalidArgumentException(Text::_('LIB_PRISM_ERROR_INVALID_CONTENT_TYPE'));
        }

        if (is_array($keys)) {
            $keys = JoomlaArrayHelper::toInteger($keys);
            $keys = array_filter(array_unique($keys));
            $hash = md5(implode(',', $keys) . '_' . $contentType);
        } else {
            $keys = (int)$keys;
            $hash = md5($keys . '_' . $contentType);
        }

        if (!$keys) {
            throw new \InvalidArgumentException(Text::_('LIB_PRISM_ERROR_INVALID_KEYS'));
        }

        if (!array_key_exists($hash, $this->itemTags)) {
            $this->itemTags[$hash] = [];

            $groups = JoomlaArrayHelper::getValue($options, 'access_groups', [], 'array');
            if (!$groups) {
                throw new \InvalidArgumentException(Text::_('LIB_PRISM_ERROR_INVALID_ACCESS_GROUPS'));
            }

            $query = $this->db->getQuery(true);
            $query
                ->select('m.tag_id, m.content_item_id')
                ->from($this->db->quoteName('#__contentitem_tag_map', 'm'))
                ->where($this->db->quoteName('m.type_alias') . ' = ' . $this->db->quote($contentType));

            if (is_array($keys)) {
                $query->where($this->db->quoteName('m.content_item_id') . ' IN (' . implode(',', $keys) . ')');
            } else {
                $query->where($this->db->quoteName('m.content_item_id') . ' = ' . (int)$keys);
            }
            $query->where($this->db->quoteName('t.published') . ' = ' . Status::PUBLISHED);

            $query->where('t.access IN (' . implode(',', $groups) . ')');

            // Optionally filter on language
            $language = JoomlaArrayHelper::getValue($options, 'language', 'all', 'string');
            if ($language !== 'all') {
                if ($language === 'current_language') {
                    $language = $this->cmsHelper->getCurrentLanguage();
                }

                $query->where(
                    $this->db->quoteName('language') . '
                    IN (' . $this->db->quote($language) . ', ' . $this->db->quote('*') . ')'
                );
            }

            $getTagData = JoomlaArrayHelper::getValue($options, 'get_tag_data', true, 'bool');
            if ($getTagData) {
                $query->select($this->db->quoteName('t') . '.*');
            }

            $query->join(
                'INNER',
                $this->db->quoteName('#__tags', 't') .
                ' ON ' .
                $this->db->quoteName('m.tag_id') . ' = ' . $this->db->quoteName('t.id')
            );

            $this->db->setQuery($query);
            $tags = $this->db->loadObjectList();

            foreach ($tags as $value) {
                $this->itemTags[$hash][$value->content_item_id][] = $value;
            }
        }

        return  $this->itemTags[$hash];
    }
}
