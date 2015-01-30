<?php namespace Bendia\API\Clients\Responses;

/**
 * Created by PhpStorm.
 * User: bendia
 * Date: 1/24/15
 * Time: 5:11 PM
 */
class GooglePlacesDetailsResponse extends GooglePlacesResponse
{
    /** @var array Search Results */
    protected $result;

    /**
     * @return object Place Details Search Result
     */
    public function getResult()
    {
        return (object)$this->result;
    }

    /**
     * @return bool Flag indicating if the response status is equal to UNKNOWN_ERROR.
     */
    public function isUnknownError()
    {
        return $this->isStatus('UNKNOWN_ERROR');
    }

    /**
     * @return bool Flag indicating if the response status is equal to NOT_FOUND.
     */
    public function isNotFound()
    {
        return $this->isStatus('NOT_FOUND');
    }
}
