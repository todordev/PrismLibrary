<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File\Validator;

use Prism\Validator\Validator;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for validating file size.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Size extends Validator
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
     * $validator = new Prism\File\Validator\Size($fileSize, $maxFileSize);
     * </code>
     *
     * @param integer $fileSize File size in bytes ( 1024 * 1024 ).
     * @param integer $maxFileSize Maximum allowed file size in bytes ( 1024 * 1024 ).
     */
    public function __construct($fileSize = 0, $maxFileSize = 0)
    {
        $this->fileSize    = (int)$fileSize;
        $this->maxFileSize = (int)$maxFileSize;
    }

    /**
     * Set a maximum allowed file size.
     *
     * <code>
     * $fileSize     = 100000;
     * $maxFileSize  = 600000;
     *
     * $validator = new Prism\File\Validator\Size($fileSize);
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
     * $validator = new Prism\File\Validator\Size($fileSize, $maxFileSize);
     * if (!$validator->isValid()) {
     * .....
     * }
     * </code>
     *
     * @return bool
     */
    public function isValid()
    {
        $KB = pow(1024, 2);

        // Verify file size
        $uploadMaxFileSize  = (int)ini_get('upload_max_filesize');
        $uploadMaxFileSize *= $KB;

        $postMaxSize  = (int)ini_get('post_max_size');
        $postMaxSize *= $KB;

        $memoryLimit = (int)ini_get('memory_limit');
        if ($memoryLimit !== -1) {
            $memoryLimit *= $KB;
        }

        if (($this->fileSize > $uploadMaxFileSize) or
            ($this->fileSize > $postMaxSize) or
            (($this->fileSize > $memoryLimit) and ($memoryLimit != -1))
        ) {
            $this->additionalInformation = \JText::sprintf('LIB_PRISM_ERROR_FILE_INFORMATION', round($this->fileSize/$KB, 0), round($uploadMaxFileSize/$KB, 0), round($postMaxSize/$KB, 0), round($memoryLimit/$KB, 0));
            $this->message = \JText::_('LIB_PRISM_ERROR_WARNFILETOOLARGE');
            return false;
        }

        // Validate the max file size set by the user.
        if (($this->maxFileSize !== 0) and ($this->fileSize > $this->maxFileSize)) {
            $this->additionalInformation = \JText::sprintf('LIB_PRISM_ERROR_FILE_INFORMATION', round($this->fileSize / $KB, 0), round($this->maxFileSize / $KB, 0));
            $this->message = \JText::_('LIB_PRISM_ERROR_WARNFILETOOLARGE');
            
            return false;
        }

        return true;
    }
}
