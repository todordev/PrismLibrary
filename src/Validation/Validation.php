<?php
/**
 * @package     Prism\Library\Prism\Validation
 * @author      FunFex <opensource@funfex.com>
 * @copyright   Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation;

/**
 * This is the abstract class of validations.
 *
 * @package    Prism\Library\Prism\Validation
 */
abstract class Validation
{
    /**
     * Error message.
     *
     * @var ErrorMessage
     */
    protected ErrorMessage $errorMessage;

    abstract public function passes(): bool;
    abstract public function fails(): bool;

    /**
     * Return error message.
     *
     * <code>
     * $ipValidation = new Prism\Library\Prism\Validation\Ip;
     *
     * if (!$ipValidation->passes()) {
     *     echo $ipValidation->errorMessage();
     * }
     * </code>
     *
     * @return ErrorMessage
     */
    public function getErrorMessage(): ErrorMessage
    {
        return $this->errorMessage;
    }
}
