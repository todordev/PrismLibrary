<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Money;

/**
 * Currency interface.
 *
 * @package      Prism
 * @subpackage   Money
 */
interface LegalTender
{
    public function getTitle();
    public function getCode();
    public function getSymbol();
    public function getPosition();
    public function equals(LegalTender $other);
    public function symbolAfter();
    public function symbolBefore();
}
