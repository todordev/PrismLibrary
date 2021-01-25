<?php
/**
 * @package      Prism\Library\Prism\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Google\Places;

/**
 * Google Place Details.
 *
 * @package     Prism\Library\Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/details
 */
class Address
{
    protected $floor;
    protected $street_number;
    protected $route;
    protected $locality;
    protected $administrative_area_level_2;
    protected $administrative_area_level_1;
    protected $country;
    protected $postal_code;

    public function hydrate(array $data)
    {
        $properties = get_object_vars($this);

        foreach ($properties as $propertyName => $propertyValue) {
            foreach ($data as $value) {
                if (array_key_exists('types', $value) && in_array($propertyName, $value['types'], true)) {
                    $this->$propertyName = new AddressComponent();
                    $this->$propertyName->hydrate($value);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @return mixed
     */
    public function getStreetNumber()
    {
        return $this->street_number;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @return mixed
     */
    public function getAdministrativeAreaLevel2()
    {
        return $this->administrative_area_level_2;
    }

    /**
     * @return mixed
     */
    public function getAdministrativeAreaLevel1()
    {
        return $this->administrative_area_level_1;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }
}
