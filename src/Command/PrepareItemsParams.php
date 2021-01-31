<?php
/**
 * @package   Prism\Library\Prism\Contract\Command
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Command;

use Joomla\Registry\Registry;
use Prism\Library\Prism\Contract\Pipeline\Pipe;

/**
 * This class provides functionality to prepare object parameters.
 *
 * @package  Prism\Library\Prism\Contract\Command
 */
class PrepareItemsParams implements Pipe
{
    /**
     * Prepare the parameters of the items.
     *
     * @param $content
     * @param \Closure $next
     * @return mixed
     */
    public function handle($content, \Closure $next)
    {
        if (is_array($content) && count($content) > 0) {
            foreach ($content as $key => $item) {
                if (!$item->params) {
                    $item->params = '{}';
                }

                $params = new Registry();
                if (is_string($item->params)) {
                    $params->loadString($item->params);
                }

                $item->params = $params;
            }
        }

        return $next($content);
    }
}
