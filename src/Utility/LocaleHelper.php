<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\CMS\Language\Language;

/**
 * This class provides methods for helping locale functionality.
 *
 * @package Prism\Library\Prism\Utility
 */
final class LocaleHelper
{
    /**
     * Prepare number formatter.
     * <code>
     * $numberFormatter = LocaleHelper::getNumberFormatter("#,##0.00", $app->getLanguage());
     * </code>
     *
     * @param string $pattern
     * @param Language $language
     * @return \NumberFormatter
     */
    public static function getNumberFormatter(string $pattern, Language $language)
    {
        $numberFormatter  = new \NumberFormatter($language->getTag(), \NumberFormatter::PATTERN_DECIMAL, $pattern);

        return $numberFormatter;
    }
}
