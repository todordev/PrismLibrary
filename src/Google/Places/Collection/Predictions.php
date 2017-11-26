<?php
/**
 * @package      Prism\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Google\Places\Collection;

use Prism\Domain\Collection;
use Prism\Google\Places\Prediction;

/**
 * Collection of Google Place predictions.
 *
 * @package     Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/autocomplete
 */
class Predictions extends Collection
{
    public function hydrate(array $predictions)
    {
        foreach ($predictions as $predictionData) {
            $prediction = new Prediction();
            $prediction->bind($predictionData);

            $this->items[] = $prediction;
        }
    }
}
