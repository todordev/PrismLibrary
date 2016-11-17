<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File;

use Joomla\Registry\Registry;
use Prism\Constants;
use Prism\Utilities\StringHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing currency.
 *
 * @package      Prism
 * @subpackage   Files
 */
class Image
{
    /**
     * The file that will be processed.
     *
     * @var string
     */
    protected $file;

    /**
     * Initialize the object.
     *
     * <code>
     * $file        = '/tmp/picture.jpg';
     * $destinationFolder  = "/root/joomla/tmp";
     *
     * $image = new Prism\File\Image($file);
     * </code>
     *
     * @param  string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Resize the temporary file to new one.
     *
     * <code>
     * $file = $this->input->files->get('media', array(), 'array');
     * $destinationFolder = "/root/joomla/tmp";
     *
     * $resizeOptions = array(
     *    'width'  => $options['thumb_width'],
     *    'height' => $options['thumb_height'],
     *    'scale'  => \JImage::SCALE_INSIDE
     * );
     *
     * $file = new Prism\File\Image($file['tmp_path']);
     *
     * $fileData = $file->resize($destinationFolder, $resizeOptions);
     * </code>
     *
     * @param  string $destinationFolder The folder where the file will be stored.
     * @param  Registry $options
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function resize($destinationFolder, Registry $options)
    {
        if (!$this->file) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        if (!\JFolder::exists($destinationFolder) and !\JFolder::create($destinationFolder)) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_CANNOT_CREATE_FOLDER_S', $destinationFolder));
        }

        // Resize image.
        $image = new \JImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_IMAGE', $this->file));
        }

        // Resize to general size.
        $width      = $options->get('width', 640);
        $width      = ($width < 50) ? 50 : $width;
        $height     = $options->get('height', 480);
        $height     = ($height < 50) ? 50 : $height;
        $scale      = $options->get('scale', \JImage::SCALE_INSIDE);
        $createNew  = (bool)$options->get('create_new', Constants::NO);

        if ($createNew) {
            $image = $image->resize($width, $height, $createNew, $scale);
        } else {
            $image->resize($width, $height, $createNew, $scale);
        }

        return $this->saveFile($image, $destinationFolder, $options);
    }

    /**
     * Crop an image.
     *
     * <code>
     * $file = $this->input->files->get('media', array(), 'array');
     * $destinationFolder = "/root/joomla/tmp";
     *
     * $resizeOptions = array(
     *    'width'  => $options['thumb_width'],
     *    'height' => $options['thumb_height'],
     *    'x'  => 100,
     *    'y'  => 100,
     * );
     *
     * $file = new Prism\File\Image($file['tmp_path']);
     *
     * $fileData = $file->crop($destinationFolder, $resizeOptions);
     * </code>
     *
     * @param  string $destinationFolder The folder where the file will be stored.
     * @param  Registry $options
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function crop($destinationFolder, Registry $options)
    {
        if (!$this->file) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        if (!\JFolder::exists($destinationFolder) and !\JFolder::create($destinationFolder)) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_CANNOT_CREATE_FOLDER_S', $destinationFolder));
        }

        // Resize image.
        $image = new \JImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_IMAGE', $this->file));
        }

        // Resize to general size.
        $width      = $options->get('width', 200);
        $width      = ($width < 50) ? 50 : $width;
        $height     = $options->get('height', 200);
        $height     = ($height < 50) ? 50 : $height;
        $left       = (int)abs($options->get('x', 0));
        $top        = (int)abs($options->get('y', 0));
        $createNew  = (bool)$options->get('create_new', Constants::NO);

        if ($createNew) {
            $image = $image->crop($width, $height, $left, $top, $createNew);
        } else {
            $image->crop($width, $height, $left, $top, $createNew);
        }

        return $this->saveFile($image, $destinationFolder, $options);
    }

    protected function saveFile(\JImage $image, $destinationFolder, Registry $options)
    {
        $filename = \JFile::makeSafe(basename($this->file));
        $ext      = \JFile::getExt($filename);

        // Generate new name.
        $newFilename   = \JFile::makeSafe(basename($options->get('filename')));
        $generatedName = $newFilename;
        if (!$newFilename) {
            $generatedName = StringHelper::generateRandomString($options->get('filename_length', 16));
        }

        // Set prefix
        $prefix  = \JFile::makeSafe($options->get('prefix'));
        if (is_string($prefix) and $prefix !== '') {
            $generatedName = $prefix.$generatedName;
        }

        // Set suffix
        $suffix  = \JFile::makeSafe($options->get('suffix'));
        if (is_string($suffix) and $suffix !== '') {
            $generatedName .= $suffix;
        }

        // Add the extension to the file.
        $generatedName  .= '.'.$ext;
        $destinationFile = \JPath::clean($destinationFolder .'/'. $generatedName, '/');

        // Resize the image.
        switch ($ext) {
            case 'png':
                $quality    = (int)$options->get('quality', Constants::QUALITY_HIGH);
                $optimizationOptions = array();
                if ($quality > 0) {
                    if ($quality > 9) {
                        $quality /= 10;
                    }

                    $optimizationOptions = array('quality' => $quality);
                }

                $image->toFile($destinationFile, IMAGETYPE_PNG, $optimizationOptions);
                break;

            case 'jpg':
            case 'jpeg':
                $quality    = (int)$options->get('quality', Constants::QUALITY_HIGH);
                $optimizationOptions = array();
                if ($quality > 0) {
                    $optimizationOptions = array('quality' => $quality);
                }

                $image->toFile($destinationFile, IMAGETYPE_JPEG, $optimizationOptions);
                break;

            case 'gif':
                $image->toFile($destinationFile, IMAGETYPE_GIF);
                break;
        }

        // Prepare meta data about the file.
        $file     = new File($destinationFile);
        $fileData = $file->extractFileData();
        $fileData['filepath'] = $destinationFile;

        return $fileData;
    }
}
