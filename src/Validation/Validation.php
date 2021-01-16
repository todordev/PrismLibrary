<?php
/**
 * @package         Prism
 * @subpackage      Files
 * @author       FunFex <opensource@funfex.com>
 * @copyright       Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation;

/**
 * This is the abstract class of validations.
 *
 * @package         Prism
 * @subpackage      Validations
 */
abstract class Validation
{
    /**
     * Error message.
     *
     * @var string
     */
    protected string $message = '';

    /**
     * Additional information about error.
     *
     * @var string
     */
    protected string $additionalInformation = '';

    abstract public function passes(): bool;
    abstract public function fails(): bool;

    /**
     * Return error message.
     *
     * <code>
     * $ipValidation = new Prism\Library\Prism\Validation\Ip;
     *
     * if (!$ipValidation->passes()) {
     *     echo $ipValidation->getMessage();
     * }
     * </code>
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Return additional information about error.
     *
     * <code>
     * $ipValidation = new Prism\Library\Prism\Validation\Ip;
     *
     * if ($ipValidation->fails()) {
     *     echo $ipValidation->getAdditionalInformation();
     * }
     * </code>
     *
     * @return string
     */
    public function getAdditionalInformation(): string
    {
        return $this->additionalInformation;
    }
}
