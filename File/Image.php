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
use Joomla\Utilities\ArrayHelper;
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
        $this->file = \JPath::clean($file);
    }

    /**
     * Resize the temporary file to new one.
     *
     * <code>
     * $image = $this->input->files->get('media', array(), 'array');
     * $rootFolder = "/root/joomla/tmp";
     *
     * $resizeOptions = array(
     *    'width'  => $options['thumb_width'],
     *    'height' => $options['thumb_height'],
     *    'scale'  => $options['thumb_scale']
     * );
     *
     * $file = new Prism\File\Image($image, $rootFolder);
     *
     * $file->upload();
     * $fileData = $file->resize($resize);
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

        $filename = \JFile::makeSafe(basename($this->file));
        $ext      = \JFile::getExt($filename);

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
        $quality    = (int)$options->get('quality', 80);
        $createNew  = (bool)$options->get('create_new', true);

        if ($createNew) {
            $image = $image->resize($width, $height, $createNew, $scale);
        } else {
            $image->resize($width, $height, $createNew, $scale);
        }

        // Generate new name.
        $generatedName = StringHelper::generateRandomString($options->get('filename_length', 16)) .'.'.$ext;

        $prefix  = $options->get('prefix');
        if (is_string($prefix) and $prefix !== '') {
            $generatedName = $prefix.$generatedName;
        }
        $destinationFile = \JPath::clean($destinationFolder .'/'. $generatedName);

        switch ($ext) {
            case 'png':
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
