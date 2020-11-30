<?php
/**
 * @package      Prism
 * @subpackage   UI
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

echo "(function($){
    $('#$displayData->selector a').click(function (e)
    {
        e.preventDefault();
        $(this).tab('show');
    });
})(jQuery);";
