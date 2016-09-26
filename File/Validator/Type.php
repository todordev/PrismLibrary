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
 * This class provides functionality for validating a file
 * by MIME type and file extensions.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Type extends Validator
{
    protected $file;
    protected $fileName;

    protected $mimeTypes;
    protected $legalExtensions;

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     * $fileName   = "myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Type($myFile, $fileName);
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
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Type();
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
     * $fileName  = "myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Type();
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
     * $mimeTypes  = array("image/jpeg", "image/gif");
     *
     * $validator = new Prism\File\Validator\Type();
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
     * $legalExtensions  = array("jpg", "png");
     *
     * $validator = new Prism\File\Validator\Type();
     * $validator->setLegalExtensions($legalExtensions);
     * </code>
     *
     * @param array $legalExtensions
     */
    public function setLegalExtensions($legalExtensions)
    {
        $this->legalExtensions = $legalExtensions;
    }

    /**
     * Validate the file by MIME type and extension.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     * $fileName   = "myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Type($myFile, $fileName);
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
        if (!extension_loaded('fileinfo')) {
            throw new \RuntimeException(\JText::_('LIB_PRISM_ERROR_EXTENSION_FILEINFO'));
        }

        if (!\JFile::exists($this->file)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_DOES_NOT_EXISTS', $this->file);
            return false;
        }

        // Get mime type
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $this->file);
        finfo_close($fileInfo);

        // Check mime type of the file
        if (!in_array($mimeType, $this->mimeTypes, true)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_TYPE', $this->fileName, $mimeType);
            return false;
        }

        // Check file extension
        $ext = \JString::strtolower(\JFile::getExt($this->fileName));

        if (!in_array($ext, $this->legalExtensions, true)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_EXTENSIONS', $ext);
            return false;
        }

        return true;
    }
}
