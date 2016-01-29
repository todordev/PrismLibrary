<?php
/**
 * @package      Prism
 * @subpackage   Payment\AuthorizeNet
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\AuthorizeNet\Service;

use Prism\Payment\AuthorizeNet\Form;
use Joomla\Utilities\ArrayHelper;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that is used for managing Direct Post Method.
 *
 * @package     Prism
 * @subpackage  Payment\AuthorizeNet
 */
class Dpm extends Form
{
    protected $transactionKey;
    protected $custom;

    /**
     * Initialize the object.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * </code>
     *
     * @param array $keys
     */
    public function __construct($keys)
    {
        $this->setApiLoginId(ArrayHelper::getValue($keys, "api_login_id"));
        $this->setTransactionKey(ArrayHelper::getValue($keys, "transaction_key"));
    }

    /**
     * Get an amount.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $amount = $dpm->getAmount();
     * </code>
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->x_amount;
    }

    /**
     * Set an amount.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $amount = 100;
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->setAmount($amount);
     * </code>
     *
     * @param float $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->x_amount = $amount;

        return $this;
    }

    /**
     * Get a sequence.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $sequence = $dpm->getSequence();
     * </code>
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->x_fp_sequence;
    }

    /**
     * Set a sequence.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $sequence = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->setSequence($sequence);
     * </code>
     *
     * @param string $sequence
     *
     * @return self
     */
    public function setSequence($sequence)
    {
        $this->x_fp_sequence = $sequence;

        return $this;
    }

    /**
     * Disable relay response.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->disableRelayResponse();
     * </code>
     *
     * @return self
     */
    public function disableRelayResponse()
    {
        $this->x_relay_response = false;

        return $this;
    }

    /**
     * Enable relay response.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->enableRelayResponse();
     * </code>
     *
     * @return self
     */
    public function enableRelayResponse()
    {
        $this->x_relay_response = true;

        return $this;
    }

    /**
     * Disable test mode.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->disableTestMode();
     * </code>
     *
     * @return self
     */
    public function disableTestMode()
    {
        $this->x_test_request = false;

        return $this;
    }

    /**
     * Enable test mode.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->enableTestMode();
     * </code>
     *
     * @return self
     */
    public function enableTestMode()
    {
        $this->x_test_request = true;

        return $this;
    }

    /**
     * Return relay URL.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $relayUrl = $dpm->getRelayUrl();
     * </code>
     *
     * @return string
     */
    public function getRelayUrl()
    {
        return $this->x_relay_url;
    }

    /**
     * Set relay URL.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $relayURL = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $dpm->setRelayUrl($amount);
     * </code>
     *
     * @param string $relayUrl
     *
     * @return self
     */
    public function setRelayUrl($relayUrl)
    {
        $this->x_relay_url = $relayUrl;

        return $this;
    }

    /**
     * Return API login ID.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $apiLoginId = $dpm->getApiLoginId();
     * </code>
     *
     * @return string
     */
    public function getApiLoginId()
    {
        return $this->x_login;
    }

    /**
     * Set API login ID.
     *
     * <code>
     * $apiLoginId = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setApiLoginId($apiLoginId);
     * </code>
     *
     * @param string $apiLoginId
     *
     * @return self
     */
    public function setApiLoginId($apiLoginId)
    {
        $this->x_login = $apiLoginId;

        return $this;
    }

    /**
     * Return transaction key.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $transactionKey = $dpm->getTransactionKey();
     * </code>
     *
     * @return string
     */
    public function getTransactionKey()
    {
        return $this->transactionKey;
    }

    /**
     * Set transaction key.
     *
     * <code>
     * $transactionKey = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setTransactionKey($transactionKey);
     * </code>
     *
     * @param string $transactionKey
     *
     * @return self
     */
    public function setTransactionKey($transactionKey)
    {
        $this->transactionKey = $transactionKey;

        return $this;
    }

    /**
     * Return currency.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $currency = $dpm->getCurrency();
     * </code>
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->x_currency_code;
    }

    /**
     * Set currency.
     *
     * <code>
     * $currency = "USD";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setCurrency($currency);
     * </code>
     *
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->x_currency_code = $currency;

        return $this;
    }

    /**
     * Return description.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $description = $dpm->getDescription();
     * </code>
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->x_description;
    }

    /**
     * Set description.
     *
     * <code>
     * $description = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setDescription($description);
     * </code>
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->x_description = $description;

        return $this;
    }

    /**
     * Return transaction type.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $type = $dpm->getType();
     * </code>
     *
     * @return string
     */
    public function getType()
    {
        return $this->x_type;
    }

    /**
     * Set a transaction type.
     *
     * <code>
     * $type = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setType($type);
     * </code>
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->x_type = $type;

        return $this;
    }

    /**
     * Return transaction method.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $method = $dpm->getMethod();
     * </code>
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->x_method;
    }

    /**
     * Set a transaction method.
     *
     * <code>
     * $method = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setMethod($method);
     * </code>
     *
     * @param string $method
     *
     * @return self
     */
    public function setMethod($method)
    {
        $this->x_method = $method;

        return $this;
    }

    /**
     * Set a transaction timestamp.
     *
     * <code>
     * $timestamp = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setTimestamp($timestamp);
     * </code>
     *
     * @param string $timestamp
     *
     * @return self
     */
    public function setTimestamp($timestamp)
    {
        $this->x_fp_timestamp = $timestamp;

        return $this;
    }

    /**
     * Return transaction timestamp.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $timestamp = $dpm->getTimestamp();
     * </code>
     *
     * @return string
     */
    public function getTimestamp()
    {
        return $this->x_fp_timestamp;
    }

    /**
     * Set a custom string.
     *
     * <code>
     * $custom = "....";
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm();
     * $dpm->setCustom($custom);
     * </code>
     *
     * @param string $custom
     *
     * @return self
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Return the custom string.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $custom = $dpm->getCustom();
     * </code>
     *
     * @return string
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * Generate and return the hidden fields.
     *
     * <code>
     * $keys = array(
     *      "api_login_id"      => "....",
     *      "transaction_key"   => "...."
     * );
     *
     * $dpm   = new Prism\Payment\AuthorizeNet\Service\Dpm($keys);
     * $hiddenFields = $dpm->getHiddenFields();
     * </code>
     *
     * @return array
     */
    public function getHiddenFields()
    {
        $date = \JDate::getInstance();
        $this->setTimestamp($date->toUnix());

        $this->generateFingerprint($this->transactionKey);

        // Exclude these params
        $excluded = array("transactionKey");

        return $this->getHiddenFieldsArray($excluded);
    }
}
