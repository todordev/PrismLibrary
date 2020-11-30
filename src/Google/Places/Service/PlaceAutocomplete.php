<?php
/**
 * @package      Prism\Library\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Google\Places\Service;

use Prism\Library\Google\Exception\ApiException;
use Prism\Library\Google\Places\Client;
use Prism\Library\Google\Places\Collection\Predictions;

/**
 * Google Place Autocomplete Service.
 *
 * @package     Prism\Library\Google
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
     * $client = new Prism\Library\Google\Places\Client($key, $options);
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
     * $client  = new Prism\Library\Google\Places\Client($key, $options);
     * $service = new Prism\Library\Google\Places\Service\PlaceAutocomplete($client);
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
