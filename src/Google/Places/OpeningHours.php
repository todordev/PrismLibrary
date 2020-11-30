<?php
/**
 * @package      Prism\Library\Prism\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Google\Places;

use Prism\Library\Prism\Domain\Hydration;

/**
 * Google Place Details.
 *
 * @package     Prism\Library\Prism\Google
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
