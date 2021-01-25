<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

/**
 * Request to local storage that will upload a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class LocalStoreRequest
{
    private string $sourceFile;
    private string $destinationFile;
    private bool $useStreams;
    private bool $allowUnsafe;
    private LocalSafeFileOptions $safeOptions;

    /**
     * LocalStoreRequest constructor.
     *
     * @param string $sourceFile
     * @param string $destinationFile
     * @param LocalSafeFileOptions $safeOptions
     * @param bool $useStreams
     * @param bool $allowUnsafe
     */
    public function __construct(
        string $sourceFile,
        string $destinationFile,
        LocalSafeFileOptions $safeOptions,
        bool $allowUnsafe = false,
        bool $useStreams = false
    ) {
        $this->sourceFile = $sourceFile;
        $this->destinationFile = $destinationFile;
        $this->useStreams = $useStreams;
        $this->allowUnsafe = $allowUnsafe;
        $this->safeOptions = $safeOptions;
    }

    /**
     * @return string
     */
    public function getSourceFile(): string
    {
        return $this->sourceFile;
    }

    /**
     * @return string
     */
    public function getDestinationFile(): string
    {
        return $this->destinationFile;
    }

    /**
     * @return bool
     */
    public function shouldUseStreams(): bool
    {
        return $this->useStreams;
    }

    /**
     * @return LocalStoreRequest
     */
    public function enableUseOfStreams(): LocalStoreRequest
    {
        $this->useStreams = true;
        return $this;
    }

    /**
     * @return LocalStoreRequest
     */
    public function disableUseOfStreams(): LocalStoreRequest
    {
        $this->useStreams = false;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowedUnsafe(): bool
    {
        return $this->allowUnsafe;
    }

    /**
     * @return LocalStoreRequest
     */
    public function allowUnsafe(): LocalStoreRequest
    {
        $this->allowUnsafe = true;
        return $this;
    }

    /**
     * @return LocalStoreRequest
     */
    public function disallowUnsafe(): LocalStoreRequest
    {
        $this->allowUnsafe = false;
        return $this;
    }

    /**
     * @return LocalSafeFileOptions
     */
    public function getSafeOptions(): LocalSafeFileOptions
    {
        return $this->safeOptions;
    }

    /**
     * @param LocalSafeFileOptions $safeOptions
     * @return LocalStoreRequest
     */
    public function setSafeOptions(LocalSafeFileOptions $safeOptions): LocalStoreRequest
    {
        $this->safeOptions = $safeOptions;
        return $this;
    }
}
