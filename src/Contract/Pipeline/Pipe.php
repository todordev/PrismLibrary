<?php
/**
 * @package Prism\Library\Prism\Contract\Pipeline
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Pipeline;

use Closure;

/**
 * Interface of pipe command
 *
 * @package Prism\Library\Prism\Contract\Pipeline
 */
interface Pipe
{
    public function handle($content, Closure $next);
}
