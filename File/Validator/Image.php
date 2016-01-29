<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File\Validator;

use Prism\Validator\Validator;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for validating an image
 * by MIME type and file extensions.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Image extends Validator
{
    protected $file;
    protected $fileName;

    protected $mimeTypes;
    protected $imageExtensions;

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile     = '/tmp/myfile.tmp';
     * $fileName   = 'myfile.jpg';
     *
     * $validator = new Prism\File\Validator\Image($myFile, $fileName);
     * </code>
     *
     * @param string $file A path to the file.
     * @param string $fileName File name
     */
    public function __construct($file = '', $fileName = '')
    {
        $this->file     = \JPath::clean($file);
        $this->fileName = \JFile::makeSafe(basename($fileName));
    }

    /**
     * Set a location of a file.
     *
     * <code>
     * $myFile     = '/tmp/myfile.jpg';
     *
     * $validator = new Prism\File\Validator\Image();
     * $validator->setFile($myFile);
     * </code>
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = \JPath::clean($file);
    }

    /**
     * Set a file name.
     *
     * <code>
     * $fileName  = 'myfile.jpg';
     *
     * $validator = new Prism\File\Validator\Image();
     * $validator->setFileName($fileName);
     * </code>
     *
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = \JFile::makeSafe($fileName);
    }

    /**
     * Set a mime types that are allowed.
     *
     * <code>
     * $mimeTypes  = array('image/jpeg', 'image/gif');
     *
     * $validator = new Prism\File\Validator\Image();
     * $validator->setMimeTypes($mimeTypes);
     * </code>
     *
     * @param array $mimeTypes
     */
    public function setMimeTypes($mimeTypes)
    {
        $this->mimeTypes = $mimeTypes;
    }

    /**
     * Set a file extensions that are allowed.
     *
     * <code>
     * $imageExtensions  = array('jpg', 'png');
     *
     * $validator = new Prism\File\Validator\Image();
     * $validator->setImageExtensions($imageExtensions);
     * </code>
     *
     * @param array $imageExtensions
     */
    public function setImageExtensions($imageExtensions)
    {
        $this->imageExtensions = $imageExtensions;
    }

    /**
     * Validate image type and extension.
     *
     * <code>
     * $myFile     = '/tmp/myfile.jpg';
     * $fileName   = 'myfile.jpg';
     *
     * $validator = new Prism\File\Validator\Image($myFile, $fileName);
     *
     * if (!$validator->isValid()) {
     *     echo $validator->getMessage();
     * }
     * </code>
     *
     * @return bool
     */
    public function isValid()
    {
        if (!\JFile::exists($this->file)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_DOES_NOT_EXISTS', $this->file);
            return false;
        }
        $imageProperties = \JImage::getImageFileProperties($this->file);

        // Check mime type of the file
        if (!in_array($imageProperties->mime, $this->mimeTypes, true)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_TYPE', $this->file, $imageProperties->mime);
            return false;
        }

        // Check file extension
        $ext = \JString::strtolower(\JFile::getExt($this->fileName));

        if (!in_array($ext, $this->imageExtensions, true)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_EXTENSIONS_S', $this->file);
            return false;
        }

        return true;
    }
}
