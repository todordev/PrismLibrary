<?php
/**
 * @package      Prism
 * @subpackage   Payment\iDEAL
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('JPATH_PLATFORM') or die;

JLoader::register("Mollie_API_Client", PRISM_PATH_LIBRARY . "/payment/mollie/Client.php");
JLoader::register("Mollie_API_Exception", PRISM_PATH_LIBRARY . "/payment/mollie/Exception.php");

JLoader::register("Mollie_API_Resource_Base", PRISM_PATH_LIBRARY . "/payment/mollie/Resource/Base.php");
JLoader::register("Mollie_API_Resource_Issuers", PRISM_PATH_LIBRARY . "/payment/mollie/Resource/Issuers.php");
JLoader::register("Mollie_API_Resource_Methods", PRISM_PATH_LIBRARY . "/payment/mollie/Resource/Methods.php");
JLoader::register("Mollie_API_Resource_Payments", PRISM_PATH_LIBRARY . "/payment/mollie/Resource/Payments.php");
JLoader::register("Mollie_API_Resource_Payments_Refunds", PRISM_PATH_LIBRARY . "/payment/mollie/Resource/Payments/Refunds.php");

JLoader::register("Mollie_API_Object_Issuer", PRISM_PATH_LIBRARY . "/payment/mollie/Object/Issuer.php");
JLoader::register("Mollie_API_Object_List", PRISM_PATH_LIBRARY . "/payment/mollie/Object/List.php");
JLoader::register("Mollie_API_Object_Method", PRISM_PATH_LIBRARY . "/payment/mollie/Object/Method.php");
JLoader::register("Mollie_API_Object_Payment", PRISM_PATH_LIBRARY . "/payment/mollie/Object/Payment.php");
JLoader::register("Mollie_API_Object_Payment_Refunds", PRISM_PATH_LIBRARY . "/payment/mollie/Object/Payment/Refund.php");