<?php
/**
 * @package      Prism
 * @subpackage   Validations
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation;

use DateTime;
use Exception;

/**
 * This class validates date.
 *
 * @package      Prism
 * @subpackage   Validations
 */
class Date extends Validation
{
    /**
     * A date string.
     *
     * @var string
     */
    protected string $date;

    /**
     * Initialize the object.
     * <code>
     * $date = "01-01-2020";
     * $dateValidation = new Prism\Library\Prism\Validation\Date($date);
     * </code>
     *
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
     * Validate a date.
     *
     * <code>
     * $date = "01-01-2020";
     *
     * $dateValidation = new Prism\Library\Prism\Validation\Date($date);
     *
     * if (!$dateValidation->passes()) {
     * ...
     * }
     *
     * </code>
     *
     * @return bool
     */
    public function passes(): bool
    {
        // Check for default SQL values.
        $defaultDates = ['0000-00-00', '1000-01-01'];
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

            $string = '@' . $string;
        }

        try {
            $date = new DateTime($string);
        } catch (Exception) {
            return false;
        }

        $month = $date->format('m');
        $day   = $date->format('d');
        $year  = $date->format('Y');

        return (bool)checkdate($month, $day, $year);
    }

    public function fails(): bool
    {
        return !$this->passes();
    }
}
