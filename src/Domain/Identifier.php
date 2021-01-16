<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

final class Identifier
{
    private string $name;
    private int | string $value;

    public function __construct(string $name, int | string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function value(): int | string
    {
        return $this->value;
    }

    public function name(): string
    {
        return $this->name;
    }
}
