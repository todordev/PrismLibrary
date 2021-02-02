<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Storage
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Storage;

use Joomla\CMS\Language\Text;
use Prism\Library\Prism\Contract\Filesystem\RemoveRequest;
use Prism\Library\Prism\Contract\Filesystem\Storage;
use Prism\Library\Prism\Contract\Filesystem\StoreResponse;
use Prism\Library\Prism\Filesystem\Dto\LocalStoreRequest;
use Prism\Library\Prism\Filesystem\Dto\MoveRequest;
use Prism\Library\Prism\Filesystem\Dto\UploadResponse;
use Prism\Library\Prism\Filesystem\Path;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use Joomla\CMS\Filesystem\Path as JoomlaPath;

/**
 * This class provides functionality for uploading files and
 * delete files in local filesystem.
 *
 * @package Prism\Library\Prism\Filesystem\Storage
 */
class LocalStorage implements Storage
{
    protected Path $storageFolder;

    /**
     * @param Path $storageFolder
     */
    public function __construct(Path $storageFolder)
    {
        $this->storageFolder = $storageFolder;
    }

    /**
     * Set the destination where the file will be saved.
     *
     * @param LocalStoreRequest $request
     * @return StoreResponse
     * @throws \ErrorException
     */
    public function store(LocalStoreRequest $request): StoreResponse
    {
        $destination = JoomlaPath::clean($this->storageFolder->getStoragePath() . '/' . $request->getDestinationFile());

        if (
            !JoomlaFile::upload(
                $request->getSourceFile(),
                $destination,
                $request->shouldUseStreams(),
                $request->isAllowedUnsafe(),
                $request->getSafeOptions()->toArray()
            )
        ) {
            throw
            new \ErrorException(
                Text::sprintf(
                    'LIB_PRISM_ERROR_CANNOT_COPY_FILE_S',
                    $request->getSourceFile(),
                    $destination
                )
            );
        }

        return new UploadResponse(
            basename($destination),
            new Path(
                pathinfo($destination, PATHINFO_DIRNAME),
                pathinfo($request->getDestinationFile(), PATHINFO_DIRNAME)
            )
        );
    }

    public function remove(RemoveRequest $request): void
    {
        $source = JoomlaPath::clean(
            $this->storageFolder->getStoragePath() . '/' . $request->getRelativePath() . '/' . $request->getFilename()
        );

        if (JoomlaFile::exists($source)) {
            JoomlaFile::delete($source);
        }
    }

    public function move(MoveRequest $request): void
    {
        $source = JoomlaPath::clean(
            $this->storageFolder->getStoragePath() . '/' . $request->getRelativePath() . '/' . $request->getFilename()
        );

        $target = JoomlaPath::clean(
            $this->storageFolder->getStoragePath() . '/' . $request->getNewRelativePath() . '/' . $request->getFilename()
        );

        if (JoomlaFile::exists($source)) {
            JoomlaFile::move($source, $target);
        }
    }
}
