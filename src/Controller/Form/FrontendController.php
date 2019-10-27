<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Controller\Form;

use Prism\Library\Controller\FormController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;

/**
 * This class contains common methods and properties
 * used in work with forms on the front-end.
 *
 * @package      Prism
 * @subpackage   Controllers
 */
class FrontendController extends FormController
{
    /**
     * This method prepare a link where the user will be redirected
     * after action he has been done.
     *
     * @param array $options
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function prepareRedirectLink($options = array()): string
    {
        // Return predefined link
        $forceDirection = ArrayHelper::getValue($options, 'force_direction');
        if (null !== $forceDirection) {
            return $forceDirection;
        }

        // Generate a return link
        $view   = ArrayHelper::getValue($options, 'view');
        $layout = ArrayHelper::getValue($options, 'layout');
        $itemId = ArrayHelper::getValue($options, 'id', 0, 'uint');
        $urlVar = ArrayHelper::getValue($options, 'url_var', 'id');

        // Remove standard parameters
        unset($options['view'], $options['task'], $options['id'], $options['url_var']);

        // Prepare additional parameters
        $extraParams = $this->prepareExtraParameters($options);

        // Generate return link
        $link = $this->defaultLink . '&view=' . $view . $this->getRedirectToViewAppend($layout, $itemId, $urlVar) . $extraParams;

        return $link;
    }

    /**
     * Gets the URL arguments to append to an item redirect.
     *
     * @param   string  $layout The layout that will be loaded
     * @param   integer $itemId The primary key id for the item.
     * @param   string  $urlVar The name of the URL variable for the id.
     *
     * @return  string  The arguments to append to the redirect URL.
     *
     * @since   12.2
     * @throws \Exception
     */
    protected function getRedirectToViewAppend($layout = null, $itemId = null, $urlVar = 'id'): string
    {
        $app = Factory::getApplication();
        /** @var @app JApplicationSite */

        $tmpl   = $app->input->get('tmpl');
        $append = '';

        // Setup redirect info.
        if ($tmpl) {
            $append .= '&tmpl=' . $tmpl;
        }

        if ($layout) {
            $append .= '&layout=' . $layout;
        }

        if ($itemId) {
            $append .= '&' . $urlVar . '=' . $itemId;
        }

        return $append;
    }
}
