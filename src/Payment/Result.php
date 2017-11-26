<?php
/**
 * @package      Prism
 * @subpackage   Payments
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment;

use Prism\Domain\PropertiesMethods;

/**
 * The class should be used for object returned by payment plugins.
 *
 * @package      Prism
 * @subpackage   Payments
 */
class Result
{
    use PropertiesMethods;

    const EVENT_AFTER_PAYMENT_NOTIFY = 'after_payment_notify';
    const EVENT_AFTER_PAYMENT = 'after_payment';

    const ACTION_SEND_CONFIRMATION_MAILS = 'send_confirmation_mails';
    const ACTION_REMOVE_PAYMENT_SESSION  = 'remove_payment_session';

    public $transaction;
    public $project;
    public $reward;
    public $paymentSession;
    public $serviceProvider;
    public $serviceAlias;
    public $redirectUrl;
    public $response;
    public $message;

    /**
     * Data that will be transferred between payment events.
     *
     * @var array
     */
    public $paymentData = array();

    protected $events = array(
        'after_payment_notify' => true,
        'after_payment' => true
    );

    protected $actions = array(
        'send_confirmation' => true,
        'remove_payment_session' => true
    );

    /**
     * Set an event to be skipped during the payment process.
     *
     *<code>
     * $paymentResult = new Prism\Payment\Result();
     *
     * $paymentResult->skipAction(Result::EVENT_AFTER_PAYMENT_NOTIFY);
     * </code>
     *
     * @param $eventName
     * @return self
     */
    public function skipEvent($eventName)
    {
        if (is_string($eventName)) {
            $this->events[$eventName] = false;
        }

        return $this;
    }

    /**
     * Set an action to be skipped during the payment process.
     *
     * <code>
     * $paymentResult = new Prism\Payment\Result();
     *
     * $paymentResult->skipAction(Result::ACTION_SEND_CONFIRMATION_MAILS);
     * </code>
     *
     * @param $actionName
     * @return self
     */
    public function skipAction($actionName)
    {
        if (is_string($actionName)) {
            $this->actions[$actionName] = false;
        }

        return $this;
    }

    /**
     * Check if an event has been skipped.
     *
     * <code>
     * $paymentResult = new Prism\Payment\Result();
     *
     * if ($paymentResult->isEventSkipped(Result::EVENT_AFTER_PAYMENT_NOTIFY)) {
     * //....
     * }
     * </code>
     *
     * @param string $eventName
     *
     * @return bool
     */
    public function isEventSkipped($eventName)
    {
        if (array_key_exists($eventName, $this->events)) {
            return (bool)$this->events[$eventName];
        }

        return true;
    }

    /**
     * Check if an event is active.
     *
     * <code>
     * $paymentResult = new Prism\Payment\Result();
     *
     * if ($paymentResult->isEventActive(Result::EVENT_AFTER_PAYMENT_NOTIFY)) {
     * //....
     * }
     * </code>
     *
     * @param string $eventName
     *
     * @return bool
     */
    public function isEventActive($eventName)
    {
        if (array_key_exists($eventName, $this->events)) {
            return (bool)$this->events[$eventName];
        }

        return false;
    }

    /**
     * Check if an action has been skipped.
     *
     * <code>
     * $paymentResult = new Prism\Payment\Result();
     *
     * if ($paymentResult->isActionSkipped(Result::ACTION_SEND_CONFIRMATION_MAILS)) {
     * //....
     * }
     * </code>
     *
     * @param string $actionName
     *
     * @return bool
     */
    public function isActionSkipped($actionName)
    {
        if (array_key_exists($actionName, $this->actions)) {
            return (bool)$this->actions[$actionName];
        }

        return true;
    }

    /**
     * Check if an action is active.
     *
     * <code>
     * $paymentResult = new Prism\Payment\Result();
     *
     * if ($paymentResult->isActionActive(Result::ACTION_SEND_CONFIRMATION_MAILS)) {
     * //....
     * }
     * </code>
     *
     * @param string $actionName
     *
     * @return bool
     */
    public function isActionActive($actionName)
    {
        if (array_key_exists($actionName, $this->events)) {
            return (bool)$this->actions[$actionName];
        }

        return false;
    }
}
