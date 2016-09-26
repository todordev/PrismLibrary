<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
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
     * Check if it is default SQL Date.
     *
     * <code>
     * if (Prism\Utilities\DateHelper::isDefault("1000-01-001")) {
     * //...
     * }
     * </code>
     *
     * @param string $date
     *
     * @return bool
     */
    public static function isDefault($date)
    {
        $defaultDates = array('0000-00-00', '1000-01-01');

        return in_array($date, $defaultDates, true);
    }

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
        switch ($format) {
            case 'Y-m-d':
                $dateFormat = 'YYYY-MM-DD';
                break;
            case 'd-m-Y':
                $dateFormat = 'DD-MM-YYYY';
                break;
            case 'm-d-Y':
                $dateFormat = 'MM-DD-YYYY';
                break;
            default:
                $dateFormat = 'YYYY-MM-DD';
                break;
        }

        return $dateFormat;
    }

    /**
     * Convert PHP datetime format to JavaScript format,
     * used from JS library Moment.
     * It is used from Bootstrap 3 datepicker.
     *
     * @param $format
     *
     * @return string
     */
    public static function convertToMomentJsFormat($format)
    {
        $symbols  = array(
            // Day
            'd' => 'DD',
            'j' => 'D',
            'D' => 'ddd',
            'l' => 'dddd',
            'S' => 'Do',
            'z' => 'DDD',
            // Week
            'W' => '',
            // Month
            'F' => 'MMMM',
            'm' => 'MM',
            'M' => 'MMM',
            'n' => 'M',
            // Year
            'Y' => 'YYYY',
            'y' => 'YY',
            // Time
            'a' => 'a',
            'A' => 'A',
            'g' => 'h',
            'G' => 'H',
            'h' => 'hh',
            'H' => 'HH',
            'i' => 'mm',
            's' => 'ss',
            'u' => 'X'
        );
        $jsFormat = '';
        $escaping = false;
        for ($i = 0, $max = strlen($format); $i < $max; $i++) {
            $char = $format[$i];

            // PHP date format escaping character
            if ($char === '\\') {
                $i++;
                if ($escaping) {
                    $jsFormat .= $format[$i];
                } else {
                    $jsFormat .= '\'' . $format[$i];
                }
                $escaping = true;
            } else {
                if ($escaping) {
                    $jsFormat .= "'";
                    $escaping = false;
                }
                if (array_key_exists($char, $symbols)) {
                    $jsFormat .= $symbols[$char];
                } else {
                    $jsFormat .= $char;
                }
            }
        }

        return $jsFormat;
    }

    /**
     * Convert PHP datetime format to JavaScript format,
     * used from JS library Moment.
     * It is used from Bootstrap 3 datepicker.
     *
     * @param $format
     *
     * @return string
     */
    public static function convertFromMomentToPhpFormat($format)
    {
        $symbols  = array(
            // Day
            'DD'   => 'd',
            'D'    => 'j',
            'ddd'  => 'D',
            'dddd' => 'l',
            'Do'   => 'S',
            'DDD'  => 'z',
            // Month
            'MMMM' => 'F',
            'MM'   => 'm',
            'MMM'  => 'M',
            'M'    => 'n',
            // Year
            'YYYY' => 'Y',
            'YY'   => 'y',
            // Time
            'a'    => 'a',
            'A'    => 'A',
            'h'    => 'g',
            'H'    => 'G',
            'hh'   => 'h',
            'HH'   => 'H',
            'mm'   => 'i',
            'ss'   => 's',
            'X'    => 'u'
        );
        $jsFormat = '';
        $escaping = false;
        for ($i = 0, $max = strlen($format); $i < $max; $i++) {
            $char = $format[$i];

            // PHP date format escaping character
            if ($char === '\\') {
                $i++;
                if ($escaping) {
                    $jsFormat .= $format[$i];
                } else {
                    $jsFormat .= '\'' . $format[$i];
                }
                $escaping = true;
            } else {
                if ($escaping) {
                    $jsFormat .= "'";
                    $escaping = false;
                }
                if (array_key_exists($char, $symbols)) {
                    $jsFormat .= $symbols[$char];
                } else {
                    $jsFormat .= $char;
                }
            }
        }

        return $jsFormat;
    }
}
