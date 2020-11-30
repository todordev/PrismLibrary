<?php
/**
 * @package         Prism
 * @subpackage      Files
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validator;

/**
 * This is the abstract class of validators.
 *
 * @package         Prism
 * @subpackage      Validators
 * @deprecated
 */
abstract class Validator
{
    /**
     * Error message.
     *
     * @var string
     */
    protected $message = '';

    /**
     * Additional information about error.
     *
     * @var string
     */
    protected $additionalInformation = '';

    abstract public function isValid();

    /**
     * Return error message.
     *
     * <code>
     * $validator = new Prism\Library\Prism\Validator\Validator;
     *
     * if (!$validator->isValid()) {
     *     echo $validator->getMessage();
     * }
     * </code>
     *
     * @return string
     */
    public function getMessage()
    {
        return (string)$this->message;
    }

    /**
     * Return additional information about error.
     *
     * <code>
     * $validator = new Prism\Library\Prism\Validator\Validator;
     *
     * if (!$validator->isValid()) {
     *     echo $validator->getAdditionalInformation();
     * }
     * </code>
     *
     * @return string
     */
    public function getAdditionalInformation()
    {
        return (string)$this->additionalInformation;
    }
}
