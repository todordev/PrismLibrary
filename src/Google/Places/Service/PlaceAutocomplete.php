<?php
/**
 * @package      Prism\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Google\Places\Service;

use Prism\Google\Exception\ApiException;
use Prism\Google\Places\Client;
use Prism\Google\Places\Collection\Predictions;

/**
 * Google Place Autocomplete Service.
 *
 * @package     Prism\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/autocomplete
 */
class PlaceAutocomplete
{
    const SERVICE_URI = '/autocomplete';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Initialize the object.
     *
     * <code>
     * $key = "GOOGLE_API_KEY";
     * $options = new Registry([
     *     'output' => 'json' // xml or json
     * ]);
     *
     * $client = new Prism\Google\Places\Client($key, $options);
     * $service = new PlaceAutocomplete($client);
     * </code>
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client  = $client;
    }

    /**
     * Fetch data from Google Place Service.
     *
     * <code>
     * $key = "GOOGLE_API_KEY";
     * $options = new Registry([
     *     'output' => 'json' // xml or json
     * ]);
     *
     * $client  = new Prism\Google\Places\Client($key, $options);
     * $service = new Prism\Google\Places\Service\PlaceAutocomplete($client);
     *
     * $params   = [
     *    'types' => '(cities)'
     * ];
     *
     * $response = $service->fetch('Plovdiv', $params);
     * </code>
     *
     * @param string $input
     * @param array $params
     *
     * @return Predictions
     * @throws ApiException
     */
    public function fetch(string $input, array $params = []): Predictions
    {
        $params['input'] = $input;

        $response = $this->client->makeRequest(self::SERVICE_URI, $params);

        $predictions = new Predictions();
        if (array_key_exists('predictions', $response)) {
            $predictions->hydrate($response['predictions']);
        }

        return $predictions;
    }
}
