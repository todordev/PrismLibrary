<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Storage;

use Joomla\CMS\Filesystem\Path as JoomlaPath;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use Prism\Library\Prism\Contract\Filesystem\RemoveRequest;
use Prism\Library\Prism\Contract\Filesystem\StoreRequest;
use Prism\Library\Prism\Contract\Filesystem\StoreResponse;
use Prism\Library\Prism\Filesystem\Dto\LocalSafeFileOptions;
use Prism\Library\Prism\Filesystem\Dto\LocalStoreRequest;
use Prism\Library\Prism\Contract\Filesystem\Storage;
use Prism\Library\Prism\Utility\StringHelper;
use Prism\Library\Prism\Validation\ErrorMessage;
use Prism\Library\Prism\Validation\Validation;

/**
 * This class provides functionality for uploading a file and
 * validating the process.
 *
 * @package      Prism
 * @subpackage   Filesystem
 */
class StorageRepository
{
    protected Storage $storage;
    protected array $errors = [];
    protected array $validations = [];

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param StoreRequest $request
     *
     * @return StoreResponse
     * @throws \ErrorException
     */
    public function store(StoreRequest $request): StoreResponse
    {
        $fileData = $request->getFileData();

        $sourceFile = $fileData->getFilePath();
        $sourceFileName = $fileData->getName();

        // Validate the file upload.
        $this->validate();
        if ($this->hasErrors()) {
            throw new \ErrorException($this->getLatestError()->getMessage());
        }

        $sourceFileName = JoomlaFile::makeSafe($sourceFileName);
        $sourceFileName = strtolower($sourceFileName);

        $file = null;

        if (!$sourceFile || !$sourceFileName) {
            throw new \ErrorException('The file cannot be uploaded.');
        }

        // Generate new file name.
        if (!$request->getFilename()) {
            $generatedName = StringHelper::generateRandomString($request->getFilenameLength()) . '.' . JoomlaFile::getExt($sourceFileName);
        } else {
            $generatedName = JoomlaFile::makeSafe($request->getFilename() . '.' . JoomlaFile::getExt($sourceFileName));
        }

        $destinationFile = JoomlaPath::clean($request->getDestinationPath()->getRelativePath() . '/' . $generatedName);

        // @todo Find a way to improve the security, removing allowUnsafe.
        $allowUnsafe = true;
        $localStorageRequest = new LocalStoreRequest(
            $sourceFile,
            $destinationFile,
            new LocalSafeFileOptions(),
            $allowUnsafe
        );

        return $this->storage->store($localStorageRequest);
    }

    public function remove(RemoveRequest $request): void
    {
        $this->storage->remove($request);
    }

    /**
     * Add an object that validates uploaded file.
     * <code>
     * $validation = new Prism\Library\Prism\Filesystem\Validation\Image();
     * $uploadService = new Prism\Library\Prism\Filesystem\Service\UploadFile();
     * $uploadService->addValidation($validation);
     * </code>
     *
     * @param Validation $validation An object that validate a file.
     * @return StorageRepository
     */
    public function addValidation(Validation $validation): StorageRepository
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
                $this->errors[] = $validation->getErrorMessage();
            }
        }
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
     * @return ErrorMessage
     */
    public function getLatestError(): ErrorMessage
    {
        return end($this->errors);
    }
}
