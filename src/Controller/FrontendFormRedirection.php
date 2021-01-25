<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Controller;

use Exception;
use Joomla\CMS\Factory;
use InvalidArgumentException;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Application\SiteApplication;

trait FrontendFormRedirection
{
    use MessagePrepareMethods;
    use BaseRedirectionMethods;

    /**
     * Prepare redirect links after performing action in form controller on the frontend.
     *
     * @param array $options
     * @return string
     *
     * @throws InvalidArgumentException|Exception
     */
    protected function prepareRedirectLink(array $options = []): string
    {
        // Return predefined link
        $forceDirection = ArrayHelper::getValue($options, 'force_direction');
        if ($forceDirection !== null) {
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

        return $this->getDefaultLink() . '&view=' . $view . $this->getRedirectToViewAppend($layout, $itemId, $urlVar) . $extraParams;
    }

    /**
     * Get the URL arguments and append them to redirection link.
     *
     * @param string $layout The layout that will be loaded
     * @param integer $itemId The primary key id for the item.
     * @param string $urlVar The name of the URL variable for the id.
     * @return string  The arguments to append to the redirect URL.
     *
     * @throws Exception
     */
    protected function getRedirectToViewAppend($layout = null, $itemId = null, $urlVar = 'id'): string
    {
        /** @var SiteApplication $app */
        $app = Factory::getApplication();

        if (!$app) {
            throw new Exception('There is no application object!');
        }

        $tmpl = $app->input->get('tmpl');
        $append = '';

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
