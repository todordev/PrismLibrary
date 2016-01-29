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
 * This class provides functionality for making transactions by Fortumo.
 *
 * @package      Prism
 * @subpackage   Payment\Fortumo
 */
class Response
{
    protected $message;
    protected $sender;
    protected $country;
    protected $price;
    protected $currency;
    protected $service_id;
    protected $message_id;
    protected $keyword;
    protected $shortcode;
    protected $operator;
    protected $billing_type;
    protected $status;
    protected $sig;

    protected $test;

    /**
     * Initialize the object.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * </code>
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        if (!empty($data)) {
            $this->bind($data);
        }
    }

    /**
     * Set properties values to the object.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response();
     * $response->bind($data);
     * </code>
     *
     * @param array $data
     * @param array $ignored
     */
    public function bind($data, $ignored = array())
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $ignored)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Return a status that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $status = $response->getStatus();
     * </code>
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return a message that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $message = $response->getMessage();
     * </code>
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Return the name of the sender that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $sender = $response->getSender();
     * </code>
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Return a country name that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $country = $response->getCountry();
     * </code>
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Return an amount value that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $amount = $response->getPrice();
     * </code>
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Return a currency that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $currency = $response->getCurrency();
     * </code>
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Return a service ID that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $serviceId = $response->getServiceId();
     * </code>
     *
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Return a message ID that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $messageId = $response->getMessageId();
     * </code>
     *
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * Return a keyword that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $keyword = $response->getKeyword();
     * </code>
     *
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Return a short code that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $shortCode = $response->getShortCode();
     * </code>
     *
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortcode;
    }

    /**
     * Return a name of the operator that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $operator = $response->getOperator();
     * </code>
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Return a billing type that comes from Fortumo response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $billingType = $response->getBillingType();
     * </code>
     *
     * @return string
     */
    public function getBillingType()
    {
        return $this->billing_type;
    }

    /**
     * Return the signature used to sign the response.
     *
     * <code>
     * $data = array(
     *     "sender" => "...",
     *     "country" => "...",
     * ...
     * );
     *
     * $response = new Prism\Payment\Fortumo\Response($data);
     * $sig = $response->getSig();
     * </code>
     *
     * @return string
     */
    public function getSig()
    {
        return $this->sig;
    }

    /**
     * Disable test mode.
     *
     * <code>
     * $response = new Prism\Payment\Fortumo\Response();
     * $response->disableTest();
     * </code>
     *
     * @return self
     */
    public function disableTest()
    {
        $this->test = false;

        return $this;
    }

    /**
     * Enable test mode.
     *
     * <code>
     * $response = new Prism\Payment\Fortumo\Response();
     * $response->disableTest();
     * </code>
     *
     * @return self
     */
    public function enableTest()
    {
        $this->test = true;

        return $this;
    }

    /**
     * Check for enabled test mode.
     *
     * <code>
     * $response = new Prism\Payment\Fortumo\Response();
     *
     * if (!$response->isTestMode()) {
     * ...
     * }
     * </code>
     *
     * @return self
     */
    public function isTestMode()
    {
        return (bool)$this->test;
    }
}
