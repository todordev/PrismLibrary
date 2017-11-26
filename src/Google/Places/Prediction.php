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
use Prism\Domain\EntityPopulating;
use Prism\Domain\Populator;

/**
 * Google Place Prediction.
 *
 * @package     Prism\Google
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
