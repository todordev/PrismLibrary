<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

defined('JPATH_PLATFORM') or die;

/**
 * This is a class that provides functionality for managing dates.
 *
 * @package      Prism\Utilities
 * @subpackage   Dates
 */
abstract class DateHelper
{
    /**
     * The method returns a date format that can be used as calendar option.
     *
     * <code>
     * // Returns "YYYY-MM-DD".
     * $calendarFormat = Prism\Utilities\DateHelper::formatCalendarDate("Y-m-d");
     * </code>
     *
     * @param string $format PHP Date format.
     *
     * @return string
     */
    public static function formatCalendarDate($format)
    {
        $dateFormat = '';

        switch($format) {
            case 'Y-m-d':
                $dateFormat = 'YYYY-MM-DD';
                break;
            case 'd-m-Y':
                $dateFormat = 'DD-MM-YYYY';
                break;
            case 'm-d-Y':
                $dateFormat = 'MM-DD-YYYY';
                break;
        }

        return $dateFormat;
    }
}
