<?php
/**
 * @package      Prism\Library\Prism\Filesystem\Dto
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Dto;

/**
 * Request to the service that will upload a file.
 *
 * @package Prism\Library\Prism\Filesystem\Dto
 */
final class LocalSafeFileOptions
{
    /**
     *  Null byte in file name
     */
    private bool $nullByte;
    private bool $phpTagInContent;
    private bool $shortPhpTagInContent;
    private bool $pharStubInContent;
    private bool $forbiddenExtensionsInContent;
    private ?array $forbiddenExtensions = null;
    private ?array $shortTagExtensions = null;

    /**
     * Which file extensions to scan for .php in the content
     * @var ?array
     */
    private ?array $phpExtContentExtensions = null;

    public function __construct(
        bool $nullByte = true,
        bool $phpTagInContent = true,
        bool $shortPhpTagInContent = true,
        bool $pharStubInContent = true,
        bool $forbiddenExtensionsInContent = true,
    ) {

        $this->nullByte = $nullByte;
        $this->phpTagInContent = $phpTagInContent;
        $this->shortPhpTagInContent = $shortPhpTagInContent;
        $this->pharStubInContent = $pharStubInContent;
        $this->forbiddenExtensionsInContent = $forbiddenExtensionsInContent;
    }

    /**
     * Check for null byte in file name.
     * @return bool
     */
    public function isNullByte(): bool
    {
        return $this->nullByte;
    }

    /**
     * Check for allowed `<?php` tag in content
     * @return bool
     */
    public function isPhpTagInContent(): bool
    {
        return $this->phpTagInContent;
    }

    /**
     * Check for short php tag allowed.
     * @return bool
     */
    public function isShortPhpTagInContent(): bool
    {
        return $this->shortPhpTagInContent;
    }

    /**
     * Do not allow the `__HALT_COMPILER()` phar stub in content
     * @return bool
     */
    public function isPharStubInContent(): bool
    {
        return $this->pharStubInContent;
    }

    /**
     * Return forbidden extensions anywhere in the content.
     * @return ?array
     */
    public function getForbiddenExtensions(): ?array
    {
        return $this->forbiddenExtensions;
    }

    /**
     * Set forbidden extensions anywhere in the content.
     * @param array $forbiddenExtensions
     * @return LocalSafeFileOptions
     */
    public function setForbiddenExtensions(array $forbiddenExtensions): LocalSafeFileOptions
    {
        $this->forbiddenExtensions = $forbiddenExtensions;
        return $this;
    }

    /**
     * Return which file extensions to scan for short tags.
     * @return ?array
     */
    public function getShortTagExtensions(): ?array
    {
        return $this->shortTagExtensions;
    }

    /**
     * Set file extensions to scan for short tags.
     * @param array $shortTagExtensions
     * @return LocalSafeFileOptions
     */
    public function setShortTagExtensions(array $shortTagExtensions): LocalSafeFileOptions
    {
        $this->shortTagExtensions = $shortTagExtensions;
        return $this;
    }

    /**
     * Forbidden extensions anywhere in the content
     * @return bool
     */
    public function isForbiddenExtensionsInContent(): bool
    {
        return $this->forbiddenExtensionsInContent;
    }

    /**
     * Which file extensions to scan for .php in the content.
     *
     * @return array|null
     */
    public function getPhpExtContentExtensions(): ?array
    {
        return $this->phpExtContentExtensions;
    }

    /**
     * Set which file extensions to scan for .php in the content.
     *
     * @param array $phpExtContentExtensions
     * @return LocalSafeFileOptions
     */
    public function setPhpExtContentExtensions(array $phpExtContentExtensions): LocalSafeFileOptions
    {
        $this->phpExtContentExtensions = $phpExtContentExtensions;
        return $this;
    }

    /**
     * Returns an array with options used in InputFilter::isSafeFile
     * @return array
     * @see https://api.joomla.org/cms-3/classes/Joomla.CMS.Filter.InputFilter.html
     */
    public function toArray(): array
    {
        $options = [
            'null_byte' => $this->nullByte,
            'php_tag_in_content' => $this->nullByte,
            'shorttag_in_content' => $this->nullByte,
            'phar_stub_in_content' => $this->nullByte,
            'fobidden_ext_in_content' => $this->nullByte
        ];

        if ($this->getShortTagExtensions() !== null) {
            $options['shorttag_extensions'] = $this->getShortTagExtensions();
        }

        if ($this->getForbiddenExtensions() !== null) {
            $options['forbidden_extensions'] = $this->getForbiddenExtensions();
        }

        if ($this->getPhpExtContentExtensions() !== null) {
            $options['php_ext_content_extensions'] = $this->getPhpExtContentExtensions();
        }

        return $options;
    }
}
