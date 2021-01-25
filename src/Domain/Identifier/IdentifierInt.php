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
 * Identifier by integer value.
 *
 * @package  Prism\Library\Prism\Domain\Identifier
 */
final class IdentifierInt implements Identifier
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The identifier must be greater than zero.');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
