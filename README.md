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
$placesSearch = GooglePlacesApiClient::instance()->search($location, $radius, $sensor);

// Check response status
if ($placesSearch->isOk())
{
    for ($i = 0; $i < $placesSearch->countResults(); $i++)
    {
      echo $places->getResult($index)->name;
      echo $places->getResult($index)->formatted_address;
    }
}
else
{
    echo $placesSearch->getStatus();
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
$placesSearch = GooglePlacesApiClient::instance()->searchText($query, $sensor);

// Check response status
if ($placesSearch->isOk())
{
    for ($i = 0; $i < $placesSearch->countResults(); $i++)
    {
      echo $places->getResult($index)->name;
      echo $places->getResult($index)->formatted_address;
    }
}
else
{
    echo $placesSearch->getStatus();
}
```
