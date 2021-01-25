<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation\File;

use Joomla\CMS\Language\Text;
use Prism\Library\Prism\Validation\ErrorMessage;
use Prism\Library\Prism\Validation\Validation;

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
    protected int $errorCode;

    /**
     * An array with error codes that should be ignored.
     * Those errors will not be treat as en error.
     *
     * @var array
     */
    protected array $ignored;

    /**
     * Initialize the object.
     * <code>
     * $errorCode = 404;
     * $ignored   = array(UPLOAD_ERR_NO_FILE, UPLOAD_ERR_EXTENSION);
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Server($errorCode, $ignored);
     * </code>
     *
     * @param int $errorCode Error code that comes from server.
     * @param array $ignored Ignored server errors.
     */
    public function __construct(int $errorCode, array $ignored = [])
    {
        $this->errorCode = $errorCode;
        $this->ignored = $ignored;
    }

    /**
     * Check for pass validation.
     * <code>
     * $errorCode = 404;
     * $ignored   = array(UPLOAD_ERR_NO_FILE, UPLOAD_ERR_EXTENSION);
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Server($errorCode, $ignored);
     * if (!$validator->passes()) {
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

    /**
     * Check for failed validation.
     * <code>
     * $errorCode = 404;
     * $ignored   = array(UPLOAD_ERR_NO_FILE, UPLOAD_ERR_EXTENSION);
     * $validator = new Prism\Library\Prism\Validation\Filesystem\Server($errorCode, $ignored);
     * if (!$validator->fails()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    private function validate(): bool
    {
        // If the error code have to be ignored, this should be treat as not error.
        if (!$this->errorCode || in_array($this->errorCode, $this->ignored, true)) {
            return true;
        }

        // Check for server errors
        $this->errorMessage = match ($this->errorCode) {
            UPLOAD_ERR_INI_SIZE => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_INI_SIZE')),
            UPLOAD_ERR_FORM_SIZE => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_FORM_SIZE')),
            UPLOAD_ERR_PARTIAL => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_PARTIAL')),
            UPLOAD_ERR_NO_FILE => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_NO_FILE')),
            UPLOAD_ERR_NO_TMP_DIR => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_NO_TMP_DIR')),
            UPLOAD_ERR_CANT_WRITE => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_CANT_WRITE')),
            UPLOAD_ERR_EXTENSION => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_EXTENSION')),
            default => new ErrorMessage(Text::_('LIB_PRISM_ERROR_UPLOAD_ERR_UNKNOWN'))
        };

        return false;
    }
}
