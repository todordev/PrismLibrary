<?php
/**
 * @package      Prism
 * @subpackage   Validations
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Validation;

/**
 * This class validates IP addresses.
 *
 * @package      Prism
 * @subpackage   Validations
 */
class Ip extends Validation
{
    /**
     * IP address.
     *
     * @var string
     */
    protected string $ip;

    /**
     * Allowed IP addresses.
     *
     * @var array
     */
    protected array $allowed = [];

    /**
     * Initialize the object.
     * <code>
     * $ip = "127.0.0.1";
     * $ipValidation = new Prism\Library\Prism\Validation\Ip($ip);
     * </code>
     *
     * @param string $ip
     * @param array $allowed
     */
    public function __construct(string $ip, array $allowed = [])
    {
        $this->ip = $ip;
        $this->allowed = $allowed;
    }

    /**
     * Validate an IP address.
     *
     * <code>
     * $ip = "127.0.0.1";
     *
     * $ipValidation = new Prism\Library\Prism\Validation\Ip($ip);
     *
     * if (!$ipValidation->isValid()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function passes(): bool
    {
        $ip = long2ip(ip2long($this->ip));

        if (!$ip) {
            return false;
        }

        // Validate by allowed IP addresses.
        if (count($this->allowed) > 0 && !in_array($ip, $this->allowed, true)) {
            return false;
        }

        return true;
    }

    public function fails(): bool
    {
        return !$this->passes();
    }
}
