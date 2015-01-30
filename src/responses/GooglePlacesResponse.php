<?php namespace Bendia\API\Clients\Responses;

/**
 * Created by PhpStorm.
 * User: bendia
 * Date: 1/24/15
 * Time: 5:31 PM
 */
class GooglePlacesResponse
{
    /** @var array */
    protected $html_attributions;

    /** @var string Response Status */
    protected $status;

    /**
     * @param $array
     */
    protected function __construct($array)
    {
        foreach ($array as $key => $value)
        {
            $this->$key = $value;
        }
    }

    /**
     * @param array $array Google Places API Response.
     * @return static Response as an object.
     */
    public static function fromArray($array)
    {
        return new static($array);
    }

    /**
     * @return array HTML Attributions
     */
    public function getHtmlAttributions()
    {
        return $this->html_attributions;
    }

    /**
     * @return string Response status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Check current status against the parameter.
     *
     * @param $status
     * @return bool Flag indicating if the current status is equal do the parameter.
     */
    public function isStatus($status)
    {
        return $this->status == $status;
    }

    /**
     * @return bool Flag indicating if the response status is equal to OK.
     */
    public function isOk()
    {
        return $this->isStatus('OK');
    }

    /**
     * @return bool Flag indicating if the response status is equal to ZERO_RESULTS.
     */
    public function isZeroResults()
    {
        return $this->isStatus('ZERO_RESULTS');
    }

    /**
     * @return bool Flag indicating if the response status is equal to OVER_QUERY_LIMIT.
     */
    public function isOverQueryLimit()
    {
        return $this->isStatus('OVER_QUERY_LIMIT');
    }

    /**
     * @return bool Flag indicating if the response status is equal to REQUEST_DENIED.
     */
    public function isRequestDenied()
    {
        return $this->isStatus('REQUEST_DENIED');
    }

    /**
     * @return bool Flag indicating if the response status is equal to INVALID_REQUEST.
     */
    public function isInvalidRequest()
    {
        return $this->isStatus('INVALID_REQUEST');
    }
}
