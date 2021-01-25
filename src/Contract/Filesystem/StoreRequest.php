<?php
/**
 * @package      Prism\Library\Prism\Contract\Filesystem
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Contract\Filesystem;

use Prism\Library\Prism\Filesystem\Path;
use Prism\Library\Prism\Filesystem\Storage\FileData;

/**
 * Interface of file storing requests.
 *
 * @package Prism\Library\Prism\Contract\Filesystem
 */
interface StoreRequest
{
    public function getFileData(): FileData;
    public function getFilename(): string;
    public function getDestinationPath(): Path;
    public function getFilenameLength(): int;
}
