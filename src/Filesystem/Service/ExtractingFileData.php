<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Filesystem\Service;

use Joomla\CMS\Image\Image;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use Prism\Library\Filesystem\File;

/**
 * This class provides functionality extraction data about a file.
 *
 * @package      Prism
 * @subpackage   Filesystem
 */
class ExtractingFileData
{
    protected $file;
    protected $errors = [];

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\Library\Filesystem\ExtractingFileData($myFile);
     * </code>
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function hasErrors(): bool
    {
        return $this->errors ? true : false;
    }

    /**
     * Return all error messages.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\File\Validator\Image();
     *
     * $file = new Prism\Library\File\Image($myFile);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     $errors = $file->getErrors();
     * )
     * </code>
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Return the latest error message.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\File\Validator\Image();
     *
     * $file = new Prism\Library\Filesystem\ExtractingFileData($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getError();
     * )
     * </code>
     *
     * @return string
     */
    public function getLatestError(): string
    {
        return end($this->errors);
    }

    /**
     * Extract information about file using PHP Fileinfo.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\Filesystem\ExtractingFileData($filePath);
     *
     * $fileData = $file->extract();
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return File
     */
    public function process(): File
    {
        $file = new File();

        // Get mime type.
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file->setMime(finfo_file($finfo, $this->file));
            finfo_close($finfo);
        }

        $file->setFileName(basename($this->file));
        $file->setFileSize(filesize($this->file));
        $file->setExtension(JoomlaFile::getExt($this->fileData['filename']));

        $fileTypeDetector = new DetectingFileType($this->fileData['mime']);
        $file->setFileType($fileTypeDetector->getType());

        if ($file->hasImageExtension() && $file->isImage()) {
            $imageProperties = Image::getImageFileProperties($this->file);

            $file->setAttributes(
                [
                    'type'   => $imageProperties->type,
                    'width'  => $imageProperties->width,
                    'height' => $imageProperties->height
                ]
            );
        }

        return $file;
    }
}
