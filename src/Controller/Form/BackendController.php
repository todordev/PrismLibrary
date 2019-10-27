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

/**
 * This class contains common methods and properties
 * used in work with forms on the back-end.
 *
 * @package      Prism
 * @subpackage   Controllers
 */
class BackendController extends FormController
{
    /**
     * This method prepare a link where the user will be redirected
     * after action he has done.
     *
     * @param array $options
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    protected function prepareRedirectLink($options): string
    {
        $view           = ArrayHelper::getValue($options, 'view');
        $task           = ArrayHelper::getValue($options, 'task');
        $itemId         = ArrayHelper::getValue($options, 'id', 0, 'uint');
        $urlVar         = ArrayHelper::getValue($options, 'url_var', 'id');

        // Remove standard parameters
        unset($options['view'], $options['task'], $options['id'], $options['url_var']);

        $link = $this->defaultLink;

        // Redirect to different of common views
        if (null !== $view) {
            $link .= '&view=' . $view;

            if ($itemId > 0) {
                $link .= $this->getRedirectToItemAppend($itemId, $urlVar);
            } else {
                $link .= $this->getRedirectToListAppend();
            }

            return $link;
        }

        // Prepare redirection
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

        // Generate additional parameters
        $extraParams = $this->prepareExtraParameters($options);

        return $link . $extraParams;
    }
}
