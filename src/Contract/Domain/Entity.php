<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Domain;

use Exception;
use Prism\Library\Prism\Domain\Identifier\Identifier;

interface Entity
{
    /**
     * Get the ID of this object (unique to the object type)
     *
     * @return Identifier
     */
    public function getIdentifier(): Identifier;

    /**
     * Set the ID for this object.
     *
     * @param Identifier $identifier
     * @throws Exception If the id on the object is already set
     */
    public function setIdentifier(Identifier $identifier);
}
