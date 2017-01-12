# ym-api

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phone2action/ym-api/badges/quality-score.png?b=dev-master)](https://scrutinizer-ci.com/g/phone2action/ym-api/?branch=dev-master) [![Build Status](https://scrutinizer-ci.com/g/phone2action/ym-api/badges/build.png?b=dev-master)](https://scrutinizer-ci.com/g/phone2action/ym-api/build-status/dev-master) [![Code Coverage](https://scrutinizer-ci.com/g/phone2action/ym-api/badges/coverage.png?b=dev-master)](https://scrutinizer-ci.com/g/phone2action/ym-api/?branch=dev-master)

# Your Membership API Client for PHP
### This package in a work in progress, we currently use this package for development of an integration with YourMembership.

This package implements a PHP wrapper to work with http://www.yourmembership.com/company/api-reference/


### Laravel Installation (5.1+)

No Support for Versions below 5.1 (5.0 Untested)

Require this package with composer by adding the following to your composer file:

```json
{
require: {
"phone2action/ym-api": "dev-master"
},
"repositories": [

        {
            "type": "vcs",
            "url": "https://github.com/phone2action/ym-api"
        }
    ],
}
```
After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
P2A\YourMembership\YourMembershipServiceProvider::class,
```

You can publish the config file for this package
```bash
php artisan vendor:publish --provider="P2A\YourMembership\YourMembershipServiceProvider"
```




### Usage

#### Laravel
```php
$client = app(P2A\YourMembership\YourMembershipClient::class,[$apiKey,$saPasscode]);
```

#### Other
Instantiate the client

```
$guzzleClient = new \GuzzleHttp\Client();
$client = new P2A\YourMembership\YourMembershipClient($guzzleClient, $apiKey, $saPasscode)
```

Make API calls using this client

```php
$response = $client->makeCall('Session.Create')->toArray();
echo $response['SessionID'];

$response = $client->makeCall('Session.Create')->toObject();
echo $response['SessionID'];
```
