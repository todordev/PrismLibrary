<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Service;

use Joomla\CMS\Image\Image;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use Prism\Library\Prism\Filesystem\Dto\ExtractorResponse;
use Prism\Library\Prism\Filesystem\Dto\FileAnalyzeRequest;
use Prism\Library\Prism\Filesystem\File;

/**
 * This class provides functionality extraction data about a file.
 *
 * @package      Prism
 * @subpackage   Filesystem
 */
class FileDataExtractor
{
    protected string $file;
    protected $errors = [];

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\Library\Prism\Filesystem\ExtractingFileData($myFile);
     * </code>
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Extract information about file using PHP Fileinfo.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\Prism\Filesystem\ExtractingFileData($filePath);
     *
     * $fileData = $file->process();
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return ExtractorResponse
     */
    public function process(): ExtractorResponse
    {
        $mimeType = $this->getMimeType();

        $fileTypeDetector = new DetectingFileType($mimeType);

        return new ExtractorResponse(
            basename($this->file),
            filesize($this->file),
            $mimeType,
            JoomlaFile::getExt($this->file),
            $fileTypeDetector->getType()
        );
    }

    private function getMimeType()
    {
        // Get mime type.
        $mimeType = '';
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $this->file);
            finfo_close($finfo);
        }

        return $mimeType;
    }

    /**
     * Extract information about file using PHP Fileinfo.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\Prism\Filesystem\ExtractingFileData($filePath);
     *
     * $imageData = $file->processImage();
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function processImage(): array
    {
        $mimeType = $this->getMimeType();

        $attributes = [];

        $fileAnalyzer = new FileAnalyzer(new FileAnalyzeRequest($this->file, $mimeType));
        if ($fileAnalyzer->isImage()) {
            $imageProperties = Image::getImageFileProperties($this->file);

            $attributes = [
                'type'   => $imageProperties->type,
                'width'  => $imageProperties->width,
                'height' => $imageProperties->height
            ];
        }

        return $attributes;
    }
}
