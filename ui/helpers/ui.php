<?php
/**
 * @package      Prism
 * @subpackage   UI
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * Prism UI Html Helper
 *
 * @package       Prism
 * @subpackage    UI
 */
abstract class PrismUI
{
    /**
     * This parameter contains an information for loaded files.
     *
     * @var   array
     */
    protected static $loaded = array();

    /**
     * Include jQuery PNotify library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.pnotify');
     * </code>
     *
     * @link http://sciactive.github.io/pnotify/ Documentation of PNotify
     */
    public static function pnotify()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStylesheet(JUri::root() . 'libraries/Prism/ui/pnotify/css/jquery.pnotify.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/pnotify/js/jquery.pnotify.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Editable library ( build BS 2.3 ).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap2Editable');
     * </code>
     *
     * @link https://github.com/vitalets/x-editable Documentation of Bootstrap Editable
     */
    public static function bootstrap2Editable()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStylesheet(JUri::root() . 'libraries/Prism/ui/bootstrap2/editable/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap2/editable/js/bootstrap-editable.min.js');

        self::$loaded[__METHOD__] = true;

    }

    /**
     * Include Bootstrap Editable library ( build BS 3 ).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap3Editable');
     * </code>
     *
     * @link https://github.com/vitalets/x-editable Documentation of Bootstrap Editable
     */
    public static function bootstrap3Editable()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStylesheet(JUri::root() . 'libraries/Prism/ui/bootstrap3/editable/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/editable/js/bootstrap-editable.js');

        self::$loaded[__METHOD__] = true;

    }

    /**
     * Include Bootstrap Maxlength library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrapMaxLength');
     * </code>
     *
     * @link https://github.com/mimo84/bootstrap-maxlength Documentation of Bootstrap Maxlength
     */
    public static function bootstrapMaxLength()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap-maxlength.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap File Upload Style library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrapFileUploadStyle');
     * </code>
     */
    public static function bootstrapFileUploadStyle()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStylesheet(JUri::root() . 'libraries/Prism/ui/fileuploadstyle/css/bootstrap-fileuploadstyle.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/fileuploadstyle/js/bootstrap-fileuploadstyle.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap File Style library (BS v2.3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap2FileStyle');
     * </code>
     *
     * @link http://markusslima.github.io/bootstrap-filestyle/ Documentation of Bootstrap File Style
     */
    public static function bootstrap2FileStyle()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap2/bootstrap-filestyle.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap File Style library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap3FileStyle');
     * </code>
     *
     * @link http://markusslima.github.io/bootstrap-filestyle/ Documentation of Bootstrap File Style
     */
    public static function bootstrap3FileStyle()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/bootstrap-filestyle.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Fileinput library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap3Fileinput');
     * </code>
     *
     * @link https://github.com/kartik-v/bootstrap-fileinput Documentation of Bootstrap Fileinput
     */
    public static function bootstrap3Fileinput()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/fileinput/css/fileinput.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/fileinput/js/fileinput.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Datetime Picker Library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrapDatepicker');
     * </code>
     *
     * @link http://eonasdan.github.io/bootstrap-datetimepicker/ Documentation of Bootstrap Datepicker
     */
    public static function bootstrapDatepicker()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/datetimepicker/js/moment-with-locales.min.js');

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/datetimepicker/css/bootstrap-datetimepicker.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/datetimepicker/js/bootstrap-datetimepicker.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap 2 Typeahead library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap2Typeahead');
     * </code>
     *
     * @link http://plugins.upbootstrap.com/bootstrap-ajax-typeahead/#docs Documentation of Bootstrap 2 Typeahead
     */
    public static function bootstrap2Typeahead()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap2/bootstrap-typeahead.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap 3 Typeahead library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrap3Typeahead');
     * </code>
     *
     * @link https://github.com/twitter/typeahead.js Documentation of Bootstrap 3 Typeahead
     */
    public static function bootstrap3Typeahead()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/bootstrap3/typeahead/css/typeahead.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/typeahead/js/typeahead.bundle.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Parsley library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.parsley');
     * </code>
     *
     * @link http://parsleyjs.org/ Documentation of Parsley
     */
    public static function parsley()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/parsley.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * This method loads a script that initializes helper methods,
     * which are used in many Prism extensions.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.joomlaHelper');
     * </code>
     */
    public static function joomlaHelper()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/ui/joomla/helper.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery File Upload library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.fileupload');
     * </code>
     *
     * @link http://blueimp.github.io/jQuery-File-Upload/ Documentation of jQuery File Upload
     */
    public static function fileupload()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStylesheet(JUri::root() . 'libraries/Prism/ui/fileupload/css/jquery.fileupload.css');
