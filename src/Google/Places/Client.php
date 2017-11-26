<?php
/**
 * @package      Prism\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Google\Places;

use Joomla\Registry\Registry;
use GuzzleHttp\Client as GuzzleClient;
use Prism\Google\Exception\ApiException;

/**
 * Client that makes request to Google Places API.
 *
 * @package     Prism\Google
 * @subpackage  Places
 */
class Client
{
    protected $api_key;
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/place';

    protected $status;
    protected $error;

    protected $options;

    protected $httpClient;

    /**
     * Initialize the object.
     *
     * <code>
     * $key = "GOOGLE_API_KEY";
     * $options = new Registry([
     *     'output' => 'json' // xml or json
     * ]);
     *
     * $ipn = new Prism\Google\Places\Client($key, $data);
     * </code>
     *
     * @param string $key
     * @param Registry $options
     */
    public function __construct($key, Registry $options)
    {
        $this->api_key  = $key;
        $this->options  = $options ?? new Registry();

        // Set output type.
        if (!in_array($this->options->get('output'), ['json', 'xml'], true)) {
            $this->options->set('output', 'json');
        }

        // Set request type.
        if (!in_array($this->options->get('method'), ['get', 'post'], true)) {
            $this->options->set('method', 'get');
        }
            
        $this->httpClient = new GuzzleClient([
            'base_uri' => $this->baseUrl
        ]);
    }

    /**
     * @param $uri
     * @param $params
     *
     * @return array
     * @throws ApiException
     */
    public function makeRequest($uri, $params): array
    {
        $method = $this->options->get('method', 'get');
        $output = $this->options->get('output', 'json');

        $options = [
            'query' => [
                'key' => $this->api_key,
            ],
        ];
        
        if (strcmp($method, 'post') === 0) {
            $options = array_merge(['body' => json_encode($params)], $options);
        } else { // Method GET
            $options['query'] = array_merge($options['query'], $params);
        }

        $url      = $this->baseUrl.$uri.'/'.$output;
        $response = $this->httpClient->$method($url, $options)->getBody()->getContents();

        $data = array();
        if ($this->isResponseJson()) {
            $data = $this->parseJson($response);
        } elseif ($this->isResponseXml()) {
            $data = $this->parseXml($response);
        }

        if (array_key_exists('status', $data)) {
            $this->status = $data['status'];
        }

        if (array_key_exists('error_message', $data)) {
            $this->error = $data['error_message'];
        }

        if (!in_array($this->status, ['OK', 'ZERO_RESULTS'], true)) {
            throw new ApiException(
                'Response returned with status: ' . $this->status . "\n" .
                'Error Message: {'. $this->error .'}'
            );
        }

        return $data;
    }

    /**
     * Check if response output is JSON.
     *
     * @return bool
     */
    public function isResponseJson(): bool
    {
        return (strcmp('json', $this->options->get('output')) === 0);
    }

    /**
     * Check if response output is XML.
     *
     * @return bool
     */
    public function isResponseXml(): bool
    {
        return (strcmp('xml', $this->options->get('output')) === 0);
    }

    /**
     * Parse JSON response.
     *
     * @param string $response
     *
     * @return array
     */
    protected function parseJson(string $response): array
    {
        $data = json_decode($response, true);
        if (!is_array($data)) {
            $data = array();
        }

        return $data;
    }

    /**
     * Parse XML response.
     *
     * @param string $response
     *
     * @return array
     */
    protected function parseXml(string $response): array
    {
        $data = json_decode($response, true);
        if (!is_array($data)) {
            $data = array();
        }

        return $data;
    }
}
