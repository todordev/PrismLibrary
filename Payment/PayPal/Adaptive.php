<?php
/**
 * @package      Prism
 * @subpackage   Payment\PayPal
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\PayPal;

use Prism\Payment\PayPal\Adaptive\Response;
use Joomla\Registry\Registry;

// no direct access
defined('JPATH_PLATFORM') or die;

jimport("joomla.http.http");
jimport("joomla.http.transport.curl");

/**
 * This class contains methods that manage PayPal Adaptive.
 *
 * @package     Prism
 * @subpackage  Payment\PayPal
 */
class Adaptive
{
    protected $url;

    /**
     * @var Registry
     */
    protected $options;

    /**
     * @var \JHttp
     */
    protected $transport;

    protected $error;
    protected $errorCode;

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $paypal = new PrismPayPalAdaptive($url);
     * </code>
     *
     * @param string    $url
     * @param Registry $options
     */
    public function __construct($url, Registry $options)
    {
        $this->url     = $url;
        $this->options = $options;
    }

    /**
     * Set an option value.
     *
     * <code>
     * $url = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $paypal = new PrismPayPalAdaptive($url);
     *
     * $paypal->setOption("credentials.app_id", "APP-80W284485P519543T");
     * </code>
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return self
     */
    public function setOption($key, $value)
    {
        $this->options->set($key, $value);

        return $this;
    }

    /**
     * Return option value
     *
     * <code>
     * $url = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $paypal = new PrismPayPalAdaptive($url);
     *
     * $appId = $paypal->getOption("credentials.app_id");
     * </code>
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return $this->options->get($key, $default);
    }

    /**
     * Set an option value.
     *
     * <code>
     * $url  = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     * $http = new JHttp();
     *
     * $paypal = new PrismPayPalAdaptive($url);
     *
     * $paypal->setTransport($http);
     * </code>
     *
     * @param \JHttp $transport
     *
     * @return self
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Return information about error.
     *
     * <code>
     * $url  = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $paypal = new PrismPayPalAdaptive($url);
     *
     * $error = $paypal->getError();
     * </code>
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Return error code.
     *
     * <code>
     * $url  = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $paypal = new PrismPayPalAdaptive($url);
     *
     * $errorCode = $paypal->getErrorCode();
     * </code>
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Send data to PayPal servers and handling the PayPal method "Preapproval".
     *
     * <code>
     * $url  = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $options = new Registry();
     * $options->set("credentials.username", "itprism");
     * ....
     *
     * $paypal = new PrismPayPalAdaptive($url, $options);
     * $paypal->doPreppproval();
     * </code>
     *
     * @return Response
     *
     * @throws \RuntimeException
     */
    public function doPreppproval()
    {
        $url = $this->url . "Preapproval";

        $data = array(
            "cancelUrl"                   => $this->options->get("urls.cancel"),
            "returnUrl"                   => $this->options->get("urls.return"),
            "ipnNotificationUrl"          => $this->options->get("urls.notify"),

            "startingDate"                => $this->options->get("payment.starting_date"),
            "endingDate"                  => $this->options->get("payment.ending_date"),
            "maxAmountPerPayment"         => $this->options->get("payment.max_amount"),
            "maxTotalAmountOfAllPayments" => $this->options->get("payment.max_total_amount"),
            "maxNumberOfPayments"         => $this->options->get("payment.number_of_payments"),
            "currencyCode"                => $this->options->get("payment.currency_code"),

            "feesPayer"                   => $this->options->get("payment.fees_payer"),
            "memo"                        => $this->options->get("payment.memo"),

            "pinType"                     => $this->options->get("payment.ping_type"),
            "requestEnvelope"             => $this->options->get("request.envelope"),
        );

        // Encode data to JSON.
        $jsonData = json_encode($data);

        // Prepare headers.
        $headers = $this->getHeaders($jsonData);

        // Make a request.
        $response = $this->transport->post($url, $jsonData, $headers);

        $response = $this->parseResponse($response, "json");

        $response = new Response($response);

        if ($response->isFailure()) { // Failure

            $this->error     = $response->getErrorMessage();
            $this->errorCode = $response->getErrorCode();

            throw new \RuntimeException($this->error, $this->errorCode);
        }

        return $response;
    }

