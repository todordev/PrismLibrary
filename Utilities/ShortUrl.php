<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for generating short URL,
 * using some services like bitly, google, tinycc,...
 *
 * @package      Prism
 * @subpackage   Utilities
 */
class ShortUrl
{
    private $url;
    private $shortUrl;
    private $apiKey;
    private $service;
    private $login;

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "http://itprism.com/";
     *
     * $options = array(
     *     "api_key" => ".....",
     *     "service" => ".....",
     *     "login" => "....."
     * );
     *
     * $urlService = new Prism\ShortUrl($url, $options);
     * </code>
     *
     * @param string $url
     * @param array $options
     */
    public function __construct($url, array $options = array())
    {
        $this->url = $url;

        $this->bind($options);
    }

    /**
     * Set the options of a short URL service.
     *
     * <code>
     * $url = "http://itprism.com/";
     *
     * $options = array(
     *     "api_key" => ".....",
     *     "service" => ".....",
     *     "login" => "....."
     * );
     *
     * $urlService = new Prism\Utilities\ShortUrl($url);
     * $urlService->bind($options);
     * </code>
     *
     * @param array $options
     */
    public function bind($options)
    {
        if (array_key_exists('api_key', $options)) {
            $this->apiKey = $options['api_key'];
        }

        if (array_key_exists('service', $options)) {
            $this->service = $options['service'];
        }

        if (array_key_exists('login', $options)) {
            $this->login = $options['login'];
        }
    }

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "http://itprism.com/";
     *
     * $options = array(
     *     "api_key" => ".....",
     *     "service" => "google", // jmp, bitlycom, tinycc, google, bitly
     *     "login" => "....."
     * );
     *
     * $urlService = new Prism\Utilities\ShortUrl($url, $options);
     *
     * $shortUrl = $urlService->getUrl();
     * </code>
     *
     * @throws \Exception
     */
    public function getUrl()
    {
        // Check for installed CURL library
        $installedLibraries = get_loaded_extensions();
        if (!in_array('curl', $installedLibraries, true)) {
            throw new \Exception('LIB_PRISM_ERROR_SHORT_URL_SERVICE_REQUEST');
        }

        switch ($this->service) {

            case 'jmp':
                $this->getBitlyURL('j.mp');
                break;

            case 'bitlycom':
                $this->getBitlyURL('bitly.com');
                break;

            case 'tinycc':
                $this->getTinyURL();
                break;

            case 'google':
                $this->getGoogleURL();
                break;

            default: // bit.ly
                $this->getBitlyURL('bit.ly');
                break;

        }

        return $this->shortUrl;
    }

    /**
     * Get a short URL from Bitly.
     *
     * @param string $domain - bit.ly, j.mp, bitly.com
     *
     * @throws \Exception
     */
    protected function getBitlyURL($domain = 'bit.ly')
    {
        $url = 'http://api.bitly.com/v3/shorten?login=' . $this->login . '&apiKey=' . $this->apiKey . '&longUrl=' . $this->url . '&format=json&domain=' . $domain;

        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $url);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);

        //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        $response = curl_exec($curlObj);

        curl_close($curlObj);

        if (false !== $response) {
            $json = json_decode($response);

            if ((int)$json->status_code !== 200) {
                $errorMessage = '[Bitly service] Message: ' . $json->status_txt;
                throw new \Exception($errorMessage);
            } else {
                $this->shortUrl = $json->data->url;
            }
        } else {
            throw new \Exception(\JText::_('LIB_PRISM_ERROR_SHORT_URL_SERVICE_REQUEST'));
        }
    }

    /**
     * Get a short URL from Tiny.CC.
     *
     * @throws \Exception
     */
    protected function getTinyURL()
    {
        $url = 'http://tiny.cc/?c=rest_api&m=shorten&version=2.0.3&format=json&shortUrl=&longUrl=' . $this->url . '&login=' . $this->login . '&apiKey=' . $this->apiKey;

        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $url);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);

        //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        $response = curl_exec($curlObj);

        curl_close($curlObj);

        if (false !== $response) {
            $json = json_decode($response);

            if (isset($json->errorCode) and ($json->errorCode > 0)) {
                $errorMessage = '[TinyCC service] Message: ' . $json->errorMessage;
                throw new \Exception($errorMessage);
            } else {
                $this->shortUrl = $json->results->short_url;
            }
        } else {
            throw new \Exception(\JText::_('LIB_PRISM_ERROR_SHORT_URL_SERVICE_REQUEST'));
        }
    }

    /**
     * Get a short url from Goo.gl.
     *
     * @throws \Exception
     */
    protected function getGoogleURL()
    {
        $postData = array(
            'longUrl' => rawurldecode($this->url),
            'key'     => $this->apiKey
        );

        $jsonData = json_encode($postData);

        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);

        //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
        $response = curl_exec($curlObj);

        curl_close($curlObj);

        if (false !== $response) {
            $json = json_decode($response);

            if (isset($json->error) and count($json->error) > 0) {
                $errorMessage = '[Goo.gl service] Message: ' . $json->error->message . '; Location: ' . $json->error->errors[0]->location;
                throw new \Exception($errorMessage);
            } else {
                $this->shortUrl = $json->id;
            }
        } else {
            throw new \Exception(\JText::_('LIB_PRISM_ERROR_REDUCE_URL'));
        }
    }
}
