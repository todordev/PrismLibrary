<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File;

use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing currency.
 *
 * @package      Prism
 * @subpackage   Files
 */
class Image extends File
{
    /**
     * Create a thumbnail from an image file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $options = array(
     *     "destination" => "image/mypic.jpg",
     *     "width" => 200,
     *     "height" => 200,
     *     "scale" => JImage::SCALE_INSIDE
     * );
     *
     * $file = new PrismFileImage($myFile);
     * $file->createThumbnail($options);
     *
     * </code>
     *
     * @param  array $options Some options used in the process of generating thumbnail.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @return string A location to the new file.
     */
    public function createThumbnail($options)
    {
        $width       = ArrayHelper::getValue($options, "width", 100);
        $height      = ArrayHelper::getValue($options, "height", 100);
        $scale       = ArrayHelper::getValue($options, "scale", \JImage::SCALE_INSIDE);
        $destination = ArrayHelper::getValue($options, "destination");

        if (!$destination) {
            throw new \InvalidArgumentException(\JText::_("LIB_PRISM_ERROR_INVALID_FILE_DESTINATION"));
        }

        // Generate thumbnail.
        $image = new \JImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND', $this->file));
        }

        // Resize the file as a new object
        $thumb = $image->resize($width, $height, true, $scale);

        $fileName = basename($this->file);
        $ext      = \JString::strtolower(\JFile::getExt(\JFile::makeSafe($fileName)));

        switch ($ext) {
            case "gif":
                $type = IMAGETYPE_GIF;
                break;

            case "png":
                $type = IMAGETYPE_PNG;
                break;

            case IMAGETYPE_JPEG:
            default:
                $type = IMAGETYPE_JPEG;
        }

        $thumb->toFile($destination, $type);

        return $destination;
    }
}
