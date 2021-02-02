<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

/**
 * Request to the service that will analyze a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class FileAnalyzeRequest
{
    private string $filePath;
    private string $mimeType;

    public function __construct(
        string $filePath,
        string $mimeType,
    ) {
        $this->filePath = $filePath;
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
