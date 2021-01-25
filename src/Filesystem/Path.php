<?php
/**
 * @package      Prism\Library\Prism\Filesystem
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem;

final class Path
{
    /**
     * Path to the storage folder.
     * @var string
     */
    private string $storagePath;

    /**
     * Relative path from the root folder.
     * @var string
     */
    private string $relativePath;

    /**
     * Path constructor.
     *
     * @param string $storagePath
     * @param string $relativePath
     */
    public function __construct(string $storagePath, string $relativePath)
    {
        $this->storagePath = $storagePath;
        $this->relativePath = $relativePath;
    }

    /**
     * @return string
     */
    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    /**
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relativePath;
    }
}
