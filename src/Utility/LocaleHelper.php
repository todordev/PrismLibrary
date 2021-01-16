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
 * This class provides methods for helping locale functionality.
 *
 * @package     Prism
 * @subpackage  Utility
 */
abstract class LocaleHelper
{
    /**
     * Prepare number formatter.
     *
     * <code>
     * $numberFormatter = Prism\Library\Prism\Utility\LocaleHelper::getNumberFormatter("#,##0.00");
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
