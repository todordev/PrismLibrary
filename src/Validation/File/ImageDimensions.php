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
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Image\Image;
use Joomla\CMS\Language\Text;
use Prism\Library\Prism\Validation\ErrorMessage;
use Prism\Library\Prism\Validation\Validation;

/**
 * This class provides functionality for validating an image size.
 *
 * @package      Prism
 * @subpackage   Files\Validators\Images
 */
class ImageDimensions extends Validation
{
    protected string $file;
    protected int $minWidth  = 0;
    protected int $minHeight = 0;
    protected int $maxWidth  = 0;
    protected int $maxHeight = 0;

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     * $validation = new Validation\ImageDimensions($myFile);
     * </code>
     *
     * @param string $file A path to the file.
     */
    public function __construct($file = '')
    {
        $this->file = Path::clean($file);
    }

    /**
     * Set the minimum allowed width of the image.
     * <code>
     * $minWidth  = 200;
     * $validation = new Validation\ImageDimensions();
     * $validation->setMinWidth($minWidth);
     * </code>
     *
     * @param int $width
     * @return ImageDimensions
     */
    public function setMinWidth(int $width): ImageDimensions
    {
        $this->minWidth = $width;
        return $this;
    }

    /**
     * Set the minimum allowed height of the image.
     * <code>
     * $minHeight  = 200;
     * $validation = new Validation\ImageDimensions();
     * $validation->setMinHeight($minHeight);
     * </code>
     *
     * @param int $height
     * @return ImageDimensions
     */
    public function setMinHeight(int $height): ImageDimensions
    {
        $this->minHeight = $height;
        return $this;
    }

    /**
     * Set the maximum allowed width of the image.
     * <code>
     * $maxWidth  = 200;
     * $validation = new Validation\ImageDimensions();
     * $validation->setMaxWidth($minWidth);
     * </code>
     *
     * @param int $width
     * @return ImageDimensions
     */
    public function setMaxWidth(int $width): ImageDimensions
    {
        $this->maxWidth = $width;
        return $this;
    }

    /**
     * Set the maximum allowed height of the image.
     * <code>
     * $maxHeight  = 200;
     * $validation = new Validation\ImageDimensions();
     * $validation->setMaxHeight($maxHeight);
     * </code>
     *
     * @param int $height
     * @return ImageDimensions
     */
    public function setMaxHeight(int $height): ImageDimensions
    {
        $this->maxHeight = $height;
        return $this;
    }

    /**
     * Validate image size.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validation = new Validation\ImageDimensions($myFile);
     * if ($validation->passes()) {
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
     * $validation = new Validation\ImageDimensions($myFile);
     *
     * if ($validation->fails()) {
     *     echo $validation->getMessage();
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
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_DOES_NOT_EXISTS', $this->file));
            return false;
        }
        $imageProperties = Image::getImageFileProperties($this->file);

        // Check the minimum width of the image.
        if (($this->minWidth > 0) && ($imageProperties->width < $this->minWidth)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MIN_WIDTH', $this->minWidth));
            return false;
        }

        // Check the minimum height of the image.
        if (($this->minHeight > 0) && ($imageProperties->height < $this->minHeight)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MIN_HEIGHT', $this->minHeight));
            return false;
        }

        // Check the maximum width of the image.
        if (($this->maxWidth > 0) && ($imageProperties->width > $this->maxWidth)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MAX_WIDTH', $this->maxWidth));
            return false;
        }

        // Check the maximum height of the image.
        if (($this->maxHeight > 0) && ($imageProperties->height > $this->maxHeight)) {
            $this->errorMessage = new ErrorMessage(Text::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MAX_HEIGHT', $this->maxHeight));
            return false;
        }

        return true;
    }
}
