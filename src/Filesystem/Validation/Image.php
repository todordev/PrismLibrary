<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Filesystem\Validation;

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Language\Text;
use Prism\Library\Validator\Validation;
use Joomla\String\StringHelper;

/**
 * This class provides functionality for validating an image
 * by MIME type and file extensions.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Image extends Validation
{
    protected $file;
    protected $filename;

    protected $mimeTypes;
    protected $imageExtensions;

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile     = '/tmp/myfile.tmp';
     * $filename   = 'myfile.jpg';
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image($myFile, $fileName);
     * </code>
     *
     * @param string $file A path to the file.
     * @param string $filename File name
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($file = '', $filename = '')
    {
        $this->file = Path::clean($file);
        $this->filename = File::makeSafe(basename($filename));
    }

    /**
     * Set a location of a file.
     *
     * <code>
     * $myFile     = '/tmp/myfile.jpg';
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image();
     * $validator->setFile($myFile);
     * </code>
     *
     * @param string $file
     *
     * @return Image
     * @throws \UnexpectedValueException
     */
    public function setFile($file)
    {
        $this->file = Path::clean($file);

        return $this;
    }

    /**
     * Set a file name.
     *
     * <code>
     * $filename  = 'myfile.jpg';
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image();
     * $validator->setFilename($filename);
     * </code>
     *
     * @param string $filename
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = File::makeSafe($filename);

        return $this;
    }

    /**
     * Set a mime types that are allowed.
     *
     * <code>
     * $mimeTypes  = array('image/jpeg', 'image/gif');
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image();
     * $validator->setMimeTypes($mimeTypes);
     * </code>
     *
     * @param array $mimeTypes
     * @return Image
     */
    public function setMimeTypes($mimeTypes)
    {
        $this->mimeTypes = $mimeTypes;

        return $this;
    }

    /**
     * Set a file extensions that are allowed.
     *
     * <code>
     * $imageExtensions  = array('jpg', 'png');
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image();
     * $validator->setImageExtensions($imageExtensions);
     * </code>
     *
     * @param array $imageExtensions
     * @return Image
     */
    public function setImageExtensions($imageExtensions)
    {
        $this->imageExtensions = $imageExtensions;

        return $this;
    }

    /**
     * Validate image type and extension.
     *
     * <code>
     * $myFile     = '/tmp/myfile.jpg';
     * $fileName   = 'myfile.jpg';
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image($myFile, $fileName);
     *
     * if ($validator->passes()) {
     *     // ....
     * }
     * </code>
     *
     * @return bool
     * @throws \RuntimeException
     *
     * @throws \InvalidArgumentException
     */
    public function passes(): bool
    {
        return $this->validate();
    }

    /**
     * Validate image type and extension.
     *
     * <code>
     * $myFile     = '/tmp/myfile.jpg';
     * $fileName   = 'myfile.jpg';
     *
     * $validator = new Prism\Library\Filesystem\Validation\Image($myFile, $fileName);
     *
     * if ($validator->fails()) {
     *     echo $validator->getMessage();
     * }
     * </code>
     *
     * @return bool
     * @throws \RuntimeException
     *
     * @throws \InvalidArgumentException
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    protected function validate(): bool
    {
        if (!File::exists($this->file)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_DOES_NOT_EXISTS', $this->file);
            return false;
        }
        $imageProperties = \Joomla\CMS\Image\Image::getImageFileProperties($this->file);

        // Check mime type of the file
        if (!in_array($imageProperties->mime, $this->mimeTypes, true)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_TYPE', $this->file, $imageProperties->mime);
            return false;
        }

        // Check file extension
        $ext = StringHelper::strtolower(File::getExt($this->filename));
        if (!in_array($ext, $this->imageExtensions, true)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_EXTENSIONS_S', $this->filename);
            return false;
        }

        return true;
    }
}
