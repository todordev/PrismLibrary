<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation\File;

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Language\Text;
use Joomla\String\StringHelper;
use Prism\Library\Prism\Validation\ErrorMessage;
use Prism\Library\Prism\Validation\Validation;

/**
 * This class provides functionality for validating a file
 * by MIME type and file extensions.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Type extends Validation
{
    protected string $file;
    protected string $fileName;

    protected array $mimeTypes;
    protected array $legalExtensions;

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     * $fileName   = "myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Type($myFile, $fileName);
     * </code>
     *
     * @param string $file A path to the file.
     * @param string $fileName File name
     */
    public function __construct(string $file, string $fileName)
    {
        $this->file     = $file;
        $this->fileName = $fileName;
    }

    /**
     * Set a mime types that are allowed.
     *
     * <code>
     * $mimeTypes  = array("image/jpeg", "image/gif");
     *
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Type();
     * $validator->setMimeTypes($mimeTypes);
     * </code>
     *
     * @param array $mimeTypes
     */
    public function setMimeTypes(array $mimeTypes): void
    {
        $this->mimeTypes = $mimeTypes;
    }

    /**
     * Set a file extensions that are allowed.
     *
     * <code>
     * $legalExtensions  = array("jpg", "png");
     *
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Type();
     * $validator->setLegalExtensions($legalExtensions);
     * </code>
     *
     * @param array $legalExtensions
     */
    public function setLegalExtensions(array $legalExtensions): void
    {
        $this->legalExtensions = $legalExtensions;
    }

    /**
     * Validate the file by MIME type and extension.
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     * $fileName   = "myfile.jpg";
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Type($myFile, $fileName);
     * if ($validator->passes()) {
     *     // ...
     * }
     * </code>
     *
     * @return bool
     * @throws \ErrorException
     */
    public function passes(): bool
    {
        return $this->validate();
    }

    /**
     * Validate the file by MIME type and extension.
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     * $fileName = "myfile.jpg";
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Type($myFile, $fileName);
     * if ($validator->fails()) {
     *     echo $validator->getMessage();
     * }
     * </code>
     *
     * @return bool
     * @throws \ErrorException
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    private function validate(): bool
    {
        if (!extension_loaded('fileinfo')) {
            throw new \ErrorException(\JText::_('LIB_PRISM_ERROR_EXTENSION_FILEINFO'));
        }

        if (!File::exists($this->file)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_DOES_NOT_EXISTS', $this->file));
            return false;
        }

        // Get mime type
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $this->file);
        finfo_close($fileInfo);

        // Check mime type of the file
        if (!in_array($mimeType, $this->mimeTypes, true)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_TYPE', $this->fileName, $mimeType));
            return false;
        }

        // Check file extension
        $extension = StringHelper::strtolower(File::getExt($this->fileName));
        if (!in_array($extension, $this->legalExtensions, true)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_EXTENSIONS', $extension));
            return false;
        }

        return true;
    }
}
