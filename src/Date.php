<?php
/**
 * @package      Prism
 * @subpackage   Dates
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library;

/**
 * This is a class that provides functionality for managing dates.
 *
 * @package      Prism
 * @subpackage   Dates
 */
class Date extends \DateTime
{
    /**
     * Return last date.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $yesterday = $date->getLastDay();
     * </code>
     *
     * @return self
     */
    public function getLastDay()
    {
        $day = clone $this;
        $day->modify('yesterday');

        return $day;
    }

    /**
     * Return the begin of a day.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $beginOfDay = $date->getBeginOfDay();
     * </code>
     *
     * @return self
     */
    public function getBeginOfDay()
    {
        $day = clone $this;

        $day->setTime(0, 0);

        return $day;
    }

    /**
     * Return the end of a day.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $endOfDay = $date->getEndOfDay();
     * </code>
     *
     * @return self
     */
    public function getEndOfDay()
    {
        $day = clone $this;

        $day->setTime(0, 0);

        $endOfDay = clone $day;
        $endOfDay->modify('tomorrow');
        $endOfDay->modify('1 second ago');

        return $endOfDay;
    }

    /**
     * Return a day of last week.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $lastWeekDay = $date->getLastWeek();
     * </code>
     *
     * @return self
     */
    public function getLastWeek()
    {
        $day = clone $this;
        $day->modify('7 days ago');

        return $day;
    }

    /**
     * Return the first day of last week.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $beginOfWeek = $date->getBeginOfWeek();
     * </code>
     *
     * @return self
     */
    public function getBeginOfWeek()
    {
        $monday = clone $this;
        $monday->modify(('Sunday' === $monday->format('l')) ? 'Monday last week' : 'Monday this week');

        return $monday;
    }

    /**
     * Return the last day of last week.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $endOfWeek = $date->getEndOfWeek();
     * </code>
     *
     * @return self
     */
    public function getEndOfWeek()
    {
        $sunday = clone $this;
        $sunday->modify('Sunday this week');

        return $sunday;
    }

    /**
     * Return the first day of a month.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $beginOfMonth = $date->getBeginOfMonth();
     * </code>
     *
     * @return self
     */
    public function getBeginOfMonth()
    {
        $firstDay = clone $this;
        $firstDay->modify('first day of this month');

        return $firstDay;
    }

    /**
     * Return the last day of a month.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $endOfMonth = $date->getEndOfMonth();
     * </code>
     *
     * @return self
     */
    public function getEndOfMonth()
    {
        $lastDay = clone $this;
        $lastDay->modify('last day of this month');

        return $lastDay;
    }

    /**
     * Return the first day of an year.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $beginOfYear = $date->getBeginOfYear();
     * </code>
     *
     * @return self
     */
    public function getBeginOfYear()
    {
        // Get the current year.
        $year     = clone $this;
        $thisYear = $year->format('Y');

        $firstDay = clone $this;
        $firstDay->modify('first day of January '.$thisYear);

        return $firstDay;
    }

    /**
     * Return the last day of an year.
     *
     * <code>
     * $date = new Prism\Library\Date();
     *
     * $endOfYear = $date->getEndOfYear();
     * </code>
     *
     * @return self
     */
    public function getEndOfYear()
    {
        // Get the current year.
        $year     = clone $this;
        $thisYear = $year->format('Y');

        $lastDay = clone $this;
        $lastDay->modify('last day of December '. $thisYear);

        return $lastDay;
    }

    /**
     * Return a period between two dates in days.
     *
     * <code>
     * $date  = new Prism\Library\Date();
     *
     * $date1 = new Prism\Library\Date("now");
     * $date2 = new Prism\Library\Date("01-01-2020);
     *
     * $period = $date->getDaysPeriod($date1, $date2);
     * </code>
     *
     * @param \DateTime $date1
     * @param \DateTime $date2
     *
     * @return \DatePeriod
     *
     * @throws \Exception
     */
    public function getDaysPeriod(\DateTime $date1, \DateTime $date2)
    {
        $period = new \DatePeriod(
            $date1,
            new \DateInterval('P1D'),
            $date2
        );

        return $period;
    }

    /**
     * Calculate end date from starting one and some days.
     *
     * <code>
     * $days   = 30;
     *
     * $date   = new Prism\Library\Date("now");
     *
     * $endDate = $date->calculateEndDate();
     * </code>
     *
     * @param int    $days This is period in days.
     *
     * @return self
     */
    public function calculateEndDate($days)
    {
        $endDate = clone $this;
        $endDate->modify('+' . (int)$days . ' days');

        return $endDate;
    }

    /**
     * Check whether the date is part of the current week.
     *
     * <code>
     * $date   = new Prism\Library\Date("05-06-2014");
     *
     * if ($date->isCurrentWeekDay()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isCurrentWeekDay()
    {
        $today        = new Date();
        $startOfWeek  = $today->getBeginOfWeek();
        $endOfWeek    = $today->getEndOfWeek();

        return ($startOfWeek <= $this and $this <= $endOfWeek);
    }
}
