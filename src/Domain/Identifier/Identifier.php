<?php
/**
 * @package      Prism\Library\Prism\Domain
 * @subpackage   Identifier
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain\Identifier;

/**
 * Interface of identifier.
 *
 * @package  Prism\Library\Prism\Domain\Identifier
 */
interface Identifier
{
    public function getValue(): int | string;
}
