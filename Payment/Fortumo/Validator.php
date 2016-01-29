<?php
/**
 * @package      Prism
 * @subpackage   Payment\Fortumo
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\Fortumo;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class validates Fortumo response data.
 *
 * @package      Prism
 * @subpackage   Payment\Fortumo
 */
class Validator implements ValidatorInterface
{
    protected $data = array();

    /**
     * This is the secret key.
     *
     * @var string
     */
    protected $secret = "";

    /**
     * Initialize the object.
     *
     * <code>
     * $secret = "SECRET_KEY";
     * $data = array(
     *     "sig" => "...",
     * );
     *
     * $validator = new Prism\Payment\Fortumo\Validator($data, $secret);
     * </code>
     *
     * @param array $data Data that comes from Fortumo servers.
     * @param string $secret
     */
    public function __construct($data, $secret)
    {
        $this->data   = $data;
        $this->secret = $secret;
    }

    /**
     * Validate a response that comes from Fortumo servers.
     *
     * <code>
     * $secret = "SECRET_KEY";
     * $data = array(
     *     "sig" => "...",
     * );
     *
     * $validator = new Prism\Payment\Fortumo\Validator($data, $secret);
     *
     * if (!$validator->isValid()) {
     * ....
     * }
     * </code>
     *
     * @return bool
     */
    public function isValid()
    {
        if (!isset($this->data['sig'])) {
            return false;
        }

        ksort($this->data);

        $str = '';
        foreach ($this->data as $k => $v) {
            if ($k != 'sig') {
                $str .= "$k=$v";
            }
        }
        $str .= $this->secret;
        $signature = md5($str);

        if (strcmp($this->data['sig'], $signature) != 0) {
            return false;
        }

        return true;
    }
}
