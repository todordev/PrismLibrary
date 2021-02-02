<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Service
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Service;

/**
 * This class provides functionality for detecting file type by MIME type.
 *
 * @package Prism\Library\Prism\Filesystem\Service
 */
class DetectingFileType
{
    protected array $types = [];

    public function __construct()
    {
        $this->types = [
            'powerpoint' => ['application/vnd.ms-powerpoint', 'application/powerpoint', 'application/mspowerpoint'],
            'image' => ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/webp'],
            'video' => ['video/mp4'],
            'word' => ['text/rtf', 'application/msword'],
            'excel' => ['application/excel'],
            'pdf' => ['application/pdf'],
            'archive' => [
                'application/zip',
                'application/x-7z-compressed',
                'application/x-tar',
                'application/vnd.rar',
                'application/gzip',
                'application/x-bzip',
                'application/x-bzip2'
            ]
        ];
    }

    /**
     * Return a file type.
     * <code>
     * $service = new DetectingFileType(;
     * $fileType = $service->getFileType('image/jpeg'));
     * </code>
     *
     * @param string $mimeType
     * @return string
     */
    public function getFileType(string $mimeType): string
    {
        $fileType = '';

        foreach ($this->types as $type => $mimeTypes) {
            if (in_array($mimeType, $mimeTypes, true)) {
                $fileType = $type;
                break;
            }
        }

        return $fileType;
    }

    /**
     * Add file type to the other ones.
     *
     * <code>
     * $type   = 'image';
     * $mimeTypes  = 'image/jpeg';
     *
     * $service = new DetectingFileType();
     * $service->addType($type, $mimeType);
     * </code>
     *
     * @param string $type
     * @param array $mimeTypes
     * @throws \ErrorException
     */
    public function addType(string $type, array $mimeTypes)
    {
        if (!$type) {
            throw new \ErrorException('You must provide valid type.');
        }

        if (array_key_exists($type, $this->types)) {
            throw new \ErrorException('The type already exists.');
        }

        $this->types[$type] = $mimeTypes;
    }

    /**
     * Add mime type to the other ones.
     *
     * <code>
     * $type   = 'image';
     * $mimeType  = 'image/jpeg';
     *
     * $service = new DetectingFileType();
     * $service->addMimeType($type, $mimeType);
     * </code>
     *
     * @param string $type
     * @param string $mimeType
     * @throws \ErrorException
     */
    public function addMimeType(string $type, string $mimeType)
    {
        if (!$type) {
            throw new \ErrorException('You must provide valid type.');
        }

        if (!array_key_exists($type, $this->types)) {
            $this->types[$type] = [];
        }

        $this->types[$type][] = $mimeType;
        $this->types[$type] = array_unique($this->types[$type]);
    }
}
