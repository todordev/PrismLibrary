<?php
/**
 * @package      Prism
 * @subpackage   Payment\iDEAL
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('JPATH_PLATFORM') or die;

JLoader::register('Mollie_API_Client', PRISM_PATH_LIBRARY . '/libs/Mollie/Client.php');
JLoader::register('Mollie_API_Exception', PRISM_PATH_LIBRARY . '/libs/Mollie/Exception.php');
JLoader::register('Mollie_API_CompatibilityChecker', PRISM_PATH_LIBRARY . '/libs/Mollie/CompatibilityChecker.php');

JLoader::register('Mollie_API_Exception_IncompatiblePlatform', PRISM_PATH_LIBRARY . '/libs/Mollie/Exception/IncompatiblePlatform.php');

JLoader::register('Mollie_API_Object_Customer_Mandate', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Customer/Mandate.php');
JLoader::register('Mollie_API_Object_Customer_Subscription', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Customer/Subscription.php');

JLoader::register('Mollie_API_Object_Payment_Refund', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Payment/Refund.php');

JLoader::register('Mollie_API_Object_Profile_APIKey', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Profile/APIKey.php');

JLoader::register('Mollie_API_Object_Customer', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Customer.php');
JLoader::register('Mollie_API_Object_Issuer', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Issuer.php');
JLoader::register('Mollie_API_Object_List', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/List.php');
JLoader::register('Mollie_API_Object_Method', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Method.php');
JLoader::register('Mollie_API_Object_Organization', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Organization.php');
JLoader::register('Mollie_API_Object_Payment', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Payment.php');
JLoader::register('Mollie_API_Object_Permission', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Permission.php');
JLoader::register('Mollie_API_Object_Profile', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Profile.php');
JLoader::register('Mollie_API_Object_Settlement', PRISM_PATH_LIBRARY . '/libs/Mollie/Object/Settlement.php');

JLoader::register('Mollie_API_Resource_Base', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Base.php');
JLoader::register('Mollie_API_Resource_Customers', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Customers.php');
JLoader::register('Mollie_API_Resource_Issuers', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Issuers.php');
JLoader::register('Mollie_API_Resource_Methods', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Methods.php');
JLoader::register('Mollie_API_Resource_Organizations', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Organizations.php');
JLoader::register('Mollie_API_Resource_Payments', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Payments.php');
JLoader::register('Mollie_API_Resource_Permissions', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Permissions.php');
JLoader::register('Mollie_API_Resource_Profiles', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Profiles.php');
JLoader::register('Mollie_API_Resource_Refunds', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Refunds.php');
JLoader::register('Mollie_API_Resource_Settlements', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Settlements.php');
JLoader::register('Mollie_API_Resource_Undefined', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Undefined.php');

JLoader::register('Mollie_API_Resource_Customers_Mandates', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Customers/Mandates.php');
JLoader::register('Mollie_API_Resource_Customers_Payments', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Customers/Payments.php');
JLoader::register('Mollie_API_Resource_Customers_Subscriptions', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Customers/Subscriptions.php');

JLoader::register('Mollie_API_Resource_Payments_Refunds', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Payments/Refunds.php');
JLoader::register('Mollie_API_Resource_Profiles_APIKeys', PRISM_PATH_LIBRARY . '/libs/Mollie/Resource/Profiles/APIKeys.php');


