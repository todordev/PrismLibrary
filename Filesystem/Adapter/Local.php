<?php
/**
 * @package      Prism
 * @subpackage   Filesystem\Adapters
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Filesystem\Adapter;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Prism\Utilities\StringHelper;

/**
 * This class provides functionality for uploading files and
 * delete files in local filesystem.
 *
 * @package      Prism
 * @subpackage   Filesystem\Adapters
 */
class Local
{
    protected $rootFolder = '';

    /**
     * Initialize the object.
     *
     * <code>
     * $rootFolder   = "/tmp";
     *
     * $localFilesystem = new Prism\Filesystem\Adapters\Local($rootFolder);
     * </code>
     *
     * @param  string $rootFolder A path to the folder where the file will be stored.
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($rootFolder)
    {
        $this->rootFolder = \JPath::clean($rootFolder);
    }

    /**
     * Set the destination where the file will be saved.
     *
     * <code>
     * $rootFolder   = "/tmp";
     *
     * $localFilesystem = new Prism\Filesystem\Adapters\Local($rootFolder);
     * $file->upload($fileData, $options);
     * </code>
     *
     * @param array $fileData
     * @param Registry $options
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return string
     */
    public function upload(array $fileData, Registry $options = null)
    {
        $options         = $options ?: new Registry;

        $sourceFile      = ArrayHelper::getValue($fileData, 'tmp_name', '', 'string');
        $filename        = \JFile::makeSafe(ArrayHelper::getValue($fileData, 'name', '', 'string'));
        $filename        = strtolower($filename);
        $destinationFile = '';

        if ($sourceFile !== '' and $filename !== '') {
            // Generate a new file name.
            if (!$options->get('filename')) {
                $generatedName = StringHelper::generateRandomString($options->get('filename_length', 16)) . '.' . \JFile::getExt($filename);
            } else {
                $generatedName = $options->get('filename'). '.' . \JFile::getExt($filename);
            }

            // Prepare destination path and folder.
            $destinationFile = \JPath::clean($this->rootFolder . '/' . $generatedName, '/');

            // Copy the file to a folder.
            if (!\JFile::upload($sourceFile, $destinationFile)) {
                throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_CANNOT_COPY_FILE_S', $filename . ' (' . $sourceFile . ')', $destinationFile));
            }
        }

        return $destinationFile;
    }
}
