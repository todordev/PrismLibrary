<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File;

use Prism\Validator\Validator;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for uploading files and
 * validates the process.
 *
 * @package      Prism
 * @subpackage   Files
 *
 * @deprecated since v1.10
 * @todo rework it to be extended by Prism\File\Image
 */
class File
{
    protected $file;

    protected $errors = array();

    /**
     * @var UploaderInterface
     */
    protected $uploader;

    protected $validators = array();
    protected $removers = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\File\File($myFile);
     * </code>
     *
     * @param  mixed $file
     */
    public function __construct($file = '')
    {
        if ($file !== '') {
            $this->file = \JPath::clean($file);
        }

    }

    /**
     * Set an object that will be used for uploading files.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $uploader = new Prism\File\Uploader\Local();
     *
     * $file = new Prism\File\File($myFile);
     * $file->setUploader($uploader);
     * </code>
     *
     * @param UploaderInterface $uploader
     */
    public function setUploader(UploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Get a file location ( path and file name ).
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\File\File($myFile);
     * $file->upload();
     *
     * $myNewFileLocation = $file->getFile();
     * </code>
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Upload a file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $uploader = new Prism\File\Uploader\Local();
     *
     * $file = new Prism\File\File($myFile);
     * $file->setUploader($uploader);
     *
     * $file->upload();
     * </code>
     *
     * @param  array $file An array that comes from JInput.
     * @param  string $destination Destination where the file is going to be saved.
     */
    public function upload(array $file = array(), $destination = '')
    {
        if (count($file) > 0) {
            $this->uploader->setFile($file);
        }

        if (\JString::strlen($destination) > 0) {
            $this->uploader->setDestination($destination);
        }

        $this->uploader->upload();

        $this->file = \JPath::clean($this->uploader->getDestination());
    }

    /**
     * Add an object that validates the file.
     *
     * <code>
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File();
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
     * Add an object that removes the file.
     *
     * <code>
     * $remover = new Prism\File\Remover\Local();
     *
     * $file = new Prism\File\File();
     * $file->addRemover($remover);
     * </code>
     *
     * @param  RemoverInterface $remover An object that validate a file.
     * @param  bool $reset Reset existing removers.
     *
     * @return self
     */
    public function addRemover(RemoverInterface $remover, $reset = false)
    {
        if ($reset) {
            $this->removers = array();
        }

        if (!$remover->getFile()) {
            $remover->setFile($this->file);
        }

        $this->removers[] = $remover;

        return $this;
    }

    /**
     * Validate the file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File($myFile);
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
     * Remove the file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $remover = new Prism\File\Remover\Local();
     *
     * $file = new Prism\File\File($myFile);
     * $file->addRemover($remover);
     *
     * $file->remove();
     * </code>
     */
    public function remove()
    {
        /** @var  $remover RemoverInterface */
        foreach ($this->removers as $remover) {
            $remover->remove();
        }

        $this->file = '';
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

    /**
     * Return last error message.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\File\Validator\Image();
     *
     * $file = new Prism\File\File($myFile);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getError();
     * )
     * </code>
     *
     * @return string
     */
    public function getError()
    {
        return end($this->errors);
    }
}
