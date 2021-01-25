<?php
/**
 * @package      Prism
 * @subpackage   Libraries
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldPrismuid extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     *
     * @since  11.1
     */
    protected $type = 'prismuid';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     */
    protected function getInput()
    {
        $force     = isset($this->element['force']) ? (bool)$this->element['force'] : false;
        if (!$this->value or $force) {
            $this->value = mt_rand(100000, 9999999);
        }

        return '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . htmlspecialchars($this->value, ENT_QUOTES) . '" readonly="readonly" />';
    }
}
