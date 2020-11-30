<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Service;

use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Prism\Library\Prism\Constants;
use Prism\Library\Prism\Utilities\StringHelper;
use Joomla\CMS\Image\Image as JoomlaImage;
use Joomla\CMS\Filesystem\Path as JoomlaPath;
use Joomla\CMS\Filesystem\File as JoomlaFile;

/**
 * This class contains methods that are used for managing currency.
 *
 * @package      Prism
 * @subpackage   Files
 */
class ProcessingImage
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
     * $image = new Prism\Library\Prism\File\Image($file);
     * </code>
     *
     * @param string $file
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
     * $file = new Prism\Library\Prism\File\Image($file['tmp_path']);
     *
     * $fileData = $file->resize($destinationFolder, $resizeOptions);
     * </code>
     *
     * @param string $destinationFolder The folder where the file will be stored.
     * @param Registry $options
     *
     * @return string
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @throws \RuntimeException
     */
    public function resize($destinationFolder, Registry $options)
    {
        if (!$this->file) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        if (!Folder::exists($destinationFolder) && !Folder::create($destinationFolder)) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_CANNOT_CREATE_FOLDER_S', $destinationFolder));
        }

        // Resize image.
        $image = new JoomlaImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_FILE_NOT_IMAGE', $this->file));
        }

        // Resize to general size.
        $width = $options->get('width', 640);
        $width = ($width < 25) ? 25 : $width;
        $height = $options->get('height', 480);
        $height = ($height < 25) ? 25 : $height;
        $scale = $options->get('scale', JoomlaImage::SCALE_INSIDE);
        $createNew = (bool)$options->get('create_new', Constants::NO);

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
     * $file = new Prism\Library\Prism\File\Image($file['tmp_path']);
     *
     * $fileData = $file->crop($destinationFolder, $resizeOptions);
     * </code>
     *
     * @param string $destinationFolder The folder where the file will be stored.
     * @param Registry $options
     *
     * @return string
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @throws \RuntimeException
     */
    public function crop($destinationFolder, Registry $options)
    {
        if (!$this->file) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        if (!Folder::exists($destinationFolder) && !Folder::create($destinationFolder)) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_CANNOT_CREATE_FOLDER_S', $destinationFolder));
        }

        // Resize image.
        $image = new JoomlaImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_FILE_NOT_IMAGE', $this->file));
        }

        // Resize to general size.
        $width = $options->get('width', 200);
        $width = ($width < 25) ? 25 : $width;
        $height = $options->get('height', 200);
        $height = ($height < 25) ? 25 : $height;
        $left = (int)abs($options->get('x', 0));
        $top = (int)abs($options->get('y', 0));
        $createNew = (bool)$options->get('create_new', Constants::NO);

        if ($createNew) {
            $image = $image->crop($width, $height, $left, $top, $createNew);
        } else {
            $image->crop($width, $height, $left, $top, $createNew);
        }

        return $this->saveFile($image, $destinationFolder, $options);
    }

    /**
     * Save the image file. It could be converted to another image type.
     *
     * <code>
     * $file = $this->input->files->get('media', array(), 'array');
     * $destinationFolder = "/root/joomla/tmp";
     *
     * $resizeOptions = array(
     *    'filename_length'  => 16,
     *    'suffix'           => '_image',
     *    'quality'          => Prism\Library\Prism\Constants::QUALITY_HIGH,
     *    'image_type'       => 'png'
     * );
     *
     * $file     = new Prism\Library\Prism\File\Image($file['tmp_path']);
     *
     * $fileData = $file->toFile($destinationFolder, $options);
     * </code>
     *
     * @param string $destinationFolder The folder where the file will be stored.
     * @param Registry $options
     *
     * @return string
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @throws \RuntimeException
     */
    public function toFile($destinationFolder, Registry $options)
    {
        if (!$this->file) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        if (!Folder::exists($destinationFolder) && !Folder::create($destinationFolder)) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_CANNOT_CREATE_FOLDER_S', $destinationFolder));
        }

        // Resize image.
        $image = new JoomlaImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(Text::sprintf('LIB_PRISM_ERROR_FILE_NOT_IMAGE', $this->file));
        }

        return $this->saveFile($image, $destinationFolder, $options);
    }

    protected function saveFile(JoomlaImage $image, $destinationFolder, Registry $options): string
    {
        $imageTypes = array('png', 'jpg', 'gif');

        $filename = JoomlaFile::makeSafe(basename($this->file));
        $ext = JoomlaFile::getExt($filename);

        // Set new image type.
        $imageType = $options->get('image_type');
        if ($imageType && in_array($imageType, $imageTypes, true)) {
            $ext = $imageType;
        }

        // Check for valid file extensions.
        if (!in_array($ext, $imageTypes, true)) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_IMAGE_EXTENSION', $this->file));
        }

        // Generate new name.
        $newFilename = JoomlaFile::makeSafe(basename($options->get('filename')));
        $generatedName = $newFilename;
        if (!$newFilename) {
            $generatedName = StringHelper::generateRandomString($options->get('filename_length', 16));
        }

        // Set prefix
        $prefix = JoomlaFile::makeSafe($options->get('prefix'));
        if (is_string($prefix) and $prefix !== '') {
            $generatedName = $prefix . $generatedName;
        }

        // Set suffix
        $suffix = JoomlaFile::makeSafe($options->get('suffix'));
        if (is_string($suffix) and $suffix !== '') {
            $generatedName .= $suffix;
        }

        // Add the extension to the file.
        $generatedName .= '.' . $ext;
        $destinationFile = JoomlaPath::clean($destinationFolder . '/' . $generatedName, '/');

        // Resize the image.
        switch ($ext) {
            case 'png':
                $quality = (int)$options->get('quality', Constants::QUALITY_HIGH);
                $optimizationOptions = array();
                if ($quality > 0) {
                    if ($quality > 9) {
                        $quality /= 10;
                        $quality = ($quality >= 10) ? 9 : $quality;
                    }

                    $optimizationOptions = array('quality' => $quality);
                }

                $image->toFile($destinationFile, IMAGETYPE_PNG, $optimizationOptions);
                break;

            case 'jpg':
            case 'jpeg':
                $quality = (int)$options->get('quality', Constants::QUALITY_HIGH);
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

        return $destinationFile;
    }
}
