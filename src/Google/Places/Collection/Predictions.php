<?php
/**
 * @package      Prism\Library\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Google\Places\Collection;

use Prism\Library\Domain\Collection;
use Prism\Library\Google\Places\Prediction;

/**
 * Collection of Google Place predictions.
 *
 * @package     Prism\Library\Google
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
