<?php
/**
 * @package      Prism\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Google\Places;

use Prism\Domain\Entity;
use Prism\Domain\EntityId;
use Joomla\Registry\Registry;
use Prism\Domain\EntityPopulating;

/**
 * Google Place Details.
 *
 * @package     Prism\Google
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
