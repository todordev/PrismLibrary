<?php
/**
 * @package      Prism
 * @subpackage   Money
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Money;

defined('JPATH_PLATFORM') or die;

/**
 * This is the currency interface.
 *
 * @package      Prism
 * @subpackage   Money
 */
interface CurrencyInterface
{
    public function getId();
    public function getTitle();
    public function getCode();
    public function getSymbol();
    public function getPosition();
}
