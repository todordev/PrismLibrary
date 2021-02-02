<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

/**
 * This class contains methods that are used for handling numbers.
 *
 * @package Prism\Library\Prism\Utility
 */
final class MathHelper
{
    /**
     * Calculate X is what percent of Y.
     * <code>
     * // Displays 10 ( 10% )
     * echo MathHelper::calculatePercentage(100, 1000);
     * </code>
     *
     * @param float|int $x
     * @param float|int $y
     * @param int $decimalPoint
     * @return float | int
     */
    public static function calculatePercentage(float | int $x, float | int $y, int $decimalPoint = 2): float | int
    {
        $result = 0.0;

        if (($x > 0) && ($y > 0)) {
            $value  = ($x / $y) * 100;
            $result = round($value, $decimalPoint);
        }

        return $result;
    }

    /**
     * Calculate percent of value.
     * <code>
     * $fee = "10"; // 10%
     * $amount = "100"; // $100
     * echo MathHelper::calculateValueFromPercent($fee, $amount);;
     * </code>
     *
     * @param float|int $percent
     * @param float|int $value
     * @param int $decimalPoint
     * @return float | int
     */
    public static function calculateValueFromPercent(float | int $percent, float | int $value, $decimalPoint = 2): float | int
    {
        $result = 0.0;

        if (($percent > 0) && ($value > 0)) {
            $value  = ($percent / 100) * $value;
            $result = round($value, $decimalPoint);
        }

        return $result;
    }

    /**
     * Calculate total value.
     *
     * <code>
     * $values = [10, 10];
     *
     * echo MathHelper::calculateTotal($values);
     * </code>
     *
     * @param array  $values
     * @param string $action ( M = multiplication, S = calculate sum )
     * @param int    $decimalPoint
     *
     * @return float
     */
    public static function calculateTotal(array $values, string $action = 'M', int $decimalPoint = 2)
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
     * echo Prism\Library\Prism\Utility\MathHelper::convertToBytes($values, 'MB');
     * </code>
     *
     * @param int  $value
     * @param string $from
     *
     * @return float | int
     */
    public static function convertToBytes(int $value, string $from): float | int
    {
        $from   = strtoupper($from);
        return match ($from) {
            'KB' => $value * 1024,
            'MB' => $value * (1024 ** 2),
            'GB' => $value * (1024 ** 3),
            'TB' => $value * (1024 ** 4),
            'PB' => $value * (1024 ** 5),
            default => $value
        };
    }

    /**
     * Convert bytes to KB, MB, GB, TB, PB.
     *
     * <code>
     * $values = 5242880; // 5MB
     *
     * echo MathHelper::convertFromBytes($values, 'MB');
     * </code>
     *
     * @param int $bytes
     * @param int $precision
     *
     * @return float | int
     */
    public static function convertFromBytes(int $bytes, int $precision = 2): float | int
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
