<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Domain;

trait Reset
{
    public function reset()
    {
        $parameters = get_object_vars($this);

        foreach ($parameters as $key => $value) {
            $this->$key = null;
        }
    }
}
