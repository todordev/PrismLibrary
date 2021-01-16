<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Controller;

use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

trait FormRedirection
{
    use MessagePrepareMethods;
    use BaseRedirectionMethods;

    /**
     * This method prepare a link where the user will be redirected after completed action.
     *
     * @param array $options URL parameters used for generating redirect link.
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function prepareRedirectLink(array $options): string
    {
        // Return predefined link
        $forceDirection = ArrayHelper::getValue($options, 'force_direction');
        if ($forceDirection !== null) {
            return $forceDirection;
        }

        $link = $this->getDefaultLink();

        $view   = ArrayHelper::getValue($options, 'view');
        $layout = ArrayHelper::getValue($options, 'layout');
        $itemId = ArrayHelper::getValue($options, 'id', 0, 'uint');
        $urlVar = ArrayHelper::getValue($options, 'url_var', 'id');

        // Remove some of standard URL parameters.
        unset($options['view'], $options['layout'], $options['url_var'], $options['id']);

        if ($view !== null) {
            $link .= '&view=' . $view;
        }

        if ($layout !== null) {
            $link .= '&layout=' . $layout;
        }

        if ($itemId > 0) { // Redirect to form view.
            $link .= $this->getRedirectToItemAppend($itemId, $urlVar);
        } else { // Redirect to list view.
            $link .= $this->getRedirectToListAppend();
        }

        // Prepare additional parameters.
        $extraParams = $this->prepareExtraParameters($options);

        return $link . $extraParams;
    }

    /**
     * This method performs a cancel action.
     *
     * @param string $key
     *
     * @return void
     */
    public function cancel($key = null)
    {
        $this->setRedirect(
            Route::_(
                $this->getDefaultLink() . '&view=' . $this->view_list . $this->getRedirectToListAppend(),
                false
            )
        );
    }
}
