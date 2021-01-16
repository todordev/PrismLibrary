<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Controller;

trait BaseRedirectionMethods
{
    public function getDefaultLink(): string
    {
        // Guess the option as com_NameOfController
        if ($this->option === null) {
            $this->option = 'com_' . strtolower($this->getName());
        }

        return 'index.php?option=' . strtolower($this->option);
    }

    /**
     * Generate URI string from additional parameters.
     *
     * @param array $options
     *
     * @return string
     */
    protected function prepareExtraParameters(array $options): string
    {
        $uriString = '';

        foreach ($options as $key => $value) {
            $uriString .= '&' . $key . '=' . $value;
        }

        return $uriString;
    }
}
