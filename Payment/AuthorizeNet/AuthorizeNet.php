<?php
/**
 * @package      Prism
 * @subpackage   Payment\AuthorizeNet
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\Payment\AuthorizeNet;

use Joomla\String\String;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that create
 * AuthorizeNet objects.
 *
 * @package     Prism
 * @subpackage  Payment\AuthorizeNet
 */
abstract class AuthorizeNet
{
    /**
     * Create an object based on AuthorizeNet payment types.
     *
     * <code>
     * $service = "DPM";
     * $keys = array(
     *     "api_login_id" => "...",
     *     "transaction_key" => "...",
     * );
     *
     * $authorizeNet = Prism\Payment\AuthorizeNet::factory($service, $keys);
     *
     * </code>
     *
     * @param  string $name Payment type name.
     * @param  array  $keys Authorization keys.
     *
     * @return object
     *
     * @throws \Exception
     */
    public static function factory($name, $keys = array())
    {
        $name   = String::strtolower($name);
        $loaded = jimport("itprism.payment.authorizenet.services." . $name);

        if (!$loaded) {
            throw new \Exception('This payment type does not exist.');
        } else {
            // Build the name of the class, instantiate, and return
            $className = 'Prism\\Payment\\AuthorizeNet\\' . ucfirst($name);

            return new $className($keys);
        }
    }
}
