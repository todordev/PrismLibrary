<?php
/**
 * @package      Prism\Library\Prism\Google
 * @subpackage   Places
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Google\Places\Service;

use Prism\Library\Prism\Google\Places\Place;
use Prism\Library\Prism\Google\Places\Client;
use Prism\Library\Prism\Google\Exception\ApiException;

/**
 * Google Place Details Service.
 *
 * @package     Prism\Library\Prism\Google
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
     * $client  = new Prism\Library\Prism\Google\Places\Client($key, $options);
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
     * $client  = new Prism\Library\Prism\Google\Places\Client($key, $options);
     * $service = new Prism\Library\Prism\Google\Places\Service\PlaceDetails($client);
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
