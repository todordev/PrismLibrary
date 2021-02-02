<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

use Prism\Library\Prism\Contract\Filesystem\RemoveRequest;

/**
 * Request to local storage for move a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class MoveRequest implements RemoveRequest
{
    private string $filename;
    private string $relativePath;
    private string $newRelativePath;

    /**
     * @param string $filename
     * @param string $relativePath
     * @param string $newRelativePath
     */
    public function __construct(string $filename, string $relativePath, string $newRelativePath)
    {
        $this->filename = $filename;
        $this->relativePath = $relativePath;
        $this->newRelativePath = $newRelativePath;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    /**
     * @return string
     */
    public function getNewRelativePath(): string
    {
        return $this->newRelativePath;
    }
}
