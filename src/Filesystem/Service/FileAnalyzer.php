<?php
/**
 * @package     Prism\Library\Prism\Filesystem\Service
 * @subpackage
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Prism\Library\Prism\Filesystem\Service;

use Joomla\CMS\Filesystem\File as JoomlaFile;
use Prism\Library\Prism\Filesystem\File;

final class FileAnalyzer
{
    private File $file;
    private array $imageExtensions;
    private array $imageMime;

    /**
     * Initialize the object.
     *
     * <code>
     * $file = new Prism\Library\Prism\Filesystem\File();
     * $analyzer = new Prism\Library\Prism\Filesystem\Service\FileAnalyzer($file);
     * </code>
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->imageExtensions = ['jpg', 'jpeg', 'webp', 'gif', 'png'];
        $this->imageMime = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/webp'];
    }

    /**
     * Check if the file extension belongs to image.
     * <code>
     * $file = new Prism\Library\Prism\Filesystem\File();
     * $analyzer = new Prism\Library\Prism\Filesystem\Service\FileAnalyzer($file);
     *
     * $analyzer->hasImageExtension();
     * </code>
     *
     * @return bool
     */
    public function hasImageExtension(): bool
    {
        return ($this->file->getExtension() && in_array($this->file->getExtension(), $this->imageExtensions, true));
    }

    /**
     * Check if the the MIME type of the file is an MIME of image.
     *
     * <code>
     * $file = new Prism\Library\Prism\Filesystem\File();
     * $analyzer = new Prism\Library\Prism\Filesystem\Service\FileAnalyzer($file);
     *
     * $analyzer->hasImageMimeType();
     * </code>
     *
     * @return bool
     */
    public function hasImageMimeType(): bool
    {
        return ($this->file->getMime() && in_array($this->file->getMime(), $this->imageMime, true));
    }

    /**
     * Check if the file is an image.
     *
     * <code>
     * $file = new Prism\Library\Prism\Filesystem\File();
     * $analyzer = new Prism\Library\Prism\Filesystem\Service\FileAnalyzer($file);
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
