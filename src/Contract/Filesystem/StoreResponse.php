<?php
/**
 * @package      Prism\Library\Prism\Contract\Filesystem
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Filesystem;

use Prism\Library\Prism\Filesystem\Path;

/**
 * Interface of file storing response.
 *
 * @package Prism\Library\Prism\Contract\Filesystem
 */
interface StoreResponse
{
    public function getPath(): Path;
    public function getFilename(): string;
}
