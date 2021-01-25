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
 * Identifier by Uuid value.
 *
 * @package  Prism\Library\Prism\Domain\Identifier
 */
final class IdentifierUuid implements Identifier
{
    private string $value;

    public function __construct(string $value)
    {
        if (!preg_match('/^[[:xdigit:]]{8}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{12}$/i', $value)) {
            throw new \InvalidArgumentException('The identifier must be valid UUID value.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
