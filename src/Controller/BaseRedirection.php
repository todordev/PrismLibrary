<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Controller;

use Joomla\Utilities\ArrayHelper;

trait BaseRedirection
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

        // Remove some of standard URL parameters.
        unset($options['view'], $options['layout']);

        if ($view !== null) {
            $link .= '&view=' . $view;
        }

        if ($layout !== null) {
            $link .= '&layout=' . $layout;
        }

        // Prepare additional parameters.
        $extraParams = $this->prepareExtraParameters($options);

        return $link . $extraParams;
    }
}
