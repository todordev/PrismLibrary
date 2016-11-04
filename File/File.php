<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File;

use Prism\Validator\Validator;
use Joomla\String\StringHelper;

defined('JPATH_PLATFORM') or die;

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

    /**
     * @var UploaderInterface
     *
     * @deprecated v1.17
     */
    protected $uploader;

    /**
     * @var array
     *
     * @deprecated v1.17
     */
    protected $removers   = array();

    protected $validators = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\File\File($myFile);
     * </code>
     *
     * @param  mixed $file
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($file)
    {
        $this->file = \JPath::clean($file);
    }

    /**
     * Set an object that will be used for uploading files.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $uploader = new Prism\File\Uploader\Local();
     *
     * $file = new Prism\File\File($myFile);
     * $file->setUploader($uploader);
     * </code>
     *
     * @param UploaderInterface $uploader
     *
     * @deprecated v1.17
     */
    public function setUploader(UploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Get a file location ( path and file name ).
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\File\File($myFile);
     * $file->upload();
     *
     * $myNewFileLocation = $file->getFile();
     * </code>
     *
     * @return string
     *
     * @deprecated v1.17
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Upload a file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $uploader = new Prism\File\Uploader\Local();
     *
     * $file = new Prism\File\File($myFile);
     * $file->setUploader($uploader);
     *
     * $file->upload();
     * </code>
     *
     * @param  array $file An array that comes from JInput.
     * @param  string $destination Destination where the file is going to be saved.
     *
     * @deprecated v1.17
     */
    public function upload(array $file = array(), $destination = '')
    {
        if (count($file) > 0) {
            $this->uploader->setFile($file);
        }

        if (StringHelper::strlen($destination) > 0) {
            $this->uploader->setDestination($destination);
        }

        $this->uploader->upload();

        $this->file = \JPath::clean($this->uploader->getDestination());
    }

    /**
     * Add an object that validates the file.
     *
     * <code>
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File();
     * $file->addValidator($validator);
     * </code>
     *
     * @param  Validator $validator An object that validate a file.
     * @param  bool $reset Remove existing validators.
     *
     * @return self
     */
    public function addValidator(Validator $validator, $reset = false)
    {
        if ($reset !== false) {
            $this->validators = array();
        }

        $this->validators[] = $validator;

        return $this;
    }

    /**
     * Add an object that removes the file.
     *
     * <code>
     * $remover = new Prism\File\Remover\Local();
     *
     * $file = new Prism\File\File();
     * $file->addRemover($remover);
     * </code>
     *
     * @param  RemoverInterface $remover An object that validate a file.
     * @param  bool $reset Reset existing removers.
     *
     * @return self
     * @deprecated v1.17
     */
    public function addRemover(RemoverInterface $remover, $reset = false)
    {
        if ($reset) {
            $this->removers = array();
        }

        if (!$remover->getFile()) {
            $remover->setFile($this->file);
        }

        $this->removers[] = $remover;

        return $this;
    }

    /**
     * Validate the file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File($myFile);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     * ...
     * )
     * </code>
     */
    public function isValid()
    {
        /** @var $validator Validator */
        foreach ($this->validators as $validator) {
            if (!$validator->isValid()) {
                $this->errors[] = $validator->getMessage();
                $this->errorAdditionalInformation[] = $validator->getAdditionalInformation();
                return false;
            }
        }

        return true;
    }

    /**
     * Remove the file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $remover = new Prism\File\Remover\Local();
     *
     * $file = new Prism\File\File($myFile);
     * $file->addRemover($remover);
     *
     * $file->remove();
     * </code>
     *
     * @deprecated v1.17
     */
    public function remove()
    {
        /** @var  $remover RemoverInterface */
        foreach ($this->removers as $remover) {
            $remover->remove();
        }

        $this->file = '';
    }

    /**
     * Return all error messages.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\Image($myFile);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     $errors = $file->getErrors();
     * )
     * </code>
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Return last error message.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getError();
     * )
     * </code>
     *
     * @return string
     */
    public function getError()
    {
        return end($this->errors);
    }

    /**
     * Return latest record from the additional information about error.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getErrorAdditionalInformation();
     * )
     * </code>
     *
     * @return string
     */
    public function getErrorAdditionalInformation()
    {
        return end($this->errorAdditionalInformation);
    }

    /**
     * Check if the file name has extension of an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\File\File($filePath);
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
    public function isImage()
    {
        // Check file extension and its mime type.
        return ($this->hasImageExtension() and $this->hasImageMime());
    }

    /**
     * Check if file is a video.
     *
     * <code>
     * $filePath = '/tmp/video.avi';
     * $file     = new Prism\File\File($filePath);
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
    public function isVideo()
    {
        // Check file extension and its mime type.
        return false;
    }

    /**
     * Check if the file name has extension of an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\File\File($filePath);
     *
     * $filetype = $file->getFiletype()
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function getFiletype()
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
     * $file     = new Prism\File\File($filePath);
     *
     * $fileData = $file->extractFileData();
     * </code>
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function extractFileData()
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
        $this->fileData['extension'] = \JFile::getExt(basename($this->fileData['filename']));

        if ($this->isImage()) {
            $imageProperties = \JImage::getImageFileProperties($this->file);

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
     * $file     = new Prism\File\File($filePath);
     *
     * if ($file->hasImageExtension()) {
     * // ...
     * }
     * </code>
     *
     * @return bool
     */
    public function hasImageExtension()
    {
        $extensions     = array('jpg', 'jpeg', 'bmp', 'gif', 'png');
        $fileExtension  = \JFile::getExt(basename($this->file));

        return (($fileExtension !== null and $fileExtension !== '') and in_array($fileExtension, $extensions, true));
    }

    /**
     * Check if a mime type is an image.
     *
     * <code>
     * $filePath = '/tmp/picture1.png';
     * $file     = new Prism\File\File($filePath);
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
    public function hasImageMime()
    {
        $result = false;

        if (extension_loaded('gd') and function_exists('gd_info')) {
            $mimeTypes     = array('image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/x-windows-bmp');

            if (count($this->fileData) > 0) {
                $mimeType = $this->fileData['mime'];
            } else {
                $imageProperties = \JImage::getImageFileProperties($this->file);
                $mimeType = $imageProperties->mime;
            }

            if (in_array($mimeType, $mimeTypes, true)) {
                $result = true;
            }
        }

        return $result;
    }
}
