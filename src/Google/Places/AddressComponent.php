<?php
/**
 * @package      Prism\Library\Prism\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Google\Places;

use Prism\Library\Prism\Domain\Entity;
use Prism\Library\Prism\Domain\EntityId;
use Joomla\Registry\Registry;
use Prism\Library\Prism\Domain\EntityPopulating;

/**
 * Google Place Details.
 *
 * @package     Prism\Library\Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/details
 */
class AddressComponent
{
    protected $short_name;
    protected $long_name;
    protected $types = [];

    public function hydrate(array $data)
    {
        $properties = get_object_vars($this);

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->short_name;
    }

    /**
     * @return string
     */
    public function getLongName(): string
    {
        return $this->long_name;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
