<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Controller;

use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

trait BackendFormRedirection
{
    use MessagePrepareMethods;
    use BaseRedirectionMethods;

    /**
     * Prepare redirect links after performing action in form controller on backend site.
     *
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function prepareRedirectLink(array $options): string
    {
        $view = ArrayHelper::getValue($options, 'view');
        $task = ArrayHelper::getValue($options, 'task');
        $itemId = ArrayHelper::getValue($options, 'id', 0, 'uint');
        $urlVar = ArrayHelper::getValue($options, 'url_var', 'id');

        // Remove standard parameters
        unset($options['view'], $options['task'], $options['id'], $options['url_var']);

        $link = $this->getDefaultLink();

        if ($view !== null) {
            $link .= '&view=' . $view;

            if ($itemId > 0) {
                $link .= $this->getRedirectToItemAppend($itemId, $urlVar);
            } else {
                $link .= $this->getRedirectToListAppend();
            }

            return $link;
        }

        // Prepare redirection after specific action.
        switch ($task) {
            case 'apply':
                $link .= '&view=' . $this->view_item . $this->getRedirectToItemAppend($itemId, $urlVar);
                break;

            case 'save2new':
                $link .= '&view=' . $this->view_item . $this->getRedirectToItemAppend();
                break;

            default:
                $link .= '&view=' . $this->view_list . $this->getRedirectToListAppend();
                break;
        }

        // Prepare additional parameters.
        $extraParams = $this->prepareExtraParameters($options);

        return $link . $extraParams;
    }

    /**
     * This method performs a cancel action.
     *
     * @param string $key
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
