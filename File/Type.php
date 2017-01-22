<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for uploading files and
 * validates the process.
 *
 * @package      Prism
 * @subpackage   Files
 */
class Type
{
    protected $mime;

    protected $types = array();
    protected $icons = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $filetype = new Prism\File\Type($mimeType);
     * </code>
     *
     * @param  string $mime MIME type
     */
    public function __construct($mime)
    {
        $this->mime = $mime;

        $this->types = array(
            'powerpoint' => array('application/vnd.ms-powerpoint', 'application/powerpoint', 'application/mspowerpoint'),
            'image'      => array('image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/x-windows-bmp'),
            'video'      => array('video/mp4'),
            'word'       => array('text/rtf', 'application/msword'),
            'excel'      => array('application/excel'),
            'pdf'        => array('application/pdf')
        );

        $this->icons = array(
            'powerpoint' => 'fa-file-powerpoint-o',
            'image'      => 'fa-file-image-o',
            'video'      => 'fa-file-video-o',
            'excel'      => 'fa-file-excel-o',
            'word'       => 'fa-file-word-o',
            'pdf'        => 'fa-file-pdf-o',
            'text'       => 'fa-file-text-o',
            'file'       => 'fa-file-o'
        );
    }

    /**
     * Check the MIME type of the file belongs to image types.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $filetype = new Prism\File\Type($mimeType);
     *
     * if ($filetype->isImage()) {
     * // ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isImage()
    {
        return in_array($this->mime, $this->types['image'], true);
    }

    /**
     * Check the MIME type of the file belongs to video types.
     *
     * <code>
     * $mimeType = 'video/mp4';
     *
     * $filetype = new Prism\File\Type($mimeType);
     *
     * if ($filetype->isVideo()) {
     * // ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isVideo()
    {
        return in_array($this->mime, $this->types['video'], true);
    }

    /**
     * Return the type of the file.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $filetype = new Prism\File\Type($mimeType);
     * $type     = $filetype->getType();
     * </code>
     *
     * @return string
     */
    public function getType()
    {
        $filetype = '';

        foreach ($this->types as $type => $mimeTypes) {
            if (in_array($this->mime, $mimeTypes, true)) {
                $filetype = $type;
                break;
            }
        }

        return $filetype;
    }

    /**
     * Return the CSS style class of the file type.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $filetype  = new Prism\File\Type($mimeType);
     * $iconClass = $filetype->getIcon();
     * </code>
     *
     * @return string
     */
    public function getIcon()
    {
        $icon = '';

        $type = $this->getType();
        if (array_key_exists($type, $this->icons)) {
            $icon = $this->icons[$type];
        }

        return $icon;
    }

    /**
     * Set an icon CSS style class.
     *
     * <code>
     * $key   = 'image';
     * $iconClass = 'file-image-o';
     *
     * $filetype     = new Prism\File\Type($mimeType);
     * $oldIconClass = $filetype->setIcon($key, $iconClass);
     * </code>
     *
     * @param string $key
     * @param string $value
     *
     * @return string Return old icon style.
     */
    public function setIcon($key, $value)
    {
        $oldIcon = '';

        if (array_key_exists($key, $this->icons)) {
            $oldIcon = $this->icons[$key];
        }

        $this->icons[$key] = $value;

        return $oldIcon;
    }

    /**
     * Set file types.
     *
     * <code>
     * $key   = 'pdf';
     * $types = array('application/pdf');
     *
     * $filetype     = new Prism\File\Type($mimeType);
     * $oldIconClass = $filetype->setTypes($key, $types);
     * </code>
     *
     * @param string $key
     * @param array $types
     *
     * @return array Return old file types.
     */
    public function setTypes($key, array $types)
    {
        $oldTypes = array();

        if (array_key_exists($key, $this->types)) {
            $oldTypes = $this->types[$key];
        }

        $this->types[$key] = $types;

        return $oldTypes;
    }

    /**
     * Set file type to the other ones.
     *
     * <code>
     * $key   = 'image';
     * $type  = 'image/jpeg';
     *
     * $filetype     = new Prism\File\Type($mimeType);
     * $filetype->addType($key, $type);
     * </code>
     *
     * @param string $key
     * @param string $value
     */
    public function addType($key, $value)
    {
        $this->types[$key] = $value;
        $this->types = array_unique($this->types[$key]);
    }
}
