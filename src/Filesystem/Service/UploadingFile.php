<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Service;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Prism\Library\Prism\Utilities\StringHelper;
use Prism\Library\Prism\Validator\Validation;
use RuntimeException;

/**
 * This class provides functionality for uploading a file and
 * validating the process.
 *
 * @package      Prism
 * @subpackage   Filesystem
 */
class UploadingFile
{
    protected $file;

    protected $errors = [];
    protected $errorInformation = [];

    protected $validations = [];
    protected $destinationFolder;

    /**
     * Initialize the object.
     *
     * <code>
     * // Retrieve file details from uploaded file, sent from upload form.
     * $fileData = Factory::getApplication()->input->files->get('file_upload');
     *
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile($fileData);
     * </code>
     *
     * @param array $file
     *
     * @throws \UnexpectedValueException
     */
    public function __construct(array $file)
    {
        $this->file = $file;
//        $this->file = Path::clean($file);
    }


    /**
     * Add an object that validates uploaded file.
     *
     * <code>
     * $validation = new Prism\Library\Prism\Filesystem\Validation\Image();
     *
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     * $uploadService->addValidation($validation);
     * </code>
     *
     * @param Validation $validation An object that validate a file.
     *
     * @return UploadingFile
     */
    public function addValidation(Validation $validation): UploadingFile
    {
        $this->validations[] = $validation;

        return $this;
    }

    /**
     * Process validations.
     *
     * <code>
     * $validation = new Prism\Library\Prism\Filesystem\Validation\Image();
     *
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     * $uploadService->addValidation($validation);
     *
     * $uploadService->validate();
     * </code>
     */
    public function validate(): void
    {
        /** @var $validation Validation */
        foreach ($this->validations as $validation) {
            if ($validation->fails()) {
                $this->errors[] = $validation->getMessage();
                $this->errorInformation[] = $validation->getAdditionalInformation();
            }
        }
    }

    /**
     * Validate the file.
     *
     * <code>
     * $validation = new Prism\Library\Prism\Filesystem\Validation\Image();
     *
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     * $uploadService->addValidation($validation);
     * $uploadService->validate();
     *
     * if ($uploadService->isValid()) {
     * ...
     * )
     * </code>
     */
    public function isValid(): bool
    {
        if ($this->hasErrors()) {
            return false;
        }

        return true;
    }

    /**
     * Check for errors.
     *
     * <code>
     * $validation = new Prism\Library\Prism\Filesystem\Validation\Image();
     *
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     * $uploadService->addValidation($validation);
     * $uploadService->validate();
     *
     * if ($uploadService->hasErrors()) {
     * ...
     * )
     * </code>
     */
    public function hasErrors(): bool
    {
        return $this->errors ? true : false;
    }

    /**
     * Return all error messages.
     *
     * <code>
     * $validation = new Prism\Library\Prism\Filesystem\Validation\Image();
     *
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     * $uploadService->addValidation($validation);
     * $uploadService->validate();
     *
     * if ($file->hasErrors()) {
     *     $errors = $file->getErrors();
     * )
     * </code>
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Return the latest error message.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\File\Validator\Image();
     *
     * $file = new Prism\Library\Prism\File\File($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getError();
     * )
     * </code>
     *
     * @return string
     */
    public function getLatestError(): string
    {
        return end($this->errors);
    }

    /**
     * Return the latest record from the additional information about error.
     *
     * <code>
     * $filePath  = "/tmp/myfile.jpg";
     *
     * $validator = new Prism\Library\Prism\File\Validator\Image();
     *
     * $file = new Prism\Library\Prism\File\File($filePath);
     * $file->addValidator($validator);
     *
     * if (!$file->isValid()) {
     *     echo $file->getErrorAdditionalInformation();
     * )
     * </code>
     *
     * @return string
     */
    public function getLatestErrorInformation(): string
    {
        return end($this->errorInformation);
    }

    /**
     * Set the destination where the file will be saved.
     *
     * <code>
     * $temporaryFolder = Path::clean(Factory::getApplication()->get('tmp_path'));
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     *
     * $uploadService->setDestinationFolder($temporaryFolder);
     * </code>
     *
     * @param string $folder
     * @return void
     *
     */
    public function setDestinationFolder(string $folder): void
    {
        $this->destinationFolder = Path::clean($folder);
    }

    /**
     * Move the file from the temporary server folder to your destination folder.
     * The method will generate file name, if you do not provide one.
     *
     * <code>
     * $options = new Registry();
     * $options->set('filename', 'my_new_file');
     *
     * $temporaryFolder = Path::clean(Factory::getApplication()->get('tmp_path'));
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     *
     * $uploadService->setDestinationFolder($temporaryFolder);
     *
     * $file->upload($options);
     * </code>
     *
     * @param Registry $options
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function upload(Registry $options = null): string
    {
        $options = $options ?: new Registry();

        $sourceFile = ArrayHelper::getValue($this->file, 'tmp_name', '', 'string');

        $filename = File::makeSafe(ArrayHelper::getValue($this->file, 'name', '', 'string'));
        $filename = strtolower($filename);

        $destinationFile = '';

        if ($sourceFile !== '' && $filename !== '') {
            // Generate new file name.
            if (!$options->get('filename')) {
                $generatedName = StringHelper::generateRandomString($options->get('filename_length', 16)) . '.' . File::getExt($filename);
            } else {
                $generatedName = File::makeSafe($options->get('filename') . '.' . File::getExt($filename));
            }

            // Prepare destination path and folder.
            $destinationFile = Path::clean($this->destinationFolder . '/' . $generatedName, '/');

            // Copy the file to the destination folder.
            if (!File::upload($sourceFile, $destinationFile)) {
                throw new RuntimeException(Text::sprintf('LIB_PRISM_ERROR_CANNOT_COPY_FILE_S', $filename . ' (' . $sourceFile . ')', $destinationFile));
            }
        }

        return $destinationFile;
    }
}
