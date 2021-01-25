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
use Prism\Library\Prism\Domain\EntityPopulating;
use Prism\Library\Prism\Domain\Populator;

/**
 * Google Place Prediction.
 *
 * @package     Prism\Library\Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/autocomplete
 */
class Prediction implements Entity, EntityPopulating
{
    use EntityId;

    protected $description;
    protected $matched_substrings;
    protected $place_id;
    protected $reference;
    protected $terms;
    protected $types;

    /**
     * @var StructuredFormatting
     */
    protected $structured_formatting;

    public function bind(array $data, array $ignored = array())
    {
        $properties = get_object_vars($this);

        $this->structured_formatting = new StructuredFormatting();
        if (array_key_exists('structured_formatting', $data)) {
            $this->structured_formatting->hydrate($data['structured_formatting']);
            unset($data['structured_formatting']);
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getMatchedSubstrings(): array
    {
        return $this->matched_substrings;
    }

    /**
     * @return StructuredFormatting
     */
    public function getStructuredFormatting(): StructuredFormatting
    {
        return $this->structured_formatting;
    }

    /**
     * @return string
     */
    public function getPlaceId(): string
    {
        return $this->place_id;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return array
     */
    public function getTerms(): array
    {
        return $this->terms;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
