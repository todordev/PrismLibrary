<?php
/**
 * @package      Prism\Library\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
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
