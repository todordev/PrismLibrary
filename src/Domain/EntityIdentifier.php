<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

use BadMethodCallException;

trait EntityIdentifier
{
    protected Identifier $identifier;

    /**
     * Get the ID of this object (unique to the object type)
     *
     * @return Identifier
     */
    public function getIdentifier(): Identifier
    {
        return $this->identifier;
    }

    /**
     * Set the ID for this object.
     *
     * @param Identifier $identifier
     */
    public function setIdentifier(Identifier $identifier): void
    {
        if ($this->identifier) {
            throw new BadMethodCallException('The identifier for this entity has already been set.');
        }

        $this->identifier = $identifier;
    }
}
