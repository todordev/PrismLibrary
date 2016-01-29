<?php
/**
 * @package      Prism
 * @subpackage   Transifex
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Transifex;

use Joomla\Utilities\ArrayHelper;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for making requests to Transifex servers.
 *
 * @package      Prism
 * @subpackage   Transifex
 */
class Request
{
    protected $url;
    protected $timeout = 400;
    protected $connectionTimeout = 120;
    protected $username;
    protected $password;
    protected $auth = false;

    protected $info;
    protected $data = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     *
     * $request = new Prism\\Transifex\\Request($url);
     * </code>
     *
     * @param string $url Transifex API URL
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Make a request to Transifex server.
     *
     * @param string  $path
     * @param array $options
     *
     * @throws \RuntimeException
     *
     * @return null|Response
     */
    protected function request($path, array $options = array())
    {
        if (!function_exists('curl_version')) {
            throw new \RuntimeException('The cURL library is not loaded.');
        }

        $headers  = ArrayHelper::getValue($options, 'headers', array(), 'array');
        $method   = ArrayHelper::getValue($options, 'method', 'get');
        $postData = ArrayHelper::getValue($options, 'data', array(), 'array');

        $url = $this->url . $path;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Prepare headers
        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }

        if (strcmp($method, 'post') === 0) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        }

        if ($this->auth) {
            curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }

        // Get the data
        $response = curl_exec($ch);
        if (false !== $response) {
            $this->data = json_decode($response, true);
            if (!is_array($this->data)) {
                $message = (string)$response . ' (' . $url . ')';
                throw new \RuntimeException($message);
            }
        }

        // Get info about the request
        $this->info = curl_getinfo($ch);

        // Check for error
        $errorNumber = curl_errno($ch);
        if ($errorNumber > 0) {
            $message = curl_error($ch) . '(' . (int)$errorNumber . ')';
            throw new \RuntimeException($message);
        }

        // Close the request
        curl_close($ch);

        // Create response object
        $response = new Response();
        $response->bind($this->data);

        return $response;
    }

    /**
     * Make a request to Transifex server and return response.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     * $path = "projects";
     *
     * $options = array(
     *     "headers" => array(
     *          'Content-type: application/json',
     *          'X-HTTP-Method-Override: GET'
     *      ),
     *      "method" => "get", // GET or POST
     *      "data"   => array() // Data that should be sent to Transifex servers.
     * );
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->get($path, $options);
     * </code>
     *
     * @param string $path   A name of Transifex object.
     * @param array $options You can set three kind of options - headers, method and data.
     *
     * @return null|Response
     */
    public function get($path, array $options = array())
    {
        return $this->request($path, $options);
    }

    /**
     * Return the username.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->getUsername();
     * </code>
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set a Transifex username.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     * $username = "MyTransifexUsername";
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->setUsername($username);
     * </code>
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Return the password.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->getPassword();
     * </code>
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set a Transifex password.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     * $password = "MyTransifexPassword";
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->setPassword($password);
     * </code>
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Enable Transifex authentication.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->enableAuthentication();
     * </code>
     *
     * @return self
     */
    public function enableAuthentication()
    {
        $this->auth = true;

        return $this;
    }

    /**
     * Enable Transifex authentication.
     *
     * <code>
     * $url = "https://www.transifex.com/api/2/";
     *
     * $request = new Prism\Transifex\Request($url);
     * $request->disableAuthentication();
     * </code>
     *
     * @return self
     */
    public function disableAuthentication()
    {
        $this->auth = false;

        return $this;
    }
}
