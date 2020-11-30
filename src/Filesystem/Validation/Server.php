<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Filesystem\Validation;

use Joomla\CMS\Language\Text;
use Prism\Library\Prism\Validator\Validation;

/**
 * This class provides functionality for validating a file,
 * using data from server result.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Server extends Validation
{
    /**
     * An error code that comes from the server.
     *
     * @var int
     */
    protected $errorCode;

    /**
     * An array with error codes that should be ignored.
     * Those errors will not be treat as en error.
     *
     * @var array
     */
    protected $ignored = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $errorCode = 404;
     *
     * $validator = new Prism\Library\Prism\Filesystem\Validator\Server($errorCode);
     * </code>
     *
     * @param int $errorCode Error code that comes from server.
     * @param array $ignored Ignored server errors.
     */
    public function __construct(int $errorCode = 0, array $ignored = [])
    {
        $this->errorCode = $errorCode;
        $this->ignored = $ignored;
    }

    /**
     * Set an error code that received from the server.
     *
     * <code>
     * $errorCode = 404;
     *
     * $validator = new Prism\Library\Prism\Filesystem\Validator\Server($errorCode);
     * $validator->setErrorCode($maxFileSize);
     * </code>
     *
     * @param int $errorCode An error code.
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * Validate the size of the file.
     *
     * <code>
     * $errorCode = 404;
     * $ignored   = array(UPLOAD_ERR_NO_FILE, UPLOAD_ERR_EXTENSION);
     *
     * $validator = new Prism\Library\Prism\Filesystem\Validator\Server($errorCode);
     *
     * if (!$validator->isValid($ignored)) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->validate();
    }

    public function fails(): bool
    {
        return !$this->validate();
    }

    private function validate(): bool
    {
        $result = true;

        // If the error code have to be ignored, this should be treat as not error.
        if (!$this->errorCode || in_array($this->errorCode, $this->ignored, true)) {
            return $result;
        }

        // Check for server errors
        switch ($this->errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_INI_SIZE');
                $result = false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_FORM_SIZE');
                $result = false;
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_PARTIAL');
                $result = false;
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_NO_FILE');
                $result = false;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_NO_TMP_DIR');
                $result = false;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_CANT_WRITE');
                $result = false;
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_EXTENSION');
                $result = false;
                break;
            default:
                $this->message = Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_UNKNOWN');
                $result = false;
                break;
        }

        return $result;
    }
}
