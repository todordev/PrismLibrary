<?php
/**
 * @package      Prism\Library\Library
 * @subpackage   Ui
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Ui;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/**
 * Prism UI Html Helper
 *
 * @package       Prism\Library\Library
 * @subpackage    Ui
 */
abstract class Helper
{
    /**
     * This parameter contains an information for loaded files.
     *
     * @var   array
     */
    protected static $loaded = array();

    /**
     * Include jQuery plugin Remodal
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.remodal');
     * </code>
     *
     * @link http://vodkabears.github.io/remodal/
     */
    public static function remodal()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/remodal/remodal.min.js');
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/remodal/remodal.css');
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/remodal/remodal-default-theme.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery plugin iziModal
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.iziModal');
     * </code>
     *
     * @link http://izimodal.marcelodolce.com
     */
    public static function iziModal()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/izimodal/iziModal.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/izimodal/iziModal.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery plugin Modaal.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.modaal');
     * </code>
     *
     * @link http://humaan.com/modaal/
     */
    public static function modaal()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/modaal/modaal.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/modaal/modaal.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery plugin Tooltipster
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.tooltipster');
     * </code>
     *
     * @param string $theme The themes are light, borderless, punk, noir, shadow
     *
     * @link http://iamceege.github.io/tooltipster/
     */
    public static function tooltipster($theme = '')
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = Factory::getDocument();

        $document->addScript(Uri::root() . 'media/lib_prism/vendor/tooltipster/js/tooltipster.bundle.min.js');
        $document->addStyleSheet(Uri::root() . 'media/lib_prism/vendor/tooltipster/css/tooltipster.bundle.min.css');