    /**
     * Send data to PayPal servers and handling the PayPal method "Pay".
     *
     * <code>
     * $url  = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $options = new Registry();
     * $options->set("credentials.username", "itprism");
     * ....
     *
     * $paypal = new PrismPayPalAdaptive($url, $options);
     * $paypal->doCapture();
     * </code>
     *
     * @return Response
     *
     * @throws \RuntimeException
     */
    public function doCapture()
    {
        $url = $this->url . "Pay";

        $data = array(
            "cancelUrl"                   => $this->options->get("urls.cancel"),
            "returnUrl"                   => $this->options->get("urls.return"),
            "ipnNotificationUrl"          => $this->options->get("urls.notify"),

            "actionType"                  => $this->options->get("payment.action_type"),

            "feesPayer"                   => $this->options->get("payment.fees_payer"),
            "memo"                        => $this->options->get("payment.memo"),

            "preapprovalKey"              => $this->options->get("payment.preapproval_key"),
            "currencyCode"                => $this->options->get("payment.currency_code"),
            "receiverList"                => $this->options->get("payment.receiver_list"),

            "requestEnvelope"             => $this->options->get("request.envelope"),
        );

        // Encode data to JSON.
        $jsonData = json_encode($data);

        // Prepare headers.
        $headers = $this->getHeaders($jsonData);

        // Make a request.
        $response = $this->transport->post($url, $jsonData, $headers);

        $response = $this->parseResponse($response, "json");

        $response = new Response($response);

        if ($response->isFailure()) { // Failure
            $this->error     = $response->getErrorMessage();
            $this->errorCode = $response->getErrorCode();

            throw new \RuntimeException($this->error, $this->errorCode);
        }

        return $response;
    }

    /**
     * Send data to PayPal servers and handling the PayPal method "CancelPreapproval".
     *
     * <code>
     * $url  = "https://svcs.sandbox.paypal.com/AdaptivePayments";
     *
     * $options = new Registry();
     * $options->set("credentials.username", "itprism");
     * ....
     *
     * $paypal = new PrismPayPalAdaptive($url, $options);
     * $paypal->doVoid();
     * </code>
     *
     * @return Response
     *
     * @throws \RuntimeException
     */
    public function doVoid()
    {
        $url = $this->url . "CancelPreapproval";

        $data = array(
            "preapprovalKey"              => $this->options->get("payment.preapproval_key"),
            "requestEnvelope"             => $this->options->get("request.envelope"),
        );

        // Encode data to JSON.
        $jsonData = json_encode($data);

        // Prepare headers.
        $headers = $this->getHeaders($jsonData);

        // Make a request.
        $response = $this->transport->post($url, $jsonData, $headers);

        $response = $this->parseResponse($response, "json");

        $response = new Response($response);

        if ($response->isFailure()) { // Failure
            $this->error     = $response->getErrorMessage();
            $this->errorCode = $response->getErrorCode();

            throw new \RuntimeException($this->error, $this->errorCode);
        }

        return $response;
    }

    /**
     * Return the response data that comes from PayPal.
     *
     * @param object $response
     * @param string $mode The type of the string ( Named Values or JSON )
     *
     * @return array
     */
    protected function parseResponse($response, $mode = "nv")
    {
        $body = array();

        switch ($mode) {

            case "json":
                $body = json_decode($response->body, true);
                break;

            default: // Named values
                $body_ = explode("&", $response->body);
                foreach ($body_ as $value) {
                    $value_ = rawurldecode($value);
                    $values = explode("=", $value_);

                    $body[$values[0]] = rawurldecode($values[1]);
                }
                break;
        }

        if (!$body) {
            $body = array();
        }

        return $body;
    }

    /**
     * Return an array with headers needed to make a request.
     *
     * @param string $jsonData
     *
     * @return array
     */
    protected function getHeaders($jsonData)
    {
        return array(
            "X-PAYPAL-SECURITY-USERID" => $this->options->get("credentials.username"),
            "X-PAYPAL-SECURITY-PASSWORD" => $this->options->get("credentials.password"),
            "X-PAYPAL-SECURITY-SIGNATURE" => $this->options->get("credentials.signature"),
            "X-PAYPAL-APPLICATION-ID" => $this->options->get("credentials.app_id"),
//            "X-PAYPAL-DEVICE-IPADDRESS" => $this->options->get("credentials.ip_address"),
            "X-PAYPAL-REQUEST-DATA-FORMAT" => "JSON",
            "X-PAYPAL-RESPONSE-DATA-FORMAT" => "JSON",
            'Content-Type'          => 'application/json',
            'Content-Length'        => strlen($jsonData)
        );

    }
}
