<?php
/**
 * @package      Prism
 * @subpackage   Files\Removers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File\Remover;

use Prism\File\RemoverInterface;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for removing file.
 *
 * @package      Prism
 * @subpackage   Files\Removers
 *
 * @deprecated since v1.10
 */
class Local implements RemoverInterface
{
    protected $file = '';

    /**
     * Initialize the object.
     *
     * <code>
     * $myFile   = '/tmp/myfile.jpg';
     *
     * $file = new Prism\File\Remover\Local($myFile);
     * </code>
     *
     * @param  string $file A file location and name.
     */
    public function __construct($file = '')
    {
        if ($file !== '') {
            $this->file = \JPath::clean($file);
        }
    }

    /**
     * Set file location.
     *
     * <code>
     * $myFile   = '/tmp/myfile.jpg';
     *
     * $file = new Prism\File\Remover\Local();
     * $file->setFile($myFile);
     * </code>
     *
     * @param  string $file A file location and name.
     *
     * @return self
     */
    public function setFile($file)
    {
        $this->file = \JPath::clean($file);

        return $this;
    }

    /**
     * Get file location.
     *
     * <code>
     * $myFile   = '/tmp/myfile.jpg';
     *
     * $file = new Prism\File\Remover\Local();
     * $file->setFile($myFile);
     * </code>
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Remove a file from the file system.
     *
     * <code>
     * $myFile   = '/tmp/myfile.jpg';
     *
     * $file = new Prism\File\Remover\Local($myFile);
     * $file->remove();
     * </code>
     * 
     * @throws \RuntimeException
     */
    public function remove()
    {
        if (!$this->file or !\JFile::exists($this->file)) {
            throw new \RuntimeException(\JText::_('LIB_PRISM_ERROR_INVALID_FILE'));
        }

        if (!\JFile::delete($this->file)) {
            throw new \RuntimeException(\JText::_('LIB_PRISM_ERROR_FILE_CANT_BE_REMOVED'));
        }

        $this->file = '';
    }
}