        if ($theme) {
            $document->addStyleSheet(Uri::root() . 'media/lib_prism/vendor/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-'.$theme.'.min.css');
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Vue.js
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.vue');
     * </code>
     *
     * @link https://vuejs.org/
     */
    public static function vue()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/vue/vue.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery plugin AreYouSure.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.areYouSure');
     * </code>
     *
     * @link https://github.com/codedance/jquery.AreYouSure
     */
    public static function areYouSure()
    {
        // Load it once.
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/jquery.are-you-sure.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery plugin is-loading
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/isloading/jquery.isloading.min.js');
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/isloading/isloading.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery plugin LoadingOverlay
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.loadingOverlay');
     * </code>
     *
     * @link http://gasparesganga.com/labs/jquery-loading-overlay/#get-it
     */
    public static function loadingOverlay($progress = false)
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/loadingoverlay/loadingoverlay.min.js');

        if ($progress) {
            $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/loadingoverlay/loadingoverlay_progress.min.js');
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include backend styles.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/css/backend.style.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include some general styles.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/css/styles.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include AnimateCSS stiles.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.animateCss');
     * </code>
     *
     * @link https://github.com/daneden/animate.css
     */
    public static function animateCss()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/animation/animate.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/animation/animate.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Magic Animations stiles.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.magicAnimations');
     * </code>
     *
     * @link https://www.minimamente.com/example/magic_animations/
     */
    public static function magicAnimations()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/animation/magic.min.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Sticky Kit.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.stickyKit');
     * </code>
     *
     * @link http://leafo.net/sticky-kit/
     */
    public static function stickyKit()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/jquery.sticky-kit.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Readmore.js library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.readMore');
     * </code>
     *
     * @link https://github.com/jedfoster/Readmore.js
     */
    public static function readMore()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/readmore.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery Expander.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.expander');
     * </code>
     *
     * @link https://github.com/kswedberg/jquery-expander
     */
    public static function expander()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/jquery.expander.min.js');

        self::$loaded[__METHOD__] = true;
    }
    
    /**
     * Include Favico JS library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.favicoJs');
     * </code>
     *
     * @link http://lab.ejci.net/favico.js/
     */
    public static function favicoJs()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/animation/favico.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include CSSpin styles.
     * Types - balls, boxes, bubbles, eclipse, flip, heart, hue, meter, morph, meter, pinwheel, round, skeleton.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.cssSpin');
     * </code>
     *
     * @param string $type
     *
     * @link https://webkul.github.io/csspin/
     */
    public static function cssSpin($type)
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/csspin/csspin-'.$type.'.css');

        self::$loaded[__METHOD__] = true;
    }
    
    /**
     * Include jQuery PNotify library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document = Factory::getApplication()->getDocument();

        $document->addStyleSheet(Uri::root() . 'libraries/Prism/Ui/vendor/vendor/pnotify/pnotify.custom.min.css');
        $document->addScript(Uri::root() . 'libraries/Prism/Ui/vendor/vendor/pnotify/pnotify.custom.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Editable library ( build BS 2.3 ).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap2/editable/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap2/editable/js/bootstrap-editable.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Editable library ( build BS 3 ).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/editable/css/bootstrap-editable.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/editable/js/bootstrap-editable.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Maxlength library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap-maxlength.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include File Input library based on Bootstrap 2.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap2/fileinput/css/bootstrap-fileinput.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap2/fileinput/js/bootstrap-fileinput.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include SweetAlert2 JavaScript library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.sweetAlert');
     * </code>
     *
     * @link https://github.com/limonte/sweetalert2 Documentation of Sweet Alert
     */
    public static function sweetAlert()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/sweetalert/sweetalert2.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/sweetalert/sweetalert2.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Fileinput library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap3FileInput');
     * </code>
     *
     * @param string $theme
     * @param string $locale
     *
     * @link https://github.com/kartik-v/bootstrap-fileinput Documentation of Bootstrap Fileinput
     */
    public static function bootstrap3FileInput($theme = 'fa', $locale = '')
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/css/fileinput.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/js/fileinput.min.js');

        switch ($theme) {
            case 'explorer':
                $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/themes/explorer/theme.min.js');
                $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/themes/explorer/theme.min.css');
                break;
            case 'explorer-fa':
                $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/themes/explorer-fa/theme.min.js');
                $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/themes/explorer-fa/theme.min.css');
                break;
            case 'gly':
                $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/themes/gly/theme.min.js');
                break;
            default:
                $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/themes/fa/theme.min.js');
                break;
        }

        if ($locale) {
            $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/fileinput/js/locales/'.$locale.'.js');
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap Datetime Picker Library (BS v3).
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/datetimepicker/js/moment-with-locales.min.js');

        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap 2 Typeahead library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap2Typeahead');
     * </code>
     *
     * @link http://plugins.upbootstrap.com/bootstrap-ajax-typeahead/#docs Documentation of Bootstrap 2 Typeahead
     *
     * @deprecated 1.20 Use AutoComplete
     */
    public static function bootstrap2Typeahead()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap2/bootstrap-typeahead.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Bootstrap 3 Typeahead library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.bootstrap3Typeahead');
     * </code>
     *
     * @link https://github.com/twitter/typeahead.js Documentation of Bootstrap 3 Typeahead
     *
     * @deprecated 1.20 Use AutoComplete
     */
    public static function bootstrap3Typeahead()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/typeahead/css/typeahead.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/bootstrap3/typeahead/js/typeahead.bundle.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery AutoComplete library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/autocomplete/jquery.autocomplete.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/autocomplete/jquery.autocomplete.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Select2 library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/select2/css/select2.min.css');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/select2/js/select2.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include Parsley library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/parsley.min.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * This method loads a script that initializes helper methods,
     * which are used in many Prism extensions.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.joomlaHelper');
     * </code>
     *
     * @deprecated v1.20 Use Prism.ui.message
     */
    public static function joomlaHelper()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/joomla/helper.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * This method loads a script that initializes an object used for showing messages.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.message');
     * </code>
     */
    public static function message()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = Factory::getApplication()->getDocument();
        $document->addScript(Uri::root() . 'libraries/Prism/Ui/vendor/js/prism.message.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery File Upload library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/fileupload/css/jquery.fileupload.css');
//        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/fileupload/css/jquery.fileupload-ui.css');

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/fileupload/js/jquery.ui.widget.js');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/fileupload/js/jquery.iframe-transport.js');
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/fileupload/js/jquery.fileupload.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include ChartJS library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.chartjs');
     * </code>
     *
     * @param bool $bundle Use bundle file that includes MomentJs.
     *
     * @link http://www.chartjs.org/
     */
    public static function chartjs($bundle = false)
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        if (!$bundle) {
            $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/chartjs/Chart.min.js');
        } else {
            $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/chartjs/Chart.bundle.min.js');
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include MomentJs library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.momentjs');
     * </code>
     *
     * @param bool $locales Load the file that contains all locales.
     *
     * @link http://momentjs.com/
     */
    public static function momentjs($locales = false)
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();

        if (!$locales) {
            $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/momentjs/moment.min.js');
        } else {
            $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/momentjs/moment-with-locales.min.js');
        }

        self::$loaded[__METHOD__] = true;
    }

    /**
     * Include jQuery Cropper library.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
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

        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/cropper/cropper.min.js');
        $document->addStyleSheet(JUri::root() . 'libraries/Prism/Ui/vendor/cropper/cropper.min.css');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * This method loads a script that initializes Joomla! list functionality.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.joomlaList');
     * </code>
     *
     * @deprecated v1.20
     */
    public static function joomlaList()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/joomla/list.js');

        self::$loaded[__METHOD__] = true;
    }

