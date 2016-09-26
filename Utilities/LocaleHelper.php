<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides methods for helping locale functionality.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class LocaleHelper
{
    /**
     * Prepare number formatter.
     *
     * <code>
     * $numberFormatter = Prism\Utilities\LocaleHelper::getNumberFormatter("#,##0.00");
     * </code>
     *
     * @param string $pattern
     *
     * @return \NumberFormatter
     */
    public static function getNumberFormatter($pattern)
    {
        $language         = \JFactory::getLanguage();
        $numberFormatter  = new \NumberFormatter($language->getTag(), \NumberFormatter::PATTERN_DECIMAL, $pattern);

        return $numberFormatter;
    }
}
