<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Filesystem\Validation;

use Joomla\CMS\Language\Text;
use Prism\Library\Validator\Validation;

/**
 * This class provides functionality for validating file size.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Size extends Validation
{
    /**
     * A maximum file size allowed for uploading.
     *
     * @var integer
     */
    protected $maxFileSize = 0;

    /**
     * The size of the file which will be validated.
     *
     * @var integer
     */
    protected $fileSize = 0;

    /**
     * Initialize the object.
     *
     * <code>
     * $fileSize  = 100000;
     * $maxFileSize  = 600000;
     *
     * $validator = new Prism\Library\Filesystem\Validator\Size($fileSize, $maxFileSize);
     * </code>
     *
     * @param integer $fileSize File size in bytes.
     * @param integer $maxFileSize Maximum allowed file size in bytes.
     */
    public function __construct($fileSize = 0, $maxFileSize = 0)
    {
        $this->fileSize = (int)$fileSize;
        $this->maxFileSize = (int)$maxFileSize;
    }

    /**
     * Set a maximum allowed file size.
     *
     * <code>
     * $fileSize     = 100000;
     * $maxFileSize  = 600000;
     *
     * $validator = new Prism\Library\Filesystem\Validator\Size($fileSize);
     * $validator->setMaxFileSize($maxFileSize);
     * </code>
     *
     * @param integer $maxFileSize File size in bytes ( 1024 * 1024 ).
     */
    public function setMaxFileSize($maxFileSize)
    {
        $this->maxFileSize = (int)$maxFileSize;
    }

    /**
     * Validate the size of the file.
     *
     * <code>
     * $fileSize  = 100000;
     * $maxFileSize  = 600000;
     *
     * $validator = new Prism\Library\Filesystem\Validator\Size($fileSize, $maxFileSize);
     * if ($validator->passes()) {
     *   //.....
     * }
     * </code>
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->validate();
    }

    /**
     * Validate the size of the file.
     *
     * <code>
     * $fileSize  = 100000;
     * $maxFileSize  = 600000;
     *
     * $validator = new Prism\Library\Filesystem\Validator\Size($fileSize, $maxFileSize);
     * if ($validator->fails()) {
     *   echo $this->getMessage();
     * }
     * </code>
     *
     * @return bool
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    /**
     * Validate the size of the file.
     *
     * @return bool
     */
    private function validate(): bool
    {
        $KB = 1024 ** 2;

        // Verify file size
        $uploadMaxFileSize = (int)ini_get('upload_max_filesize');
        $uploadMaxFileSize *= $KB;

        $postMaxSize = (int)ini_get('post_max_size');
        $postMaxSize *= $KB;

        $memoryLimit = (int)ini_get('memory_limit');
        if ($memoryLimit !== -1) {
            $memoryLimit *= $KB;
        }

        if (
            ($this->fileSize > $uploadMaxFileSize) ||
            ($this->fileSize > $postMaxSize) ||
            (($this->fileSize > $memoryLimit) && ($memoryLimit !== -1))
        ) {
            $this->additionalInformation = Text::sprintf(
                'LIB_PRISM_ERROR_FILE_INFORMATION',
                round($this->fileSize / $KB),
                round($uploadMaxFileSize / $KB),
                round($postMaxSize / $KB),
                round($memoryLimit / $KB)
            );
            $this->message = Text::_('LIB_PRISM_ERROR_WARNFILETOOLARGE');

            return false;
        }

        // Validate the max file size set by the user.
        if (($this->maxFileSize !== 0) && ($this->fileSize > $this->maxFileSize)) {
            $this->additionalInformation = Text::sprintf(
                'LIB_PRISM_ERROR_FILE_INFORMATION',
                round($this->fileSize / $KB),
                round($this->maxFileSize / $KB)
            );
            $this->message = Text::_('LIB_PRISM_ERROR_WARNFILETOOLARGE');

            return false;
        }

        return true;
    }
}
