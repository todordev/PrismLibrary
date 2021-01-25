<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Money;

/**
 * Currency interface.
 *
 * @package      Prism
 * @subpackage   Money
 */
interface LegalTender
{
    public function getName();
    public function getCode();
    public function getSymbol();
    public function getPosition();
    public function equals(LegalTender $other);
    public function symbolLeft();
    public function symbolRight();
}
