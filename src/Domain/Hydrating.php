<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

use Joomla\Registry\Registry;

trait Hydrating
{
    /**
     * Set notification data to object parameters.
     *
     * <code>
     * $data = array(
     *     "note"    => "...",
     *     "image"   => "picture.png",
     *     "url"     => "http://itprism.com/",
     *     "user_id" => 1
     * );
     *
     * $notification   = new Gamification\Notification(\JFactory::getDbo());
     * $notification->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     */
    public function hydrate(array $data, array $ignored = array()): void
    {
        $properties = get_object_vars($this);

        // Parse parameters of the object if they exists.
        if (array_key_exists('params', $data) && array_key_exists('params', $properties) && !in_array('params', $ignored, true)) {
            if ($data['params'] instanceof Registry) {
                $this->params = $data['params'];
            } else {
                $this->params = new Registry($data['params']);
            }
            unset($data['params']);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $properties) && !in_array($key, $ignored, true)) {
                $this->$key = $value;
            }
        }
    }
}
