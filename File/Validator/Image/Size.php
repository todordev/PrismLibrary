<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File\Validator\Image;

use Prism\validator\Validator;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for validating an image size.
 *
 * @package      Prism
 * @subpackage   Files\Validators\Images
 */
class Size extends Validator
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
     * $validator = new PrismFileValidatorImageSize($myFile);
     * </code>
     *
     * @param string $file A path to the file.
     */
    public function __construct($file = '')
    {
        $this->file     = \JPath::clean($file);
    }

    /**
     * Set a location of a file.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     *
     * $validator = new PrismFileValidatorImageSize();
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
     * Set the minimum allowed width of the image.
     *
     * <code>
     * $minWidth  = 200;
     *
     * $validator = new PrismFileValidatorImageSize();
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
     * $validator = new PrismFileValidatorImageSize();
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
     * $validator = new PrismFileValidatorImageSize();
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
     * $validator = new PrismFileValidatorImageSize();
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
     * $validator = new PrismFileValidatorImageSize($myFile);
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

        // Check the minimum width of the image.
        if (($this->minWidth > 0) and ($imageProperties->width < $this->minWidth)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MIN_WIDTH', $this->minWidth);
            return false;
        }

        // Check the minimum height of the image.
        if (($this->minHeight > 0) and ($imageProperties->height < $this->minHeight)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MIN_HEIGHT', $this->minHeight);
            return false;
        }

        // Check the maximum width of the image.
        if (($this->maxWidth > 0) and ($imageProperties->width > $this->maxWidth)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MAX_WIDTH', $this->maxWidth);
            return false;
        }

        // Check the maximum height of the image.
        if (($this->maxHeight > 0) and ($imageProperties->height > $this->maxHeight)) {
            $this->message = \JText::sprintf('LIB_PRISM_ERROR_FILE_IMAGE_MAX_HEIGHT', $this->maxHeight);
            return false;
        }

        return true;
    }
}
