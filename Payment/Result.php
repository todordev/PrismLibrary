<?php
/**
 * @package      Prism
 * @subpackage   Payments
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment;

defined('JPATH_PLATFORM') or die;

/**
 * The class should be used for object returned by payment plugins.
 *
 * @package      Prism
 * @subpackage   Payments
 */
class Result
{
    public $project;
    public $reward;
    public $transaction;
    public $paymentSession;
    public $serviceProvider;
    public $serviceAlias;
    public $redirectUrl;
    public $response;
    public $message;

    public $triggerEvents = array(
        'AfterPaymentNotify' => true,
        'AfterPayment' => true
    );

    public $paymentData = array();
}
