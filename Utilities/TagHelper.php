<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

use Joomla\Utilities\ArrayHelper as JArrayHelper;
use Prism\Constants;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides methods used for interaction with the tags.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
class TagHelper extends \JHelper
{
    protected $itemTags = array();

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
     * @return  array    Array of tag objects
     */
    public function getItemTags($keys, array $options = array())
    {
        $contentType = JArrayHelper::getValue($options, 'content_type');
        if (!$contentType) {
            throw new \InvalidArgumentException(\JText::_('LIB_PRISM_ERROR_INVALID_CONTENT_TYPE'));
        }

        if (is_array($keys)) {
            $keys = JArrayHelper::toInteger($keys);
            $keys = array_filter(array_unique($keys));
            $hash = md5(implode(',', $keys) .'_'.$contentType);
        } else {
            $keys = (int)$keys;
            $hash = md5($keys .'_'.$contentType);
        }

        if (!$keys) {
            throw new \InvalidArgumentException(\JText::_('LIB_PRISM_ERROR_INVALID_KEYS'));
        }

        if (!array_key_exists($hash, $this->itemTags)) {
            $this->itemTags[$hash] = array();
            
            $groups = JArrayHelper::getValue($options, 'access_groups', array(), 'array');
            if (!$groups) {
                throw new \InvalidArgumentException(\JText::_('LIB_PRISM_ERROR_INVALID_ACCESS_GROUPS'));
            }

            // Initialize some variables.
            $db    = \JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
                ->select('m.tag_id, m.content_item_id')
                ->from($db->quoteName('#__contentitem_tag_map', 'm'))
                ->where($db->quoteName('m.type_alias') . ' = ' . $db->quote($contentType));

            if (is_array($keys)) {
                $query->where($db->quoteName('m.content_item_id') . ' IN (' . implode(',', $keys) . ')');
            } else {
                $query->where($db->quoteName('m.content_item_id') . ' = ' . (int)$keys);
            }
            $query->where($db->quoteName('t.published') . ' = ' . Constants::PUBLISHED);

            $query->where('t.access IN (' . implode(',', $groups) . ')');

            // Optionally filter on language
            $language = JArrayHelper::getValue($options, 'language', 'all', 'string');
            if ($language !== 'all') {
                if ($language === 'current_language') {
                    $language = $this->getCurrentLanguage();
                }

                $query->where($db->quoteName('language') . ' IN (' . $db->quote($language) . ', ' . $db->quote('*') . ')');
            }

            $getTagData = JArrayHelper::getValue($options, 'get_tag_data', true, 'bool');
            if ($getTagData) {
                $query->select($db->quoteName('t') . '.*');
            }

            $query->join('INNER', $db->quoteName('#__tags', 't') . ' ON ' . $db->quoteName('m.tag_id') . ' = ' . $db->quoteName('t.id'));

            $db->setQuery($query);
            $tags = $db->loadObjectList();

            foreach ($tags as $value) {
                $this->itemTags[$hash][$value->content_item_id][] = $value;
            }
        }

        return  $this->itemTags[$hash];
    }
}
