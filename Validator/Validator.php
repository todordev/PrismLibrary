<?php
/**
 * @package         Prism
 * @subpackage      Files
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Validator;

defined('JPATH_PLATFORM') or die;

/**
 * This is the abstract class of validators.
 *
 * @package         Prism
 * @subpackage      Validators
 */
abstract class Validator
{
    /**
     * Error message.
     *
     * @var string
     */
    protected $message;

    abstract public function isValid();

    /**
     * Return error message.
     *
     * <code>
     * $validator = new Prism\Validator\Validator;
     *
     * if (!$validator->isValid()) {
     *     echo $validator->getMessage();
     * }
     * </code>
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
