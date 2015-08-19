<?php
/**
 * @package      Prism
 * @subpackage   Validators
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Validator;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class validates IP addresses.
 *
 * @package      Prism
 * @subpackage   Validators
 */
class IP implements ValidatorInterface
{
    /**
     * IP address.
     *
     * @var string
     */
    protected $ip;

    /**
     * Allowed IP addresses.
     *
     * @var array
     */
    protected $allowed = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $ip = "127.0.0.1";
     *
     * $validator = new Prism\Validator\IP($ip);
     * </code>
     *
     * @param string $ip
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Validate an IP address.
     *
     * <code>
     * $ip = "127.0.0.1";
     *
     * $validator = new Prism\Validator\IP($ip);
     *
     * if (!$validator->isValid()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isValid()
    {
        $ip = long2ip(ip2long($this->ip));

        if (!$ip) {
            return false;
        }

        // Validate by allowed IP addresses.
        if (!empty($this->allowed) and (!in_array($ip, $this->allowed))) {
            return false;
        }

        return true;
    }

    /**
     * Set a list with IP addresses, that will be used in the process of validation.
     *
     * <code>
     * $ip = "127.0.0.1";
     * $allowed = array("127.0.0.1", "169.0.0.1");
     *
     * $validator = new Prism\Validator\IP($ip);
     * $validator->setAllowed($allowed);
     *
     * if (!$validator->isValid()) {
     * ...
     * }
     * </code>
     *
     * @param array $allowed
     */
    public function setAllowed(array $allowed)
    {
        $this->allowed = $allowed;
    }
}
