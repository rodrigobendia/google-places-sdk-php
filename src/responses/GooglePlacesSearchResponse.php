<?php namespace Bendia\API\Clients\Responses;

/**
 * Created by PhpStorm.
 * User: bendia
 * Date: 1/24/15
 * Time: 5:00 PM
 */
class GooglePlacesSearchResponse extends GooglePlacesResponse
{
    /** @var array Search Results */
    protected $results;

    /** @var string Next page token */
    protected $next_page_token;

    /**
     * @return int Number of matching results.
     */
    public function countResults()
    {
        return count($this->results);
    }

    /**
     * @param $index
     * @return object
     */
    public function getResult($index)
    {
        return (object)$this->results[$index];
    }

    /**
     * @return array Next page token
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }
}
