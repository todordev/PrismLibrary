<?php
/**
 * @package      Prism
 * @subpackage   Dates
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

defined('JPATH_PLATFORM') or die;

/**
 * This is a class that provides functionality for managing dates.
 *
 * @package      Prism
 * @subpackage   Dates
 */
class Date extends \JDate
{
    /**
     * Return last date.
     *
     * <code>
     * $date = new PrismDate();
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
     * $date = new PrismDate();
     *
     * $beginOfDay = $date->getBeginOfDay();
     * </code>
     *
     * @return self
     */
    public function getBeginOfDay()
    {
        $day = clone $this;

        $day->setTime(0, 0, 0);

        return $day;
    }

    /**
     * Return the end of a day.
     *
     * <code>
     * $date = new PrismDate();
     *
     * $endOfDay = $date->getEndOfDay();
     * </code>
     *
     * @return self
     */
    public function getEndOfDay()
    {
        $day = clone $this;

        $day->setTime(0, 0, 0);

        $endOfDay = clone $day;
        $endOfDay->modify('tomorrow');
        $endOfDay->modify('1 second ago');

        return $endOfDay;
    }

    /**
     * Return a day of last week.
     *
     * <code>
     * $date = new PrismDate();
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
     * $date = new PrismDate();
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
     * $date = new PrismDate();
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
     * $date = new PrismDate();
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
     * $date = new PrismDate();
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
     * $date = new PrismDate();
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
     * $date = new PrismDate();
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
     * $date  = new PrismDate();
     *
     * $date1 = new PrismDate("now");
     * $date2 = new PrismDate("01-01-2020);
     *
     * $period = $date->getDaysPeriod($date1, $date2);
     * </code>
     *
     * @param \JDate $date1
     * @param \JDate $date2
     *
     * @return self
     */
    public function getDaysPeriod(\JDate $date1, \JDate $date2)
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
     * $date   = new PrismDate("now");
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
     * $date   = new PrismDate("05-06-2014");
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

        if ($startOfWeek <= $this and $this <= $endOfWeek) {
            return true;
        } else {
            return false;
        }
    }
}
