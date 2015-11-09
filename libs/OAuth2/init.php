<?php
/**
 * @package      Prism
 * @subpackage   Payment\iDEAL
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('JPATH_PLATFORM') or die;

JLoader::register('League\\OAuth2\\Client\\Grant\\Exception\\InvalidGrantException', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/Exception/InvalidGrantException.php');
JLoader::register('League\\OAuth2\\Client\\Grant\\AbstractGrant', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/AbstractGrant.php');
JLoader::register('League\\OAuth2\\Client\\Grant\\AuthorizationCode', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/AuthorizationCode.php');
JLoader::register('League\\OAuth2\\Client\\Grant\\ClientCredentials', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/ClientCredentials.php');
JLoader::register('League\\OAuth2\\Client\\Grant\\GrantFactory', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/GrantFactory.php');
JLoader::register('League\\OAuth2\\Client\\Grant\\Password', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/Password.php');
JLoader::register('League\\OAuth2\\Client\\Grant\\RefreshToken', PRISM_PATH_LIBRARY . '/libs/OAuth2/Grant/RefreshToken.php');
JLoader::register('League\\OAuth2\\Client\\Provider\\Exception\\IdentityProviderException', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/Exception/IdentityProviderException.php');
JLoader::register('League\\OAuth2\\Client\\Provider\\AbstractProvider', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/AbstractProvider.php');
JLoader::register('League\\OAuth2\\Client\\Provider\\GenericProvider', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/GenericProvider.php');
JLoader::register('League\\OAuth2\\Client\\Provider\\GenericResourceOwner', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/GenericResourceOwner.php');
JLoader::register('League\\OAuth2\\Client\\Provider\\ResourceOwnerInterface', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/ResourceOwnerInterface.php');
JLoader::register('League\\OAuth2\\Client\\Token\\AccessToken', PRISM_PATH_LIBRARY . '/libs/OAuth2/Token/AccessToken.php');
JLoader::register('League\\OAuth2\\Client\\Tool\\BearerAuthorizationTrait', PRISM_PATH_LIBRARY . '/libs/OAuth2/Tool/BearerAuthorizationTrait.php');
JLoader::register('League\\OAuth2\\Client\\Tool\\MacAuthorizationTrait', PRISM_PATH_LIBRARY . '/libs/OAuth2/Tool/MacAuthorizationTrait.php');
JLoader::register('League\\OAuth2\\Client\\Tool\\RequestFactory', PRISM_PATH_LIBRARY . '/libs/OAuth2/Tool/RequestFactory.php');
JLoader::register('League\\OAuth2\\Client\\Tool\\RequiredParameterTrait', PRISM_PATH_LIBRARY . '/libs/OAuth2/Tool/RequiredParameterTrait.php');
JLoader::register('AdamPaterson\\OAuth2\\Client\\Provider\\Stripe', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/Stripe.php');
JLoader::register('AdamPaterson\\OAuth2\\Client\\Provider\\StripeResourceOwner', PRISM_PATH_LIBRARY . '/libs/OAuth2/Provider/StripeResourceOwner.php');
