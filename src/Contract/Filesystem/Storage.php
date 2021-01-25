<?php
/**
 * @package      Prism\Library\Prism\Contract\Filesystem
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Filesystem;

/**
 * Interface of file storage.
 *
 * @package Prism\Library\Prism\Contract\Filesystem
 */
interface Storage
{
    public function remove(RemoveRequest $request): void;
}
