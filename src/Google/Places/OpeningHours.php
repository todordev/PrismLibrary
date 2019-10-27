<?php
/**
 * @package      Prism\Library\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Google\Places;

use Prism\Library\Domain\Hydration;

/**
 * Google Place Details.
 *
 * @package     Prism\Library\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/details
 */
class OpeningHours
{
    /**
     * @var array
     */
    protected $periods;

    public function hydrate(array $periods)
    {
        foreach ($periods as $period) {
            $this->periods[] = new Period($period);
        }
    }

    /**
     * @param Period $period
     *
     * @return self
     */
    public function addPeriod(Period $period): OpeningHours
    {
        $this->periods[] = $period;

        return $this;
    }

    public function __toString()
    {
        $result = array();

        foreach ($this->periods as $period) {
            $result[] = (string)$period;
        }

        return json_encode($result);
    }
}
