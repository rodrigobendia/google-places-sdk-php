# Google Places SDK for PHP

The Google Places SDK for PHP enables developers to use the Google Places API in their PHP code. This library is based on Guzzle HTTP Client.

## Installation

Add the following to your composer.json file:

```json
{
    "require": {
      "rodrigobendia/google-places-sdk-php": "dev-master"
    }
}
```

## Usage

### Initialization

```php
<?php

use Bendia\API\Clients\GooglePlacesApiClient;

$apiKey = 'YOUR_API_KEY';

// Initialize the instance with yout API key
GooglePlacesApiClient::instance($apiKey);
```

### Places Search

```php
<?php

use Bendia\API\Clients\GooglePlacesApiClient;
use Bendia\API\Clients\GooglePlacesSearchResponse;

$location = [37.424307, -122.09502299999997];
$radius = 1000;
$sensor = false;

// Assuming that the singleton has been initialized with the API key before
$response = GooglePlacesApiClient::instance()->search($location, $radius, $sensor);

// Check response status
if ($response->isOk())
{
    for ($i = 0; $i < $response->countResults(); $i++)
    {
        $place = $response->getResult($index);
        
        echo $place->name;
        echo $place->formatted_address;
    }
}
else
{
    echo $response->getStatus();
}
```

### Text Search

```php
<?php

use Bendia\API\Clients\GooglePlacesApiClient;
use Bendia\API\Clients\GooglePlacesSearchResponse;

$query = 'Google Mountain View';
$sensor = false;

// Assuming that the singleton has been initialized with the API key before
$response = GooglePlacesApiClient::instance()->searchText($query, $sensor);

// Check response status
if ($response->isOk())
{
    for ($i = 0; $i < $response->countResults(); $i++)
    {
        $place = $response->getResult($index);
        
        echo $place->name;
        echo $place->formatted_address;
    }
}
else
{
    echo $response->getStatus();
}
```

### Place Details

```php
<?php

use Bendia\API\Clients\GooglePlacesApiClient;
use Bendia\API\Clients\GooglePlacesDetailsResponse;

$placeId = 'ChIJYVBMERu6j4ARH8TCQcqmK6M';
$reference = null;
$sensor = false;

// Assuming that the singleton has been initialized with the API key before
$response = GooglePlacesApiClient::instance()->getDetails($placeId, $reference, $sensor);

// Check response status
if ($response->isOk())
{
    $place = $response->getResult();

    echo $place->name;
    echo $place->formatted_address;
}
else
{
    echo $response->getStatus();
}
```
