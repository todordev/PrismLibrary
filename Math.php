<?php
/**
 * @package      Prism
 * @subpackage   Math
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for handling numbers.
 *
 * @package     Prism
 * @subpackage  Math
 */
class Math
{
    protected $result;

    /**
     * Calculate percentage from two values.
     *
     * <code>
     * $percent = new Prism\Math;
     * $percent->calculatePercentage(100, 1000);
     *
     * // Displays 10 ( 10% )
     * echo $percent;
     *
     * </code>
     *
     * @param int|float $value1
     * @param int|float  $value2
     * @param int  $decimalPoint
     */
    public function calculatePercentage($value1, $value2, $decimalPoint = 2)
    {
        if (($value1 == 0) or ($value2 == 0)) {
            $this->result = 0;
        } else {
            $value = ($value1 / $value2) * 100;
            $this->result = round($value, $decimalPoint);
        }
    }

    /**
     * Calculate a value from percent.
     *
     * <code>
     * $fee = "10"; // 10%
     * $amount = "100"; // $100
     *
     * $math = new Prism\Math();
     * $math->calculateValueFromPercent($fee, $amount);
     *
     * // Displays 10.00 ( $10.00 )
     * echo $percent;
     * </code>
     *
     * @param float $percent
     * @param float $value
     * @param int  $decimalPoint
     */
    public function calculateValueFromPercent($percent, $value, $decimalPoint = 2)
    {
        if (($percent == 0) or ($value == 0)) {
            $this->result = 0;
        } else {
            $value = ($percent / 100) * $value;
            $this->result = round($value, $decimalPoint);
        }
    }

    /**
     * Calculate total value.
     *
     * <code>
     * $values = array(10, 10);
     *
     * $total = new Prism\Math();
     * $total->calculateTotal($values);
     * echo $math;
     * </code>
     *
     * @param array $values
     * @param string  $action ( M = multiplication, S = calculate sum )
     * @param int  $decimalPoint
     */
    public function calculateTotal($values, $action = "M", $decimalPoint = 2)
    {
        $result = array_shift($values);

        switch ($action) {

            case "M":
                foreach ($values as $value) {
                    $result *=  $value;
                }
                break;

            case "S":
                foreach ($values as $value) {
                    $result +=  $value;
                }
                break;
        }

        $this->result = round($result, $decimalPoint);
    }

    /**
     * Return object value as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->result;
    }
}