    /**
     * This method loads serializeJSON.
     *
     * <code>
     * JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/Ui/vendor/helpers');
     *
     * JHtml::_('Prism.ui.serializeJson');
     * </code>
     *
     * @link https://github.com/marioizquierdo/jquery.serializeJSON
     */
    public static function serializeJson()
    {
        // Only load once
        if (!empty(self::$loaded[__METHOD__])) {
            return;
        }

        $document = JFactory::getDocument();
        $document->addScript(JUri::root() . 'libraries/Prism/Ui/vendor/jquery.serializejson.min.js');

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
//            $attributes['class'] = trim($attributes['class'] . ' hasTooltip');

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
            $calendarDateFormat = Prism\Library\Utilities\DateHelper::convertToMomentJsFormat($format);

            $document = JFactory::getDocument();
            $document
                ->addScriptDeclaration(
                    'jQuery(document).ready(function($) {
                        jQuery("#' . $id . '_datepicker").datetimepicker({
                            format: "' . $calendarDateFormat . '",
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
                ->addScriptDeclaration(JLayoutHelper::render('bootstrap3.starttabsetscript', $layoutData), PRISM_PATH_LIBRARY.'/Ui/vendor/layouts');

            // Set static array
            static::$loaded[__METHOD__][$sig]                = true;
            static::$loaded[__METHOD__][$selector]['active'] = $opt['active'];
        }

        $html = JLayoutHelper::render('bootstrap3.starttabset', $layoutData, PRISM_PATH_LIBRARY.'/Ui/vendor/layouts');

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

        $tabScriptLayout = ($tabScriptLayout === null) ? new JLayoutFile('bootstrap3.addtabscript', PRISM_PATH_LIBRARY.'/Ui/vendor/layouts') : $tabScriptLayout;
        $tabLayout       = ($tabLayout === null) ? new JLayoutFile('bootstrap3.addtab', PRISM_PATH_LIBRARY.'/Ui/vendor/layouts') : $tabLayout;

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
        $dateValidator = new Prism\Library\Validator\Date($date);

        return $dateValidator->isValid() ? JHtml::_('date', $date, $format) : $default;
    }

	public static function stateDefault($value, $i, $prefix = '')
	{
		$states = array(
			1 => array('changeStateUndefault', 'COM_SHIPPINGCART_DEFAULT', 'COM_SHIPPINGCART_UNDEFAULT_STATE_TOOLTIP', 'publish'),
			0 => array('changeStateDefault', 'COM_SHIPPINGCART_UNDEFAULT', 'COM_SHIPPINGCART_DEFAULT_STATE_TOOLTIP', 'unpublish'),
		);

		$currentState = $states[$value];

		$active_class = 'inactive';
		if ($value) {
			$active_class = 'active';
		}

		// <a class="tbody-icon active hasTooltip" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb0','categories.unpublish')" title="Unpublish Item"><span class="icon-publish" aria-hidden="true"></span></a>

		$html[] = '<a class="tbody-icon '.$active_class.' hasTooltip"';

		$html[] = ' href="javascript:void(0);" onclick="return Joomla.listItemTask(\'cb'. $i . '\',\'' . $prefix . $currentState[0] . '\')"';

		$html[] = ' title="' . Text::_($currentState[1]) .'::'. Text::_($currentState[2]). '"';
		$html[] = '>';
		$html[] = '<span class="icon-' . $currentState[3] . '" aria-hidden="true"></span>';
		$html[] = '</a>';

		return implode("\n", $html);
	}
}
