<?php
/**
 * @package      Prism
 * @subpackage   Payment\PayPal
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\PayPal\Adaptive;

use Joomla\Utilities\ArrayHelper;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for managing PayPal Adaptive Response.
 *
 * @package     Prism
 * @subpackage  Payment\PayPal
 */
class Response
{
    /**
     * An array that contains the response.
     *
     * @var array
     */
    protected $response;

    /**
     * Initialize the object.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * </code>
     *
     * @param array    $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Return an array that contains response envelope data.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $envelope = $paypalResponse->getEnvelope();
     * </code>
     *
     * @return array
     */
    public function getEnvelope()
    {
        if (isset($this->response["responseEnvelope"])) {
            return $this->response["responseEnvelope"];
        }

        return array();
    }

    /**
     * Return a property value from the response envelope.
     * You can get following properties: timestamp, ack, correlationId, build;
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $ack = $paypalResponse->getEnvelopeProperty("ack");
     * </code>
     *
     * @param string $key
     *
     * @return null|mixed
     */
    public function getEnvelopeProperty($key)
    {
        if (isset($this->response["responseEnvelope"])) {
            return ArrayHelper::getValue($this->response["responseEnvelope"], $key);
        }

        return null;
    }

    /**
     * Return a payment key.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $payKey = $paypalResponse->getPayKey();
     * </code>
     *
     * @return mixed|null
     */
    public function getPayKey()
    {
        if (isset($this->response["payKey"])) {
            return ArrayHelper::getValue($this->response, "payKey");
        }

        return null;
    }

    /**
     * Return a payment execution status.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $paymentExecStatus = $paypalResponse->getPaymentExecStatus();
     * </code>
     *
     * @return mixed|null
     */
    public function getPaymentExecStatus()
    {
        if (isset($this->response["paymentExecStatus"])) {
            return ArrayHelper::getValue($this->response, "paymentExecStatus");
        }

        return null;
    }

    /**
     * Return a list with payment information.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $paymentInfoList = $paypalResponse->getPaymentInfoList();
     * </code>
     *
     * @return array
     */
    public function getPaymentInfoList()
    {
        if (isset($this->response["paymentInfoList"])) {
            return ArrayHelper::getValue($this->response, "paymentInfoList", array(), "array");
        }

        return array();
    }

    /**
     * Return a list with senders.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $senders = $paypalResponse->getSenders();
     * </code>
     *
     * @return array
     */
    public function getSenders()
    {
        if (isset($this->response["sender"])) {
            return ArrayHelper::getValue($this->response, "sender", array(), "array");
        }

        return array();
    }

    /**
     * Return a preapproval key.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * $preapprovalKey = $paypalResponse->getPreApprovalKey();
     * </code>
     *
     * @return string|null
     */
    public function getPreApprovalKey()
    {
        if (isset($this->response["preapprovalKey"])) {
            return ArrayHelper::getValue($this->response, "preapprovalKey");
        }

        return null;
    }

    /**
     * Check to see if the request has NOT been successfully process.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * if ($paypalResponse->isFailure()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isFailure()
    {
        $ack = $this->getEnvelopeProperty("ack");

        if (strcmp($ack, "Failure") == 0) {
            return true;
        }

        return false;
    }

    /**
     * Check to see if the request has been successfully process.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * if ($paypalResponse->isSuccess()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isSuccess()
    {
        $ack = $this->getEnvelopeProperty("ack");

        if (strcmp($ack, "Success") == 0) {
            return true;
        }

        return false;
    }

    /**
     * Generate and return an error message.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * if ($paypalResponse->isFailure()) {
     *     echo $paypalResponse->getErrorMessage();
     * }
     * </code>
     *
     * @return string
     */
    public function getErrorMessage()
    {
        $errors = ArrayHelper::getValue($this->response, "error", array(), "array");

        $errorMessage = array();

        if (isset($errors["errorId"])) {

            $errorCode = ArrayHelper::getValue($errors, "errorId");
            $errorParameters = ArrayHelper::getValue($errors, "parameter", array(), "array");

            $errorMessage[0]     = "[".ArrayHelper::getValue($errors, "domain") . ":" . ArrayHelper::getValue($errors, "subdomain") ."] [Error Code: ".$errorCode."]";
            $errorMessage[0]     .= "\n".ArrayHelper::getValue($errors, "message");
            $errorMessage[0]     .= "\nParameters: " .var_export($errorParameters, true);

        } elseif (isset($errors[0])) {

            foreach ($errors as $key => $error) {

                $errorCode = ArrayHelper::getValue($error, "errorId");
                $errorParameters = ArrayHelper::getValue($error, "parameter", array(), "array");

                $errorMessage[$key]     = "[".ArrayHelper::getValue($error, "domain") . ":" . ArrayHelper::getValue($error, "subdomain") ."] [Error Code: ".$errorCode."]";
                $errorMessage[$key]     .= "\n".ArrayHelper::getValue($error, "message");
                $errorMessage[$key]     .= "\nParameters: " .var_export($errorParameters, true);

            }

        }

        return implode("\n", $errorMessage);
    }

    /**
     * Return an error code.
     *
     * <code>
     * $response = array(...);
     *
     * $paypalResponse = new PrismPayPalAdaptiveResponse($response);
     * if ($paypalResponse->isFailure()) {
     *     echo $paypalResponse->getErrorCode();
     * }
     * </code>
     *
     * @return int
     */
    public function getErrorCode()
    {
        $errors = ArrayHelper::getValue($this->response, "error", array(), "array");

        $errorCode = 0;

        if (isset($errors["errorId"])) {
            $errorCode = ArrayHelper::getValue($errors, "errorId", 0, "int");
        } elseif (isset($errors[0])) {
            $errorCode = ArrayHelper::getValue($errors[0], "errorId", 0, "int");
        }

        return $errorCode;
    }
}
