<?php
/**
 * @package      Prism\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Google\Places;

/**
 * Google Place Open Hours Period.
 *
 * @package     Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/details
 */
class Period
{
    protected $open;
    protected $close;

    public function __construct(array $period)
    {
        $this->open  = array_key_exists('open', $period) ? $period['open'] : null;
        $this->close = array_key_exists('close', $period) ? $period['close'] : null;
    }

    public function __toString()
    {
        return json_encode([
            'open'  => $this->open,
            'close' => $this->close
        ]);
    }
}
