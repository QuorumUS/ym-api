# ym-api

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phone2action/ym-api/badges/quality-score.png?b=dev-master)](https://scrutinizer-ci.com/g/phone2action/ym-api/?branch=dev-master) [![Build Status](https://scrutinizer-ci.com/g/phone2action/ym-api/badges/build.png?b=dev-master)](https://scrutinizer-ci.com/g/phone2action/ym-api/build-status/dev-master) [![Code Coverage](https://scrutinizer-ci.com/g/phone2action/ym-api/badges/coverage.png?b=dev-master)](https://scrutinizer-ci.com/g/phone2action/ym-api/?branch=dev-master)

Your Membership API Client for PHP

Work In Progress


YourMembershipClient Usage

```$client = new P2A\YourMembership\YourMembershipClient($apiKey, $saPasscode)```


```
$response = $client->makeCall('Session.Create')->toArray();
echo $response['SessionID'];
 ```