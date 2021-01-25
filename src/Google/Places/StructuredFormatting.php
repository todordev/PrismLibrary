<?php
/**
 * @package      Prism\Library\Prism\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Google\Places;

use Prism\Library\Prism\Domain\Hydration;

/**
 * Google Place Structured Formatted Value Object.
 *
 * @package     Prism\Library\Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/autocomplete
 */
class StructuredFormatting implements Hydration
{
    protected $main_text;
    protected $main_text_matched_substrings;
    protected $secondary_text;

    /**
     * @param array $data
     * @param array $ignored
     */
    public function hydrate(array $data, array $ignored = array())
    {
        $properties = get_object_vars($this);

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties) and !in_array($key, $ignored, true)) {
                $this->$key = $value;
            }
        }
    }

    public function getMainText()
    {
        return $this->main_text;
    }

    public function getMatchedSubstrings()
    {
        return $this->main_text_matched_substrings;
    }

    public function getSecondaryText()
    {
        return $this->secondary_text;
    }
}
