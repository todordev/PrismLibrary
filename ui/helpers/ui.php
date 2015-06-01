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

        $document->addStylesheet(JUri::root() . 'libraries/prism/ui/css/jquery.pnotify.css');
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/jquery.pnotify.min.js');

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

        $document->addStylesheet(JUri::root() . 'libraries/prism/ui/bootstrap2/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/prism/ui/bootstrap2/js/bootstrap-editable.js');

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

        $document->addStylesheet(JUri::root() . 'libraries/prism/ui/bootstrap3/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/prism/ui/bootstrap3/js/bootstrap-editable.js');

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

        $document->addScript(JUri::root() . 'libraries/prism/ui/js/bootstrap-maxlength.min.js');

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

        $document->addStylesheet(JUri::root() . 'libraries/prism/ui/css/bootstrap-fileuploadstyle.min.css');
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/bootstrap-fileuploadstyle.min.js');

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

        $document->addScript(JUri::root() . 'libraries/prism/ui/bootstrap2/js/bootstrap-filestyle.min.js');

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

        $document->addScript(JUri::root() . 'libraries/prism/ui/bootstrap3/js/bootstrap-filestyle.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap 3 Typehead library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');
     *
     * JHtml::_('prism.ui.bootstrapTypeahead');
     * </code>
     *
     * @link https://github.com/bassjobsen/Bootstrap-3-Typeahead Documentation of Bootstrap 3 Typehead
     */
    public static function bootstrapTypeahead()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/bootstrap-typeahead.min.js');

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

        $document->addScript(JUri::root() . 'libraries/prism/ui/js/parsley.min.js');

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
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/joomla/helper.js');

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
        $document->addStylesheet(JUri::root() . 'libraries/prism/ui/css/jquery.fileupload-ui.css');

        $document->addScript(JUri::root() . 'libraries/prism/ui/js/fileupload/jquery.ui.widget.js');
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/fileupload/jquery.iframe-transport.js');
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/fileupload/jquery.fileupload.js');

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
            $document->addScript(JUri::root() . 'libraries/prism/ui/js/d3/d3.min.js');
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

        $document->addScript(JUri::root() . 'libraries/prism/ui/js/cropper.min.js');
        $document->addStyleSheet(JUri::root() . 'libraries/prism/ui/css/cropper.min.css');

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
        $document->addScript(JUri::root() . 'libraries/prism/ui/js/joomla/list.js');

        self::$loaded[__METHOD__] = true;
    }
}
