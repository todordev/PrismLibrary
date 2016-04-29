<?php
/**
 * @package      Prism
 * @subpackage   Payment\PayPal
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\PayPal;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that verify PayPal IPN response.
 *
 * @package     Prism
 * @subpackage  Payment\PayPal
 */
class Ipn
{
    const VERIFIED = 'VERIFIED';
    const INVALID  = 'INVALID';

    protected $url = '';
    protected $data = array();
    protected $status;

    protected $error;

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "https://www.paypal.com/cgi-bin/webscr";
     * $data = array(
     *     "property1" => 1,
     *     "property2" => 2,
     * ...
     * );
     *
     * $ipn = new Prism\PayPal\Ipn($url, $data);
     * </code>
     *
     * @param string $url
     * @param array $data
     */
    public function __construct($url, $data)
    {
        $this->url  = $url;
        $this->data = $data;
    }

    /**
     * Check for valid PayPal response.
     *
     * <code>
     * $url = "https://www.paypal.com/cgi-bin/webscr";
     * $data = array(
     *     "property1" => 1,
     *     "property2" => 2,
     * ...
     * );
     *
     * $ipn = new Prism\PayPal\Ipn($url, $data);
     * $ipn->verify();
     *
     * if (!$ipn->isVerified()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isVerified()
    {
        return (bool)($this->status === self::VERIFIED);
    }

    /**
     * Validate PayPal response.
     *
     * <code>
     * $url = "https://www.paypal.com/cgi-bin/webscr";
     * $data = array(
     *     "property1" => 1,
     *     "property2" => 2,
     * ...
     * );
     *
     * $ipn = new Prism\PayPal\Ipn($url, $data);
     * $ipn->verify();
     * </code>
     *
     * @param bool $loadCertificate Load or not certificate which will encrypt the requests.
     *
     * @return void
     */
    public function verify($loadCertificate = false)
    {
        if (!function_exists('curl_version')) {
            $this->error = \JText::sprintf('LIB_PRISM_ERROR_CURL_LIBRARY_NOT_LOADED');
            return;
        }

        // Decode data
        foreach ($this->data as $key => $value) {
            $this->data[rawurldecode($key)] = rawurldecode($value);
        }

        // Strip slashes if magic quotes are enabled
        if (function_exists('get_magic_quotes_gpc') and (1 === (int)get_magic_quotes_gpc())) {
            foreach ($this->data as $key => $value) {
                $this->data[stripslashes($key)] = stripslashes($value);
            }
        }

        // Prepare request data
        $request = 'cmd=_notify-validate';
        foreach ($this->data as $key => $value) {
            $request .= '&' . rawurlencode($key) . '=' . rawurlencode($value);
        }

        $ch = curl_init($this->url);
        if (false === $ch) {
            $this->error = \JText::sprintf('LIB_PRISM_ERROR_PAYPAL_CONNECTION', $this->url) . "\n";
            return;
        }

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if ($loadCertificate) {
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
        }

        $result = curl_exec($ch);

        if (false === $result) {
            $this->error = \JText::sprintf('LIB_PRISM_ERROR_PAYPAL_RECEIVING_DATA', $this->url) . '\n';
            $this->error .= curl_error($ch);
            return;
        }

        // If the payment is verified then set the status as verified.
        if ($result === 'VERIFIED') {
            $this->status = self::VERIFIED;
        } else {
            $this->status = self::INVALID;
        }
    }

    /**
     * Return an error message.
     *
     * <code>
     * $url = "https://www.paypal.com/cgi-bin/webscr";
     * $data = array(
     *     "property1" => 1,
     *     "property2" => 2,
     * ...
     * );
     *
     * $ipn = new Prism\PayPal\Ipn($url, $data);
     * $ipn->verify();
     *
     * if (!$ipn->isVerified()) {
     *     echo $ipn->getError();
     * }
     *
     * </code>
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Parse raw POST data and extract transaction one.
     *
     * @return array
     */
    public function getTransactionData()
    {
        $transactions = array();

        if (isset($this->data['transaction[0].id'])) {
            foreach ($this->data as $key => $value) {
                if (false !== strpos($key, 'transaction[')) {
                    preg_match("/\[([^\]]*)\]\.(\w+)$/i", $key, $matches);

                    if (isset($matches[1])) {
                        // Create an array.
                        if (!isset($transactions[$matches[1]]) or !is_array($transactions[$matches[1]])) {
                            $transactions[$matches[1]] = array();
                        }

                        // Add the value to a property.
                        if (!empty($matches[2])) {
                            $transactions[$matches[1]][$matches[2]] =  $value;
                        }
                    }
                }
            }
        }

        return $transactions;
    }
}
