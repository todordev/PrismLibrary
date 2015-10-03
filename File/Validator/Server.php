<?php
/**
 * @package      Prism
 * @subpackage   Files\Validators
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\File\Validator;

use Prism\Validator\Validator;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for validating a file,
 * using data from server result.
 *
 * @package      Prism
 * @subpackage   Files\Validators
 */
class Server extends Validator
{
    /**
     * An error code that comes from the server.
     *
     * @var integer
     */
    protected $errorCode;

    /**
     * An array with error codes that should be ignored.
     * Those errors will not be treat as en error.
     *
     * @var integer
     */
    protected $ignored = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $errorCode  = 404;
     *
     * $validator = new Prism\File\Validator\Service($errorCode);
     * </code>
     *
     * @param int $errorCode Error code that comes from server.
     * @param array $ignored Ignored server errors.
     */
    public function __construct($errorCode = 0, array $ignored = array())
    {
        $this->errorCode    = $errorCode;
        $this->ignored      = $ignored;
    }

    /**
     * Set a maximum allowed file size.
     *
     * <code>
     * $errorCode  = 404;
     *
     * $validator = new Prism\File\Validator\Service($errorCode);
     * $validator->setErrorCode($maxFileSize);
     * </code>
     *
     * @param integer $errorCode An error code.
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode    = $errorCode;
    }

    /**
     * Validate the size of the file.
     *
     * <code>
     * $errorCode  = 404;
     * $ignored    = array(UPLOAD_ERR_NO_FILE, UPLOAD_ERR_EXTENSION);
     *
     * $validator = new Prism\File\Validator\Service($errorCode);
     *
     * if (!$validator->isValid($ignored)) {
     * ...
     * }
     * </code>
     *
     * @param array $ignored A list with error codes that should be ignored.
     *
     * @return bool
     */
    public function isValid($ignored = array())
    {
        if (is_array($ignored) and count($ignored) > 0) {
            $this->ignored = array_merge($this->ignored, $ignored);
        }

        $result = true;

        // If the error code have to be ignored, this should be treat as not error.
        if (!$this->errorCode or in_array($this->errorCode, $this->ignored, true)) {
            return $result;
        }

        // Check for server errors
        switch ($this->errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_INI_SIZE');
                $result = false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_FORM_SIZE');
                $result = false;
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_PARTIAL');
                $result = false;
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_NO_FILE');
                $result = false;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_NO_TMP_DIR');
                $result = false;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_CANT_WRITE');
                $result = false;
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_EXTENSION');
                $result = false;
                break;
            default:
                $this->message = \JText::_('LIB_PRISM_ERROR_UPLOAD_ERR_UNKNOWN');
                $result = false;
                break;
        }

        return $result;
    }
}
