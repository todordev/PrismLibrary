<?php
/**
 * @package      Prism
 * @subpackage   Validators
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validator;

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
     * $validator = new Prism\Library\Prism\Validator\Date($date);
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
     * $validator = new Prism\Library\Prism\Validator\Date($date);
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
        // Check for default SQL values.
        $defaultDates = array('0000-00-00', '1000-01-01');
        if (in_array($this->date, $defaultDates, true)) {
            return false;
        }

        $string = trim($this->date);
        if ($string === '') {
            return false;
        }

        if (is_numeric($string)) {
            $string = (int)$string;
            if ($string === 0) {
                return false;
            }

            $string = '@'.$string;
        }

        try {
            $date = new \DateTime($string);
        } catch (\Exception $e) {
            return false;
        }

        $month = $date->format('m');
        $day   = $date->format('d');
        $year  = $date->format('Y');

        return (bool)checkdate($month, $day, $year);
    }
}
