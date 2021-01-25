<?php
/**
 * @package      Prism
 * @subpackage   Payment\PayPal
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Payment\PayPal;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that verify PayPal IPN response.
 *
 * @package     Prism
 * @subpackage  Payment\PayPal
 *
 * @deprecated v1.21 Use PayPal PPIPNMessage
 */
class Ipn
{
    const VERIFIED = 'VERIFIED';
    const INVALID  = 'INVALID';

    protected $url = '';
    protected $data;
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
     * $ipn = new Prism\Library\Prism\PayPal\Ipn($url, $data);
     * </code>
     *
     * @param string $url
     * @param array $data
     */
    public function __construct($url, array $data = array())
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
     * $ipn = new Prism\Library\Prism\PayPal\Ipn($url, $data);
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
     * $ipn = new Prism\Library\Prism\PayPal\Ipn($url, $data);
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

        // Prepare request data
        $request = 'cmd=_notify-validate';
        foreach ($this->data as $key => $value) {
            $request .= '&' . $key . '=' . urlencode($value);
        }

        $ch = curl_init($this->url);
        if (false === $ch) {
            $this->error = \JText::sprintf('LIB_PRISM_ERROR_PAYPAL_CONNECTION', $this->url) . "\n";
            return;
        }

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');

        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: CrowdfundingPlatform',
            'Connection: Close'
        ));

        if ($loadCertificate) {
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
        }

        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($ch);

        $errNo        = curl_errno($ch);
        $error        = curl_error($ch);
        $lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($errNo > 0 and !empty($error)) {
            $this->error  = 'Data from PayPal IPN: ' . $this->url. "\n";
            $this->error .= $error;
            return;
        }

        if ($lastHttpCode >= 400) {
            $this->error  = 'Invalid HTTP status '. $lastHttpCode .' verifying PayPal IPN';
        }

        if ($result === self::INVALID) {
            $this->error = 'PayPal claims the IPN data is INVALID – Possible fraud!';
        }

        // If the payment is verified then set the status as verified.
        $this->status = ($result === 'VERIFIED') ? self::VERIFIED : self::INVALID;
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
     * $ipn = new Prism\Library\Prism\PayPal\Ipn($url, $data);
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
     * Return raw data from post request.
     *
     * <code>
     * $url = "https://www.paypal.com/cgi-bin/webscr";
     * $data = array(
     *     "property1" => 1,
     *     "property2" => 2,
     * ...
     * );
     *
     * $data = Prism\Library\Prism\PayPal\Ipn::getRawPostData();
     *
     * $ipn = new Prism\Library\Prism\PayPal\Ipn($url, $data);
     * $ipn->verify();
     *
     * if (!$ipn->isVerified()) {
     *     echo $ipn->getError();
     * }
     *
     * </code>
     *
     * @return array
     */
    public static function getRawPostData()
    {
        $rawPostData = file_get_contents('php://input');
        $rawPostArray = explode('&', $rawPostData);

        $myPost = array();

        foreach ($rawPostArray as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) === 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }

                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        return $myPost;
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

    public function getProperties()
    {
        return [
            'url' => $this->url,
            'data' => $this->data,
            'status' => $this->status,
            'error' => $this->error
        ];
    }
}
