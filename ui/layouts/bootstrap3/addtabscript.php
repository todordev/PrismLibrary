<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

echo "(function($){
    $(document).ready(function() {
        // Handler for .ready() called.
        var tab = $('<li role=\"presentation\" class=\"" . $displayData->active . "\"><a href=\"#" . $displayData->id . "\" data-toggle=\"tab\" aria-controls=\"".$displayData->title."\" role=\"tab\">" . $displayData->title . "</a></li>');
        $('#" . $displayData->selector . "Tabs').append(tab);
    });
})(jQuery);";
