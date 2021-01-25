<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

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
