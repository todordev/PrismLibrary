<?php
/**
 * @package      Prism
 * @subpackage   Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Filesystem\Service;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for detecting file type by MIME type.
 *
 * @package      Prism
 * @subpackage   Files
 */
class DetectingFileType
{
    protected $mime;

    protected $types = [];
    protected $icons = [];

    /**
     * Initialize the object.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $fileType = new Prism\Library\Filesystem\Service\DetectingFileType($mimeType);
     * </code>
     *
     * @param  string $mime MIME type
     */
    public function __construct($mime)
    {
        $this->mime = $mime;

        $this->types = [
            'powerpoint' => ['application/vnd.ms-powerpoint', 'application/powerpoint', 'application/mspowerpoint'],
            'image'      => ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/webp'],
            'video'      => ['video/mp4'],
            'word'       => ['text/rtf', 'application/msword'],
            'excel'      => ['application/excel'],
            'pdf'        => ['application/pdf']
        ];

        $this->icons = [
            'powerpoint' => 'fa-file-powerpoint-o',
            'image'      => 'fa-file-image-o',
            'video'      => 'fa-file-video-o',
            'excel'      => 'fa-file-excel-o',
            'word'       => 'fa-file-word-o',
            'pdf'        => 'fa-file-pdf-o',
            'text'       => 'fa-file-text-o',
            'file'       => 'fa-file-o'
        ];
    }

    /**
     * Return the type of the file.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $fileType = new Prism\Library\Filesystem\Service\DetectingFileType($mimeType);
     * $type     = $fileType->getType();
     * </code>
     *
     * @return string
     */
    public function getType()
    {
        $fileType = '';

        foreach ($this->types as $type => $mimeTypes) {
            if (in_array($this->mime, $mimeTypes, true)) {
                $fileType = $type;
                break;
            }
        }

        return $fileType;
    }

    /**
     * Return the CSS style class of the file type.
     *
     * <code>
     * $mimeType = 'image/jpeg';
     *
     * $fileType  = new Prism\Library\Filesystem\Service\DetectingFileType($mimeType);
     * $iconClass = $fileType->getIcon();
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
     * $fileType     = new Prism\Library\Filesystem\Service\DetectingFileType($mimeType);
     * $oldIconClass = $fileType->setIcon($key, $iconClass);
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
     * $fileType     = new Prism\Library\Filesystem\Service\DetectingFileType($mimeType);
     * $oldIconClass = $fileType->setTypes($key, $types);
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
     * Add file type to the other ones.
     *
     * <code>
     * $key   = 'image';
     * $type  = 'image/jpeg';
     *
     * $fileType = new Prism\Library\Filesystem\Service\DetectingFileType($mimeType);
     * $fileType->addType($key, $type);
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
