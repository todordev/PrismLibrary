<?php
/**
 * @package      Prism
 * @subpackage   Payment\AuthorizeNet
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\AuthorizeNet;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods used for managing AuthorizeNet response.
 *
 * @package     Prism
 * @subpackage  Payment\AuthorizeNet
 */
class Response
{
    const APPROVED = 1;
    const DECLINED = 2;
    const ERROR    = 3;
    const HELD     = 4;

    protected $api_login_id;
    protected $md5_setting;
    protected $response;
    protected $custom;

    public $x_response_code;
    public $x_response_reason_code;
    public $x_response_reason_text;

    public $x_auth_code; // The authorization or approval code
    public $x_avs_code; // The Address Verification Service (AVS) response code
    public $x_trans_id; // The payment gateway assigned identification number for the transaction

    public $x_amount;
    public $x_method;
    public $x_type; // The type of credit card transaction
    public $x_account_number; // Last 4 digits of the card provided
    public $x_card_type; // Visa, MasterCard, American Express, Discover, Diners Club, JCB

    public $x_first_name;
    public $x_last_name;
    public $x_company;
    public $x_address;
    public $x_city;
    public $x_state;
    public $x_zip;
    public $x_country;
    public $x_phone;
    public $x_fax;
    public $x_email;
    public $x_invoice_num;
    public $x_description;
    public $x_cust_id; // The merchant assigned customer ID

    public $x_ship_to_first_name;
    public $x_ship_to_last_name;
    public $x_ship_to_company;
    public $x_ship_to_address;
    public $x_ship_to_city;
    public $x_ship_to_state;
    public $x_ship_to_zip;
    public $x_ship_to_country;
    public $x_tax;
    public $x_duty;
    public $x_freight;
    public $x_tax_exempt;
    public $x_po_num; // The merchant assigned purchase order number
    public $x_MD5_Hash;
    public $x_cvv2_resp_code; // The card code verification (CCV) response code
    public $x_cavv_response; // The cardholder authentication verification response code

    public $x_test_request;
    public $x_currency_code;

    /**
     * Initialize the object.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * </code>
     *
     * @param array $data Fields to set.
     * @param array $excluded Fields to exclude.
     */
    public function __construct($data = array(), $excluded = array())
    {
        if (!empty($data)) {
            // Set response data
            $this->response = $data;

            foreach ($data as $key => $value) {
                if (in_array($key, $excluded)) {
                    continue;
                }
                $this->$key = $value;
            }
        }
    }

    /**
     * Return API Login ID.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $apiLoginId = $response->getApiLoginId();
     * </code>
     *
     * @return string
     */
    public function getApiLoginId()
    {
        return $this->api_login_id;
    }

    /**
     * Set API Login ID.
     *
     * <code>
     * $apiLoginId = "...";
     *
     * $response = new Prism\Payment\AuthorizeNet\Response();
     * $response->setApiLoginId($apiLoginId);
     * </code>
     *
     * @param string $apiLoginId
     *
     * @return self
     */
    public function setApiLoginId($apiLoginId)
    {
        $this->api_login_id = $apiLoginId;

        return $this;
    }

    /**
     * Return MD5 settings.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $md5Setting = $response->getMd5Setting();
     * </code>
     *
     * @return string
     */
    public function getMd5Setting()
    {
        return $this->md5_setting;
    }

    /**
     * Set MD5 settings.
     *
     * <code>
     * $md5Settings = "...";
     *
     * $response = new Prism\Payment\AuthorizeNet\Response();
     * $response->setMd5Setting($md5Settings);
     * </code>
     *
     * @param string $md5Setting
     *
     * @return self
     */
    public function setMd5Setting($md5Setting)
    {
        $this->md5_setting = $md5Setting;

        return $this;
    }

    /**
     * Check for valid AuthorizeNet response.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * if (!$response->isAuthorizeNet()) {
     * ....
     * }
     * </code>
     *
     * @return bool
     */
    public function isAuthorizeNet()
    {
        $hash = $this->generateHash();

        if (!empty($this->x_MD5_Hash) and ($hash == $this->x_MD5_Hash)) {
            return true;
        }

        return false;
    }

    /**
     * Generates an MD5 hash to compare Authorize.Net response.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $hash = $response->generateHash();
     * </code>
     *
     * @return string Hash
     */
    public function generateHash()
    {
        $amount = (!$this->x_amount) ? "0.00" : $this->x_amount;

        return strtoupper(md5($this->md5_setting . $this->api_login_id . $this->x_trans_id . $amount));
    }

    /**
     * Check for the type of the transactions. Is it approved.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * if (!$response->isApproved()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isApproved()
    {
        if ($this->x_response_code == self::APPROVED) {
            return true;
        }

        return false;
    }

    /**
     * Check for the type of the transactions. Is it declined.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * if ($response->isDeclined()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isDeclined()
    {
        if ($this->x_response_code == self::DECLINED) {
            return true;
        }

        return false;
    }

    /**
     * Check for error during the process of payment.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * if ($response->isError()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isError()
    {
        if ($this->x_response_code == self::ERROR) {
            return true;
        }

        return false;
    }

    /**
     * Check for held transaction state.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * if ($response->isHeld()) {
     * ...
     * }
     * </code>
     *
     * @return bool
     */
    public function isHeld()
    {
        if ($this->x_response_code == self::HELD) {
            return true;
        }

        return false;
    }

    /**
     * Check for held transaction state.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $transactionId = $response->getTransactionId();
     * </code>
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->x_trans_id;
    }

    /**
     * Set a transaction ID.
     *
     * <code>
     * $transactionId = "TXN_ID";
     *
     * $response = new Prism\Payment\AuthorizeNet\Response();
     * $response->setTransactionId($transactionId);
     * </code>
     *
     * @param string $transactionId
     *
     * @return self
     */
    public function setTransactionId($transactionId)
    {
        $this->x_trans_id = $transactionId;

        return $this;
    }

    /**
     * Get amount from AuthorizeNet response.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $amount = $response->getAmount();
     * </code>
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->x_amount;
    }

    /**
     * Get a currency of a transaction.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $currency = $response->getCurrency();
     * </code>
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->x_currency_code;
    }

    /**
     * Get response code of the response.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $responseCode = $response->getResponseReasonCode();
     * </code>
     *
     * @return mixed
     */
    public function getResponseReasonCode()
    {
        return $this->x_response_reason_code;
    }

    /**
     * Get reason text of the response.
     *
     * <code>
     * $data = array(
     *     "x_amount" => "...",
     *     "x_method" => "...",
     * ....
     * );
     *
     * $response = new Prism\Payment\AuthorizeNet\Response($data);
     * $responseReasonText = $response->getResponseReasonText();
     * </code>
     *
     * @return string
     */
    public function getResponseReasonText()
    {
        return $this->x_response_reason_text;
    }
}
