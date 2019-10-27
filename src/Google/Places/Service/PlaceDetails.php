<?php
/**
 * @package      Prism\Library\Google
 * @subpackage   Places
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Google\Places\Service;

use Prism\Library\Google\Places\Place;
use Prism\Library\Google\Places\Client;
use Prism\Library\Google\Exception\ApiException;

/**
 * Google Place Details Service.
 *
 * @package     Prism\Library\Google
 * @subpackage  Places
 *
 * @link https://developers.google.com/places/web-service/autocomplete
 */
class PlaceDetails
{
    const SERVICE_URI = '/details';

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
     * $client  = new Prism\Library\Google\Places\Client($key, $options);
     * $service = new PlaceDetails($client);
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
     * $service = new Prism\Library\Google\Places\Service\PlaceDetails($client);
     *
     * $params   = [
     *    'language' => 'en'
     * ];
     *
     * $response = $service->fetch($placeId, $params);
     * </code>
     *
     * @param string $placeId
     * @param array $params
     *
     * @return Place
     * @throws ApiException
     */
    public function fetch(string $placeId, array $params = []): Place
    {
        $params['place_id'] = $placeId;

        $response = $this->client->makeRequest(self::SERVICE_URI, $params);

        $place = new Place();
        if (array_key_exists('result', $response)) {
            $place->bind($response['result']);
        }

        return $place;
    }
}
