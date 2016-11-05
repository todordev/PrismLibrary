<?php
/**
 * @package      Prism
 * @subpackage   Libraries
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldPrismText extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     *
     * @since  11.1
     */
    protected $type = 'prismtext';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \OutOfBoundsException
     */
    protected function getInput()
    {
        $elements  = (array)$this->element;
        $elements  = $elements['@attributes'];

        // Initialize some field attributes.
        $size      = $this->element['size'] ? ' size="' . (int)$this->element['size'] . '"' : '';
        $maxLength = $this->element['maxlength'] ? ' maxlength="' . (int)$this->element['maxlength'] . '"' : '';
        $readonly  = ((string)$this->element['readonly'] === 'true') ? ' readonly="readonly"' : '';
        $disabled  = ((string)$this->element['disabled'] === 'true') ? ' disabled="disabled"' : '';
        $class     = (!empty($this->element['class'])) ? ' class="' . (string)$this->element['class'] . '"' : '';
        $required  = $this->required ? ' required aria-required="true"' : '';

        $doTranslate = array_key_exists('translate', $elements) ? (bool)$elements['translate'] : false;
        $cssLayout   = array_key_exists('css_layout', $elements) ? (string)$elements['css_layout'] : 'b2';
        $prefix      = array_key_exists('prefix', $elements) ? (string)$this->element['prefix'] : null;
        $suffix      = array_key_exists('suffix', $elements) ? (string)$this->element['suffix'] : null;

        // Initialize JavaScript field attributes.
        $onchange = $this->element['onchange'] ? ' onchange="' . (string)$this->element['onchange'] . '"' : '';

        $html   = array();
        if ($cssLayout === 'b3') { // Bootstrap 3
            $html[] = '<div class="input-group">';

            if ($prefix !== null and $prefix !== '') { // Prepended
                $prefix = $doTranslate ? JText::_($prefix) : htmlspecialchars($prefix);
                $html[] = '<div class="input-group-addon">' . $prefix . '</div>';
            }

            $html[] = '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . htmlspecialchars($this->value, ENT_QUOTES) . '"' . $class . $size . $disabled . $readonly . $maxLength . $onchange . $required . '/>';

            if ($suffix !== null and $suffix !== '') {
                $suffix = $doTranslate ? JText::_($suffix) : htmlspecialchars($suffix);
                $html[] = '<div class="input-group-addon">' . $suffix . '</div>';
            }

            $html[] = '</div>';

        } else { // Bootstrap 2

            if ($prefix !== null and $prefix !== '') { // Prepended
                $prefix = $doTranslate ? JText::_($prefix) : htmlspecialchars($prefix);
                $html[] = '<div class="input-prepend input-append"><span class="add-on">' . $prefix . '</span>';
            } elseif ($suffix !== null and $suffix !== '') { // Append
                $html[] = '<div class="input-append">';
            }

            $html[] = '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . htmlentities($this->value, ENT_QUOTES) . '"' . $class . $size . $disabled . $readonly . $maxLength . $onchange . $required . '/>';

            // Appended
            if ($suffix !== null and $suffix !== '') {
                $suffix = $doTranslate ? JText::_($suffix) : htmlspecialchars($suffix);
                $html[] = '<span class="add-on">' . $suffix . '</span></div>';
            }
        }

        return implode("\n", $html);
    }
}
