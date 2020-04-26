<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Filesystem;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Image\Image;
use Prism\Library\Validator\Validation;
use Joomla\CMS\Filesystem\File as JoomlaFile;

/**
 * This class provides functionality for uploading files and
 * validates the process.
 *
 * @package      Prism
 * @subpackage   Files
 */
class File
{
    protected $file;
    protected $fileData = array();

    protected $errors = array();
    protected $errorAdditionalInformation = array();

    protected $validators = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\Library\Filesystem\File($myFile);
     * </code>
     *
     * @param  mixed $file
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($file)
    {
        $this->file = Path::clean($file);
    }


    /**
     * Add an object that validates the file.
     *
     * <code>
     * $validator = new Prism\Library\File\Validator\Image();
     *
     * $file = new Prism\Library\File\File();
     * $file->addValidator($validator);
     * </code>
     *
     * @param  Validation $validator An object that validate a file.
     *
     * @return self
     */
    public function addValidation(Validation $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * Validate the file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\File\Validator\Image();
     *
     * $file = new Prism\Library\File\File($myFile);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     * ...
     * )
     * </code>
     */
    public function isValid(): bool
    {
        /** @var $validator Validation */
        foreach ($this->validators as $validator) {
            if ($validator->fails()) {
                $this->errors[] = $validator->getMessage();
                $this->errorAdditionalInformation[] = $validator->getAdditionalInformation();
                return false;
            }
        }

        return true;
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
     * Return last error message.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\File\Validator\Image();
     *
     * $file = new Prism\Library\File\File($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getError();
     * )
     * </code>
     *
     * @return string
     */
    public function getError(): string
    {
        return end($this->errors);
    }

    /**
     * Return latest record from the additional information about error.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\File\Validator\Image();
     *
     * $file = new Prism\Library\File\File($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getErrorAdditionalInformation();
     * )
     * </code>
     *
     * @return string
     */
    public function getErrorAdditionalInformation(): string
    {
        return end($this->errorAdditionalInformation);
    }

    /**
     * Check if the file name has extension of an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\File\File($filePath);
     *
     * if ($file->isImage()) {
     * // ...
     * }
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function isImage(): bool
    {
        // Check file extension and its mime type.
        return ($this->hasImageExtension() || $this->hasImageMime());
    }

    /**
     * Check if file is a video.
     *
     * <code>
     * $filePath = '/tmp/video.avi';
     * $file     = new Prism\Library\File\File($filePath);
     *
     * if ($file->isVideo()) {
     * // ...
     * }
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return bool
     * @todo Under construction.
     */
    public function isVideo(): bool
    {
        // Check file extension and its mime type.
        return false;
    }

    /**
     * Check if the file name has extension of an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\File\File($filePath);
     *
     * $filetype = $file->getFiletype()
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getFiletype(): string
    {
        $filetype = '';
        if ($this->isImage()) {
            $filetype = 'image';
        } elseif ($this->isVideo()) {
            $filetype = 'video';
        }

        return $filetype;
    }

    /**
     * Extract information about file using PHP Fileinfo.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\File\File($filePath);
     *
     * $fileData = $file->extractFileData();
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function extractFileData(): array
    {
        // Get mime type.
        if (function_exists('finfo_open')) {
            $finfo        = finfo_open(FILEINFO_MIME_TYPE);
            $this->fileData['mime'] = finfo_file($finfo, $this->file);
            finfo_close($finfo);
        }

        $this->fileData['filename']  = basename($this->file);
        $this->fileData['filesize']  = filesize($this->file);
        $this->fileData['filetype']  = $this->getFiletype();
        $this->fileData['extension'] = \Joomla\CMS\Filesystem\File::getExt(basename($this->fileData['filename']));

        if ($this->isImage()) {
            $imageProperties = Image::getImageFileProperties($this->file);

            $this->fileData['attributes'] = array(
                'type'   => $imageProperties->type,
                'width'  => $imageProperties->width,
                'height' => $imageProperties->height
            );
        }

        return $this->fileData;
    }

    /**
     * Check if the file name has extension of an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\File\File($filePath);
     *
     * if ($file->hasImageExtension()) {
     * // ...
     * }
     * </code>
     *
     * @return bool
     */
    public function hasImageExtension(): bool
    {
        $extensions     = array('jpg', 'jpeg', 'bmp', 'gif', 'png');
        $fileExtension  = JoomlaFile::getExt(basename($this->file));

        return (($fileExtension !== null and $fileExtension !== '') and in_array($fileExtension, $extensions, true));
    }

    /**
     * Check if a mime type is an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\Library\File\File($filePath);
     *
     * if ($file->hasImageMime()) {
     * // ...
     * }
     * </code>
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @return bool
     */
    public function hasImageMime(): bool
    {
        $result = false;

        if (function_exists('gd_info') && extension_loaded('gd')) {
            $mimeTypes    = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/x-windows-bmp'];

            if (count($this->fileData) > 0) {
                $mimeType = $this->fileData['mime'];
            } else {
                $imageProperties = Image::getImageFileProperties($this->file);
                $mimeType = $imageProperties->mime;
            }

            if (in_array($mimeType, $mimeTypes, true)) {
                $result = true;
            }
        }

        return $result;
    }
}
