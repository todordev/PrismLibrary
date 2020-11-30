<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\File\Filesystem\Validation;

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Image\Image;
use Joomla\CMS\Language\Text;
use Prism\Library\Prism\Validator\Validation;

/**
 * This class provides functionality for validating an image size.
 *
 * @package      Prism
 * @subpackage   Files\Validators\Images
 */
class ImageDimensions extends Validation
{
    protected $file;
    protected $minWidth  = 0;
    protected $minHeight = 0;
    protected $maxWidth  = 0;
    protected $maxHeight = 0;

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size($myFile);
     * </code>
     *
     * @param string $file A path to the file.
     */
    public function __construct($file = '')
    {
        $this->file = Path::clean($file);
    }

    /**
     * Set a location of a file.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size();
     * $validator->setFile($myFile);
     * </code>
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = Path::clean($file);
    }

    /**
     * Set the minimum allowed width of the image.
     *
     * <code>
     * $minWidth  = 200;
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size();
     * $validator->setMinWidth($minWidth);
     * </code>
     *
     * @param int $width
     */
    public function setMinWidth($width)
    {
        $this->minWidth = (int)$width;
    }

    /**
     * Set the minimum allowed height of the image.
     *
     * <code>
     * $minHeight  = 200;
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size();
     * $validator->setMinHeight($minHeight);
     * </code>
     *
     * @param int $height
     */
    public function setMinHeight($height)
    {
        $this->minHeight = (int)$height;
    }

    /**
     * Set the maximum allowed width of the image.
     *
     * <code>
     * $maxWidth  = 200;
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size();
     * $validator->setMaxWidth($minWidth);
     * </code>
     *
     * @param int $width
     */
    public function setMaxWidth($width)
    {
        $this->maxWidth = (int)$width;
    }

    /**
     * Set the maximum allowed height of the image.
     *
     * <code>
     * $maxHeight  = 200;
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size();
     * $validator->setMaxHeight($maxHeight);
     * </code>
     *
     * @param int $height
     */
    public function setMaxHeight($height)
    {
        $this->maxHeight = (int)$height;
    }

    /**
     * Validate image size.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size($myFile);
     *
     * if ($validator->passes()) {
     *     //....
     * }
     * </code>
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->validate();
    }

    /**
     * Validate image size.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\File\Filesystem\Image\Size($myFile);
     *
     * if ($validator->fails()) {
     *     echo $validator->getMessage();
     * }
     * </code>
     *
     * @return bool
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    public function validate(): bool
    {
        if (!File::exists($this->file)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_DOES_NOT_EXISTS', $this->file);
            return false;
        }
        $imageProperties = Image::getImageFileProperties($this->file);

        // Check the minimum width of the image.
        if (($this->minWidth > 0) && ($imageProperties->width < $this->minWidth)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MIN_WIDTH', $this->minWidth);
            return false;
        }

        // Check the minimum height of the image.
        if (($this->minHeight > 0) && ($imageProperties->height < $this->minHeight)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MIN_HEIGHT', $this->minHeight);
            return false;
        }

        // Check the maximum width of the image.
        if (($this->maxWidth > 0) && ($imageProperties->width > $this->maxWidth)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MAX_WIDTH', $this->maxWidth);
            return false;
        }

        // Check the maximum height of the image.
        if (($this->maxHeight > 0) && ($imageProperties->height > $this->maxHeight)) {
            $this->message = Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MAX_HEIGHT', $this->maxHeight);
            return false;
        }

        return true;
    }
}
