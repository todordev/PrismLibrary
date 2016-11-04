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
 * This class contains methods that are used for handling numbers.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class MathHelper
{
    /**
     * Calculate percentage from two values.
     *
     * <code>
     * // Displays 10 ( 10% )
     * echo Prism\Utilities\MathHelper::calculatePercentage(100, 1000);
     *
     * </code>
     *
     * @param float $value1
     * @param float $value2
     * @param int   $decimalPoint
     *
     * @return float $result
     */
    public static function calculatePercentage($value1, $value2, $decimalPoint = 2)
    {
        $value1 = (float)$value1;
        $value2 = (float)$value2;

        $result = 0.0;

        if (($value1 !== 0.0) and ($value2 !== 0.0)) {
            $value  = ($value1 / $value2) * 100;
            $result = round($value, $decimalPoint);
        }

        return $result;
    }

    /**
     * Calculate a value from percent.
     *
     * <code>
     * $fee = "10"; // 10%
     * $amount = "100"; // $100
     *
     * // Displays 10.00 ( $10.00 )
     * echo Prism\Utilities\MathHelper::calculateValueFromPercent($fee, $amount);;
     * </code>
     *
     * @param float $percent
     * @param float $value
     * @param int   $decimalPoint
     *
     * @return float
     */
    public static function calculateValueFromPercent($percent, $value, $decimalPoint = 2)
    {
        $percent = (float)$percent;
        $value   = (float)$value;

        $result = 0.0;

        if (($percent !== 0.0) and ($value !== 0.0)) {
            $value  = ($percent / 100) * $value;
            $result = round($value, $decimalPoint);
        }

        return $result;
    }

    /**
     * Calculate total value.
     *
     * <code>
     * $values = array(10, 10);
     *
     * echo Prism\Utilities\MathHelper::calculateTotal($values);
     * </code>
     *
     * @param array  $values
     * @param string $action ( M = multiplication, S = calculate sum )
     * @param int    $decimalPoint
     *
     * @return float
     */
    public static function calculateTotal($values, $action = 'M', $decimalPoint = 2)
    {
        $result = (float)array_shift($values);

        switch ($action) {
            case 'M': // multiplication
                foreach ($values as $value) {
                    $result *= (float)$value;
                }
                break;

            case 'S': // sum
                foreach ($values as $value) {
                    $result += (float)$value;
                }
                break;
        }

        return round($result, $decimalPoint);
    }

    /**
     * Convert KB, MB, GB, TB, PB to bytes.
     *
     * <code>
     * $values = 5; // 5MB
     *
     * echo Prism\Utilities\MathHelper::convertToBytes($values, 'MB');
     * </code>
     *
     * @param int  $value
     * @param string $from
     *
     * @return int
     */
    public static function convertToBytes($value, $from)
    {
        $from   = strtoupper($from);
        switch ($from) {
            case 'KB':
                return $value * 1024;
            case 'MB':
                return $value * pow(1024, 2);
            case 'GB':
                return $value * pow(1024, 3);
            case 'TB':
                return $value * pow(1024, 4);
            case 'PB':
                return $value * pow(1024, 5);
            default:
                return $value;
        }
    }

    /**
     * Convert bytes to KB, MB, GB, TB, PB.
     *
     * <code>
     * $values = 5242880; // 5MB
     *
     * echo Prism\Utilities\MathHelper::convertFromBytes($values, 'MB');
     * </code>
     *
     * @param int  $bytes
     * @param int $precision
     *
     * @return int
     */
    public static function convertFromBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