//        $document->addStylesheet(JUri::root() . 'libraries/Prism/ui/fileupload/css/jquery.fileupload-ui.css');

        $document->addScript(JUri::root() . 'libraries/Prism/ui/fileupload/js/jquery.ui.widget.js');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/fileupload/js/jquery.iframe-transport.js');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/fileupload/js/jquery.fileupload.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include D3 library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.d3');
     * </code>
     *
     * @param bool $cdn Include the library from content delivery network.
     *
     * @link http://d3js.org/ Documentation of D3
     */
    public static function d3($cdn = false)
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        if (!$cdn) {
            $document->addScript(JUri::root() . 'libraries/Prism/ui/d3/js/d3.min.js');
        } else {
            $document->addScript("//cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js");
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery Cropper library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.cropper');
     * </code>
     *
     * @link http://fengyuanchen.github.io/cropper/ Cropper documentation
     */
    public static function cropper()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/cropper/js/cropper.min.js');
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/cropper/css/cropper.min.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * This method loads a script that initializes Joomla! list functionality.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.joomlaList');
     * </code>
     */
    public static function joomlaList()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/ui/joomla/list.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Displays a calendar control field based on Twitter Bootstrap 3
     *
     * @param   string  $value    The date value
     * @param   string  $name     The name of the text field
     * @param   string  $id       The id of the text field
     * @param   string  $format   The date format
     * @param   mixed   $attributes  Additional HTML attributes
     *
     * @return  string  HTML markup for a calendar field
     *
     * @since   1.5
     * @see http://eonasdan.github.io/bootstrap-datetimepicker/
     */
    public static function calendar($value, $name, $id, $format = 'Y-m-d', $attributes = null)
    {
        static $done;

        if ($done === null) {
            $done = array();
        }

        $readonly = isset($attributes['readonly']) && $attributes['readonly'] == 'readonly';
        $disabled = isset($attributes['disabled']) && $attributes['disabled'] == 'disabled';

        if (is_array($attributes)) {
            $attributes['class'] = isset($attributes['class']) ? $attributes['class'] : 'form-control';
            $attributes['class'] = trim($attributes['class'] . ' hasTooltip');

            $attributes = JArrayHelper::toString($attributes);
        }

        // Format value when not nulldate ('0000-00-00 00:00:00'), otherwise blank it as it would result in 1970-01-01.
        if ((int) $value && $value != JFactory::getDbo()->getNullDate()) {
            $date = new DateTime($value, new DateTimeZone('UTC'));
            $inputvalue = $date->format($format);
        } else {
            $inputvalue = '';
        }

        // Load the calendar behavior
        JHtml::_('prism.ui.bootstrapDatepicker');
        $languageTag = JFactory::getLanguage()->getTag();
        $locale = substr($languageTag, 0, 2);

        // Only display the triggers once for each control.
        if (!in_array($id, $done)) {

            $calendarDateFormat = CrowdfundingHelper::getDateFormat(true);

            $document = JFactory::getDocument();
            $document
                ->addScriptDeclaration(
                    'jQuery(document).ready(function($) {
                        jQuery("#'.$id.'_datepicker").datetimepicker({
                            format: "'.$calendarDateFormat.'",
                            locale: "'.Joomla\String\String::strtolower($locale).'",
                            allowInputToggle: true
                        });
                    });'
                );

            $done[] = $id;
        }

        // Hide button using inline styles for readonly/disabled fields
        $btn_style	= ($readonly || $disabled) ? ' style="display:none;"' : '';

        return '<div class="input-group date" id="'.$id.'_datepicker">
                    <input type="text" title="' . ($inputvalue ? JHtml::_("date", $value, null, null) : "").'"
                    name="' . $name . '" id="' . $id . '" value="' . htmlspecialchars($inputvalue, ENT_COMPAT, 'UTF-8') . '" ' . $attributes . ' />
                    <span class="input-group-addon" id="' . $id . '_img">
                        <span class="glyphicon glyphicon-calendar" id="' . $id . '_icon"' . $btn_style . '></span>
                    </span>
                </div>';
    }
}
