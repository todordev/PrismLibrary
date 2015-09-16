<?php
/**
 * @package      Prism
 * @subpackage   Validators
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Validator;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class validates date.
 *
 * @package      Prism
 * @subpackage   Validators
 */
class Date implements ValidatorInterface
{
    /**
     * A date string.
     *
     * @var string
     */
    protected $date;

    /**
     * Initialize the object.
     *
     * <code>
     * $date = "01-01-2020";
     *
     * $validator = new Prism\Validator\Date($date);
     * </code>
     *
     * @param string $date
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Validate a date.
     *
     * <code>
     * $date = "01-01-2020";
     *
     * $validator = new Prism\Validator\Date($date);
     *
     * if (!$validator->isValid()) {
     * ...
     * }
     *
     * </code>
     *
     * @return bool
     */
    public function isValid()
    {
        $string = \JString::trim($this->date);
        if (is_numeric($string)) {
            $string = "@".$string;
        }

        try {
            $date = new \DateTime($string);
        } catch (\Exception $e) {
            return false;
        }

        $month = $date->format('m');
        $day   = $date->format('d');
        $year  = $date->format('Y');

        if (checkdate($month, $day, $year)) {
            return true;
        } else {
            return false;
        }
    }
}
