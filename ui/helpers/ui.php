<?php
/**
 * @package      Prism
 * @subpackage   UI
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
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
     * Include jQuery plugin is-loading
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.isLoading');
     * </code>
     */
    public static function isLoading()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/ui/isloading/jquery.isloading.min.js');
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/isloading/isloading.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include backend styles.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.backendStyles');
     * </code>
     */
    public static function backendStyles()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/css/backend.style.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include some general styles.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.styles');
     * </code>
     */
    public static function styles()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/css/styles.css');

        self::$loaded[__METHOD__] = true;
    }
    
    /**
     * Include jQuery PNotify library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.pnotify');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/pnotify/css/jquery.pnotify.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/pnotify/js/jquery.pnotify.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Editable library ( build BS 2.3 ).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap2Editable');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/bootstrap2/editable/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap2/editable/js/bootstrap-editable.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Editable library ( build BS 3 ).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap3Editable');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/bootstrap3/editable/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/editable/js/bootstrap-editable.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Maxlength library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.bootstrapMaxLength');
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

        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap-maxlength.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include File Input library based on Bootstrap 2.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap2FileInput');
     * </code>
     */
    public static function bootstrap2FileInput()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/bootstrap2/fileinput/css/bootstrap-fileinput.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap2/fileinput/js/bootstrap-fileinput.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Sweet Alert javascript library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.sweetAlert');
     * </code>
     *
     * @link http://t4t5.github.io/sweetalert/ Documentation of Sweet Alert
     */
    public static function sweetAlert()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/sweetalert/sweetalert.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/sweetalert/sweetalert.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Fileinput library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap3FileInput');
     * </code>
     *
     * @link https://github.com/kartik-v/bootstrap-fileinput Documentation of Bootstrap Fileinput
     */
    public static function bootstrap3FileInput()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/bootstrap3/fileinput/css/fileinput.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/fileinput/js/fileinput.min.js');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/fileinput/themes/fa/theme.js');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/bootstrap3/fileinput/js/plugins/canvas-to-blob.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Datetime Picker Library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.bootstrapDatepicker');
     * </code>
     *
     * @link http://eonasdan.github.io/bootstrap-datetimepicker/ Documentation of Bootstrap Datepicker
     */
    public static function bootstrap3Datepicker()
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
     * JHtml::_('Prism.ui.bootstrap2Typeahead');
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
     * JHtml::_('Prism.ui.bootstrap3Typeahead');
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
     * Include jQuery AutoComplete library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.jQueryAutoComplete');
     * </code>
     *
     * @link https://github.com/devbridge/jQuery-Autocomplete jQuery AutoComplete documentation
     */
    public static function jQueryAutoComplete()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/autocomplete/jquery.autocomplete.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/autocomplete/jquery.autocomplete.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Select2 library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.select2');
     * </code>
     *
     * @link https://select2.github.io Select2
     */
    public static function select2()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/select2/css/select2.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/ui/select2/js/select2.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Parsley library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.parsley');
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
     * JHtml::_('Prism.ui.joomlaHelper');
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
     * JHtml::_('Prism.ui.fileupload');
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
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/fileupload/css/jquery.fileupload.css');
//        $document->addStyleSheet(JUri::root() . 'libraries/Prism/ui/fileupload/css/jquery.fileupload-ui.css');

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
     * JHtml::_('Prism.ui.d3');
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
            $document->addScript('//cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js');
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery Cropper library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.cropper');
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
     * JHtml::_('Prism.ui.joomlaList');
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
     * This method loads serializeJSON.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('Prism.ui.serializeJson');
     * </code>
     */
    public static function serializeJson()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/ui/jquery.serializejson.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Displays a calendar control field based on Twitter Bootstrap 3
     *
     * @param   string $value      The date value
     * @param   string $name       The name of the text field
     * @param   string $id         The id of the text field
     * @param   string $format     The date format
     * @param   mixed  $attributes Additional HTML attributes
     *
     * @return  string  HTML markup for a calendar field
     *
     * @since   1.5
     * @see     http://eonasdan.github.io/bootstrap-datetimepicker/
     */
    public static function calendar($value, $name, $id, $format = 'Y-m-d', array $attributes = array())
    {
        static $done;

        if ($done === null) {
            $done = array();
        }

        $readonly = (!empty($attributes['readonly']) and $attributes['readonly'] === 'readonly');
        $disabled = (!empty($attributes['disabled']) and $attributes['disabled'] === 'disabled');

        if (is_array($attributes)) {
            $attributes['class'] = !empty($attributes['class']) ? $attributes['class'] : 'form-control';
            $attributes['class'] = trim($attributes['class'] . ' hasTooltip');

            $attributes = Joomla\Utilities\ArrayHelper::toString($attributes);
        }

        // Format value when not nulldate ('0000-00-00 00:00:00'), otherwise blank it as it would result in 1970-01-01.
        if ((int)$value && ($value !== JFactory::getDbo()->getNullDate())) {
            $date       = new DateTime($value, new DateTimeZone('UTC'));
            $inputvalue = $date->format($format);
        } else {
            $inputvalue = '';
        }

        // Load the calendar behavior
        JHtml::_('Prism.ui.bootstrap3Datepicker');
        $languageTag = JFactory::getLanguage()->getTag();
        $locale      = substr($languageTag, 0, 2);

        // Only display the triggers once for each control.
        if (!in_array($id, $done, true)) {
            $calendarDateFormat = Prism\Utilities\DateHelper::convertToMomentJsFormat($format);

            $document = JFactory::getDocument();
            $document
                ->addScriptDeclaration(
                    'jQuery(document).ready(function($) {
                        jQuery("#' . $id . '_datepicker").datetimepicker({
                            format: "' . strtoupper($calendarDateFormat) . '",
                            locale: "' . strtolower($locale) . '",
                            allowInputToggle: true
                        });
                    });'
                );

            $done[] = $id;
        }

        // Hide button using inline styles for readonly/disabled fields
        $btn_style = ($readonly || $disabled) ? ' style="display:none;"' : '';

        return '<div class="input-group date" id="' . $id . '_datepicker">
                    <input type="text" title="' . $inputvalue . '"
                    name="' . $name . '" id="' . $id . '" value="' . htmlspecialchars($inputvalue, ENT_COMPAT, 'UTF-8') . '" ' . $attributes . ' />
                    <span class="input-group-addon" id="' . $id . '_img">
                        <span class="fa fa-calendar" id="' . $id . '_icon"' . $btn_style . '></span>
                    </span>
                </div>';
    }

    /**
     * Creates a tab pane
     *
     * @param   string $selector The pane identifier.
     * @param   array  $params   The parameters for the pane
     *
     * @return  string
     *
     * @since   3.1
     */
    public static function bootstrap3StartTabSet($selector = 'myTab', array $params = array())
    {
        $sig = md5(serialize(array($selector, $params)));

        $layoutData = new stdClass();
        $layoutData->selector = $selector;

        if (!isset(static::$loaded[__METHOD__][$sig])) {
            // Setup options object
            $opt['active'] = (!empty($params['active'])) ? (string)$params['active'] : '';

            // Attach tabs to document
            JFactory::getDocument()
                ->addScriptDeclaration(JLayoutHelper::render('bootstrap3.starttabsetscript', $layoutData), PRISM_PATH_LIBRARY.'/ui/layouts');

            // Set static array
            static::$loaded[__METHOD__][$sig]                = true;
            static::$loaded[__METHOD__][$selector]['active'] = $opt['active'];
        }

        $html = JLayoutHelper::render('bootstrap3.starttabset', $layoutData, PRISM_PATH_LIBRARY.'/ui/layouts');

        return $html;
    }

    /**
     * Close the current tab pane
     *
     * @return  string  HTML to close the pane
     *
     * @since   3.1
     */
    public static function bootstrap3EndTabSet()
    {
        return '</div>';
    }

    /**
     * Begins the display of a new tab content panel.
     *
     * @param   string $selector Identifier of the panel.
     * @param   string $id       The ID of the div element
     * @param   string $title    The title text for the new UL tab
     *
     * @return  string  HTML to start a new panel
     *
     * @since   3.1
     */
    public static function bootstrap3AddTab($selector, $id, $title)
    {
        static $tabScriptLayout = null;
        static $tabLayout = null;

        $tabScriptLayout = ($tabScriptLayout === null) ? new JLayoutFile('bootstrap3.addtabscript', PRISM_PATH_LIBRARY.'/ui/layouts') : $tabScriptLayout;
        $tabLayout       = ($tabLayout === null) ? new JLayoutFile('bootstrap3.addtab', PRISM_PATH_LIBRARY.'/ui/layouts') : $tabLayout;

        $active = (static::$loaded['PrismUI::bootstrap3StartTabSet'][$selector]['active'] === $id) ? ' active' : '';

        // Inject tab into UL.
        $dataLayout = new stdClass();
        $dataLayout->selector = $selector;
        $dataLayout->id = $id;
        $dataLayout->active = $active;
        $dataLayout->title = $title;

        JFactory::getDocument()->addScriptDeclaration($tabScriptLayout->render($dataLayout));

        return $tabLayout->render($dataLayout);
    }

    /**
     * Close the current tab content panel
     *
     * @return  string  HTML to close the pane
     *
     * @since   3.1
     */
    public static function bootstrap3EndTab()
    {
        return '</div>';
    }

    /**
     * Prepare title and content for popover.
     * It will be used for an HTML element
     *
     * @param string $text
     * @param string $title
     *
     * @return  string  HTML element attributes
     */
    public static function popoverText($text, $title = '')
    {
        $attributes = array();
        if ($text !== null and $text !== '') {
            $attributes[] = 'data-content = "'.htmlentities($text, ENT_QUOTES).'"';
        }

        if ($title !== '') {
            $attributes[] = 'data-original-title = "'.htmlentities($title, ENT_QUOTES).'"';
        }

        return implode(' ', $attributes);
    }

    /**
     * Display a date.
     *
     * @param string $date
     * @param string $format
     * @param string $default
     *
     * @throws  \InvalidArgumentException
     * @return  string  HTML element attributes
     */
    public static function date($date, $format = '', $default = '--')
    {
        $dateValidator = new Prism\Validator\Date($date);

        return $dateValidator->isValid() ? JHtml::_('date', $date, $format) : $default;
    }
}
