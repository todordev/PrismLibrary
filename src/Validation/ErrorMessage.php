<?php
/**
 * @package      Prism\Library\Prism\Validation
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation;

/**
 * Error message class.
 *
 * @package Prism\Library\Prism\Validation
 */
final class ErrorMessage
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

    public function __construct(string $message, string $additionalInformation = '')
    {
        $this->message = $message;
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * Return error message.
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Return additional information about error.
     * @return string
     */
    public function getAdditionalInformation(): string
    {
        return $this->additionalInformation;
    }
}
