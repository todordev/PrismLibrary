<?php
/**
 * @package      Prism
 * @subpackage   Files\Uploaders
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File\Uploader;

use Prism\File\UploaderInterface;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for uploading files and
 * validates the process.
 *
 * @package      Prism
 * @subpackage   Files\Uploaders
 *
 * @deprecated since v1.10
 */
class Local implements UploaderInterface
{
    protected $file = '';
    protected $destination = '';

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\File\Uploader\Local($myFile);
     * </code>
     *
     * @param  string $file A path to the file.
     */
    public function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * Set a path to a file.
     *
     * <code>
     * $myFile   = "/tmp/myfile.txt";
     *
     * $file = new Prism\File\Uploader\Local($myFile);
     * $file->setFile($myFile);
     * </code>
     *
     * @param  string $file A path to the file.
     *
     * @return self
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Set the destination where the file will be saved.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     * $destination   = "/images/mypic.jpg";
     *
     * $file = new Prism\File\Uploader\Local($myFile);
     * $file->setDestination($destination);
     * </code>
     *
     * @param  string $destination A location where the file is going to be saved.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     *
     * @return self
     */
    public function setDestination($destination)
    {
        $destination = \JPath::clean($destination);
        if (!$destination) {
            throw new \InvalidArgumentException(\JText::_('LIB_PRISM_ERROR_INVALID_DESTINATION'));
        }

        $folder = dirname($destination);
        if (!\JFolder::exists($folder)) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FOLDER_DOES_NOT_EXIST', $folder));
        }

        $this->destination = $destination;

        return $this;
    }

    /**
     * Return the location where the file has been uploaded ( path + filename ).
     *
     * <code>
     * $file->upload();
     *
     * $destination = $file->getDestination();
     * </code>
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set the destination where the file will be saved.
     *
     * <code>
     * $myFile   = "/tmp/myfile.jpg";
     * $destination   = "/images/mypic.jpg";
     *
     * $file = new Prism\File\Uploader\Local($myFile);
     * $file->setDestination($destination);
     * $file->upload();
     * </code>
     *
     * @throws \RuntimeException
     */
    public function upload()
    {
        if (!\JFile::upload($this->file, $this->destination)) {
            throw new \RuntimeException(\JText::_('LIB_PRISM_ERROR_FILE_CANT_BE_UPLOADED'));
        }
    }
}
