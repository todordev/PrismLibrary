<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Prism\Utilities\StringHelper;
use Prism\Validator\Validator;

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
     * The folder where the files will be stored.
     *
     * @var string
     */
    protected $rootFolder;

    /**
     * The file data that comes from PHP input.
     *
     * @var array
     */
    protected $fileInput = array();

    protected $file;

    protected $errors = array();
    protected $validators = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $image = $this->input->files->get('media', array(), 'array');
     * $rootFolder = "/root/joomla/tmp";
     *
     * $file = new Prism\File\Image($image, $rootFolder);
     * </code>
     *
     * @param  array $fileInput Data from PHP input.
     * @param  string $rootFolder The folder where the file will be stored.
     * @param  Registry $options
     */
    public function __construct(array $fileInput, $rootFolder, Registry $options = null)
    {
        $this->fileInput  = $fileInput;
        $this->rootFolder = $rootFolder;
        $this->options = ($options !== null and ($options instanceof Registry)) ? $options : new Registry;
    }

    /**
     * Add an object that validates the file.
     *
     * <code>
     * $image = $this->input->files->get('media', array(), 'array');
     * $rootFolder = "/root/joomla/tmp";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\Image($image, $rootFolder);
     * $file->addValidator($validator);
     * </code>
     *
     * @param  Validator $validator An object that validate a file.
     * @param  bool $reset Remove existing validators.
     *
     * @return self
     */
    public function addValidator(Validator $validator, $reset = false)
    {
        if ($reset !== false) {
            $this->validators = array();
        }

        $this->validators[] = $validator;

        return $this;
    }

    /**
     * Validate the file.
     *
     * <code>
     * $myFile     = "/tmp/myfile.jpg";
     * $rootFolder = "/root/joomla/tmp";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\Image($myFile, $rootFolder);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     * ...
     * )
     * </code>
     */
    public function isValid()
    {
        /** @var $validator Validator */
        foreach ($this->validators as $validator) {
            if (!$validator->isValid()) {
                $this->errors[] = $validator->getMessage();
                return false;
            }
        }

        return true;
    }

    /**
     * Upload the file in the temporary folder.
     *
     * <code>
     * $image = $this->input->files->get('media', array(), 'array');
     * $rootFolder = "/root/joomla/tmp";
     *
     * $file = new Prism\File\Image($image, $rootFolder);
     *
     * $fileData = $file->upload();
     * </code>
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function upload()
    {
        $sourceFile      = ArrayHelper::getValue($this->fileInput, 'tmp_name');
        $filename        = \JFile::makeSafe(ArrayHelper::getValue($this->fileInput, 'name'));

        // Generate a new file name.
        $generatedName   = StringHelper::generateRandomString($this->options->get('filename_length', 16)) .'.' . \JFile::getExt($filename);

        // Concatenate temporary folder and the new file name.
        $tmpFile         = \JPath::clean($this->rootFolder .'/'. $generatedName);

        // Copy the file to temporary folder.
        if (!\JFile::upload($sourceFile, $tmpFile)) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_CANNOT_COPY_FILE_S', $filename . ' ('.$sourceFile.')', $tmpFile));
        }

        $this->file = $tmpFile;

        // Prepare meta data about the file.
        $fileData = array(
            'filename' => $generatedName,
            'filepath' => $tmpFile,
            'type'     => 'image'
        );
        $fileData = array_merge($fileData, $this->prepareImageProperties($this->file));

        return $fileData;
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
     * @param array $options
     * @param bool $replace Replace the original file with the new one.
     * @param string $prefix Filename prefix.
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function resize(array $options, $replace = false, $prefix = '')
    {
        if (!$this->file) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        // Resize image.
        $image = new \JImage();
        $image->loadFile($this->file);
        if (!$image->isLoaded()) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FILE_NOT_FOUND_S', $this->file));
        }

        // Resize to general size.
        $width  = ArrayHelper::getValue($options, 'width', 640);
        $width  = ($width < 50) ? 50 : $width;
        $height = ArrayHelper::getValue($options, 'height', 480);
        $height = ($height < 50) ? 50 : $height;
        $scale  = ArrayHelper::getValue($options, 'scale', \JImage::SCALE_INSIDE);
        $image->resize($width, $height, false, $scale);

        // Generate new name.
        $generatedName = StringHelper::generateRandomString($this->options->get('filename_length', 16)) .'.png';
        if (is_string($prefix) and $prefix !== '') {
            $generatedName = $prefix.$generatedName;
        }
        $file    = \JPath::clean($this->rootFolder .'/'. $generatedName);

        // Store to file.
        $image->toFile($file, IMAGETYPE_PNG);

        if ($replace) {
            \JFile::delete($this->file);
            $this->file = $file;
        }

        // Prepare meta data about the file.
        $fileData = array(
            'filename' => $generatedName,
            'filepath' => $file,
            'type'     => 'image'
        );
        $fileData = array_merge($fileData, $this->prepareImageProperties($this->file));

        return $fileData;
    }

    protected function prepareImageProperties($file)
    {
        $imageProperties = \JImage::getImageFileProperties($file);

        $properties = array(
            'width'    => $imageProperties->width,
            'height'   => $imageProperties->height,
            'mime'     => $imageProperties->mime,
            'filesize' => $imageProperties->filesize
        );

        return $properties;
    }

    /**
     * Return error message.
     *
     * <code>
     * $image = $this->input->files->get('media', array(), 'array');
     * $rootFolder = "/root/joomla/tmp";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\Image($myFile, $rootFolder);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getError();
     * }
     * </code>
     *
     * @return string
     */
    public function getError()
    {
        return end($this->errors);
    }

    /**
     * Delete the record from database and reset the object.
     *
     * <code>
     * $image = $this->input->files->get('media', array(), 'array');
     * $rootFolder = "/root/joomla/tmp";
     *
     * $file = new Prism\File\Image($image, $rootFolder);
     *
     * $fileData = $file->upload();
     *
     * $file->remove();
     * </code>
     *
     * @return self
     *
     * @throws \RuntimeException
     */
    public function remove()
    {
        if (!$this->file) {
            throw new \RuntimeException(\JText::_('LIB_PRISM_ERROR_INVALID_FILE'));
        }

        // Remove the thumbnail from the filesystem.
        if (\JFile::exists($this->file)) {
            \JFile::delete($this->file);
        }

        $this->file = null;
        $this->errors = array();

        return $this;
    }

    /**
     * Return all error messages.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\Image($myFile);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     $errors = $file->getErrors();
     * )
     * </code>
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
