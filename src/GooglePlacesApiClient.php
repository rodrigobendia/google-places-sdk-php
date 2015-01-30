<?php namespace Bendia\API\Clients;

use Bendia\API\Clients\Responses\GooglePlacesDetailsResponse;
use Bendia\API\Clients\Responses\GooglePlacesSearchResponse;
use GuzzleHttp;

/**
 * Created by PhpStorm.
 * User: bendia
 * Date: 1/22/15
 * Time: 10:11 PM
 */
final class GooglePlacesApiClient
{
    //<editor-fold desc="Fields">
    /** @var GooglePlacesApiClient */
    private static $instance = null;

    /** @var GuzzleHttp\Client $client HTTP Client. */
    private $client;

    /** @var string Base URL. */
    private $baseUrl = 'https://maps.googleapis.com/maps/api/place';

    /** @var string|null API key. */
    private $key = null;

    /** @var bool Flag indicating if the responses should be auto parsed or returned as arrays. */
    private $parse = true;

    /** @var GuzzleHttp\Message\Request|GuzzleHttp\Message\RequestInterface Last search request. */
    private $lastSearchRequest = null;

    /** @var array|null Last search response. */
    private $lastSearchResponse = null;

    //</editor-fold>

    //<editor-fold desc="Constructor">
    /**
     * Creates the HTTP client.
     *
     * @param string $key API key.
     * @param bool $parse Flag indicating if the responses should be auto parsed or returned as arrays.
     */
    private function __construct($key = null, $parse = true)
    {
        $this->client = new GuzzleHttp\Client();
        $this->key = $key;
        $this->parse = $parse;
    }
    //</editor-fold>

    //<editor-fold desc="Common">
    /**
     * Singleton.
     *
     * @param string $key
     * @return GooglePlacesApiClient Google Places API client instance.
     */
    public static function instance($key = null)
    {
        if (static::$instance == null)
        {
            static::$instance = new GooglePlacesApiClient($key);
        }

        return static::$instance;
    }

    /**
     * Creates a request with the specified parameters.
     *
     * @param string $method
     * @param string $urlPath
     * @return GuzzleHttp\Message\Request|GuzzleHttp\Message\RequestInterface
     */
    private function getRequest($method = 'GET', $urlPath = '/')
    {
        $request = $this->client->createRequest($method, $this->baseUrl . $urlPath . '/json');

        $request->getQuery()->set('key', $this->key);

        return $request;
    }

    /**
     * Sends the request and returns the response.
     *
     * @param GuzzleHttp\Message\Request|GuzzleHttp\Message\RequestInterface $request
     * @return mixed
     */
    private function getResponse($request)
    {
        $this->lastSearchRequest = $request;

        $this->lastSearchResponse = $this->client
            ->send($request)
            ->json();

        return $this->lastSearchResponse;
    }
    //</editor-fold>

    //<editor-fold desc="Utilities">
    /**
     * @return array|null Last cached response.
     */
    public function getLastSearchResponse()
    {
        return $this->lastSearchResponse;
    }

    /**
     * @return mixed Next page from the previous search.
     */
    public function next()
    {
        if (isset($this->lastSearchResponse['next_page_token']))
        {
            $request = $this->lastSearchRequest;

            $this->lastSearchRequest->getQuery()->set('pagetoken', $this->lastSearchResponse['next_page_token']);

            $response = $this->getResponse($request);

            return $this->parse ? GooglePlacesSearchResponse::fromArray($response) : $response;
        }

        return null;
    }
    //</editor-fold>

    //<editor-fold desc="Description">
    /**
     * Search for nearby places.
     *
     * @param array $location Center location: [<latitude>, <longitude>]
     * @param int $radius Search radius.
     * @param bool $sensor
     * @param string|null $keyword
     * @param string|null $language
     * @param string|null $name
     * @param string|null $rankBy
     * @param array|null $types
     * @param string|null $pageToken
     * @return mixed
     */
    public function search($location, $radius, $sensor, $keyword = null, $language = null, $name = null, $rankBy = null, array $types = null, $pageToken = null)
    {
        $request = $this->getRequest('GET', '/search');

        $query = $request->getQuery();

        // Mandatory parameters
        if (isset($location)) $query->set('location', implode(',', $location));
        if (isset($radius)) $query->set('radius', $radius);
        if (isset($sensor)) $query->set('sensor', $sensor ? 'true' : 'false');

        // Optional parameters
        if (isset($keyword)) $query->set('keyword', $keyword);
        if (isset($language)) $query->set('language', $language);
        if (isset($name)) $query->set('name', $name);
        if (isset($rankBy)) $query->set('rankby', $rankBy);
        if (isset($types)) $query->set('types', implode('|', $types));
        if (isset($pageToken)) $query->set('pagetoken', $pageToken);

        $response = $this->getResponse($request);

        return $this->parse ? GooglePlacesSearchResponse::fromArray($response) : $response;
    }

    /**
     * Text search.
     *
     * @param string $searchQuery Search query
     * @param bool $sensor
     * @param array|null $location Center location: [<latitude>, <longitude>]
     * @param int|null $radius Search radius.
     * @param string|null $language
     * @param array|null $types
     * @return mixed
     */
    public function searchText($searchQuery, $sensor, array $location = null, $radius = null, $language = null, array $types = null)
    {
        $request = $this->getRequest('GET', '/textsearch');

        $query = $request->getQuery();

        // Mandatory parameters
        $query->set('query', $searchQuery);
        $query->set('sensor', $sensor ? 'true' : 'false');

        // Optional parameters
        if (isset($location)) $query->set('location', implode(',', $location));
        if (isset($radius)) $query->set('radius', $radius);
        if (isset($language)) $query->set('language', $language);
        if (isset($types)) $query->set('types', implode('|', $types));

        $response = $this->getResponse($request);

        return $this->parse ? GooglePlacesSearchResponse::fromArray($response) : $response;
    }

    /**
     * Place details.
     *
     * @param string $placeId Place unique ID (preferrable). If place ID is set, the reference parameter is ignored.
     * @param string $reference Place reference (will be deprecated).
     * @param bool $sensor
     * @param string $language
     * @return mixed
     */
    public function getDetails($placeId, $reference, $sensor, $language = null)
    {
        $request = $this->getRequest('GET', '/details');

        $query = $request->getQuery();

        // Mandatory parameters
        if ($placeId)
        {
            $query->set('placeid', $placeId);
        } else
        {
            $query->set('reference', $reference);
        }

        $query->set('sensor', $sensor ? 'true' : 'false');

        // Optional parameters
        if (isset($language)) $query->set('language', $language);

        $response = $this->getResponse($request);

        return $this->parse ? GooglePlacesDetailsResponse::fromArray($response) : $response;
    }
    //</editor-fold>
}
