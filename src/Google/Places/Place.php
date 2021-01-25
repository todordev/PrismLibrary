<?php
/**
 * @package      Prism\Library\Prism\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Google\Places;

use Joomla\Registry\Registry;
use Prism\Library\Prism\Domain\Entity;
use Prism\Library\Prism\Domain\EntityId;
use Prism\Library\Prism\Domain\EntityPopulating;

/**
 * Google Place Details.
 *
 * @package     Prism\Library\Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/autocomplete
 */
class Place implements Entity, EntityPopulating
{
    use EntityId;

    protected $name;
    protected $address_components;
    protected $adr_address;
    protected $formatted_address;
    protected $formatted_phone_number;
    protected $geometry;
    protected $icon;
    protected $international_phone_number;
    protected $rating;
    protected $reference;
    protected $reviews;
    protected $scope;
    protected $types;
    protected $url;
    protected $utc_offset;
    protected $permanently_closed;
    protected $vicinity;
    protected $website;
    protected $place_id;

    /**
     * @var OpeningHours
     */
    protected $opening_hours;

    public function __construct()
    {
        $this->geometry      = new Registry();
        $this->opening_hours = new OpeningHours();
    }

    public function bind(array $data, array $ignored = array())
    {
        $properties = get_object_vars($this);

        if (array_key_exists('geometry', $data)) {
            $this->geometry->loadArray($data['geometry']);
            unset($data['geometry']);
        }

        if (array_key_exists('opening_hours', $data) && array_key_exists('periods', $data['opening_hours'])) {
            $this->opening_hours = new OpeningHours();
            $this->opening_hours->hydrate($data['opening_hours']['periods']);
            unset($data['opening_hours']);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties) and !in_array($key, $ignored, true)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @return string
     */
    public function getPlaceId(): string
    {
        return (string)$this->place_id;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return (string)$this->reference;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return (array)$this->types;
    }

    /**
     * @return Registry
     */
    public function geometry(): Registry
    {
        return $this->geometry;
    }

    /**
     * @return array
     */
    public function getAddressComponents(): array
    {
        return (array)$this->address_components;
    }

    /**
     * @return string
     */
    public function getAdrAddress(): string
    {
        return (string)$this->adr_address;
    }

    /**
     * @return string
     */
    public function getFormattedAddress(): string
    {
        return (string)$this->formatted_address;
    }

    /**
     * @return string
     */
    public function getFormattedPhoneNumber(): string
    {
        return (string)$this->formatted_phone_number;
    }

    /**
     * @return Registry
     */
    public function getGeometry(): Registry
    {
        return $this->geometry;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return (string)$this->icon;
    }

    /**
     * @return string
     */
    public function getInternationalPhoneNumber(): string
    {
        return (string)$this->international_phone_number;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return (float)$this->rating;
    }

    /**
     * @return array
     */
    public function getReviews(): array
    {
        return (array)$this->reviews;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return (string)$this->scope;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return (string)$this->url;
    }

    /**
     * @return int
     */
    public function getUtcOffset(): int
    {
        return (int)$this->utc_offset;
    }

    /**
     * @return string
     */
    public function getVicinity(): string
    {
        return (string)$this->vicinity;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return (string)$this->website;
    }

    /**
     * @return int
     */
    public function getPermanentlyClosed(): int
    {
        return (int)$this->permanently_closed;
    }

    /**
     * @return OpeningHours
     */
    public function getOpeningHours(): OpeningHours
    {
        return $this->opening_hours;
    }
}
