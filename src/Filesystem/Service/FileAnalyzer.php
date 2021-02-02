<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Service
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Service;

use Joomla\CMS\Filesystem\File;
use Prism\Library\Prism\Filesystem\Dto\FileAnalyzeRequest;

final class FileAnalyzer
{
    private string $filePath;
    private string $mimeType;
    private array $imageExtensions;
    private array $imageMime;

    /**
     * Initialize the object.
     * <code>
     * $filePath = '/var/www/mysite/images/logo.png';
     * $mimeType = 'image/png';
     * $analyzer = new FileAnalyzer($filePath, $mimeType);
     * </code>
     *
     * @param FileAnalyzeRequest $request
     */
    public function __construct(FileAnalyzeRequest $request)
    {
        $this->filePath = $request->getFilePath();
        $this->mimeType = $request->getMimeType();

        $this->imageExtensions = ['jpg', 'jpeg', 'webp', 'gif', 'png'];
        $this->imageMime = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/webp'];
    }

    /**
     * Check if the file extension belongs to image.
     * <code>
     * $filePath = '/var/www/mysite/images/logo.png';
     * $mimeType = 'image/png';
     * $analyzer = new FileAnalyzer($filePath, $mimeType);
     *
     * $analyzer->hasImageExtension();
     * </code>
     *
     * @return bool
     */
    public function hasImageExtension(): bool
    {
        $extension = File::getExt(basename($this->filePath));
        return ($extension && in_array($extension, $this->imageExtensions, true));
    }

    /**
     * Check if the the MIME type of the file is an MIME of image.
     *
     * <code>
     * $filePath = '/var/www/mysite/images/logo.png';
     * $mimeType = 'image/png';
     * $analyzer = new FileAnalyzer($filePath, $mimeType);
     *
     * $analyzer->hasImageMimeType();
     * </code>
     *
     * @return bool
     */
    public function hasImageMimeType(): bool
    {
        return ($this->mimeType && in_array($this->mimeType, $this->imageMime, true));
    }

    /**
     * Check if the file is an image.
     *
     * <code>
     * $filePath = '/var/www/mysite/images/logo.png';
     * $mimeType = 'image/png';
     * $analyzer = new FileAnalyzer($filePath, $mimeType);
     *
     * $analyzer->isImage();
     * </code>
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return ($this->hasImageExtension() && $this->hasImageMimeType());
    }
}
