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
 * Request to local storage for removing a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class DeleteRequest implements RemoveRequest
{
    private string $filename;
    private string $relativePath;

    /**
     * @param string $filename
     * @param string $relativePath
     */
    public function __construct(string $filename, string $relativePath)
    {
        $this->filename = $filename;
        $this->relativePath = $relativePath;
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
}