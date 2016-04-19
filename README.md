nexmo-client [![Build Status](https://travis-ci.org/ConnectCorp/nexmo-client.svg?branch=master)](https://travis-ci.org/ConnectCorp/nexmo-client) [![Code Climate](https://codeclimate.com/github/ConnectCorp/nexmo-client/badges/gpa.svg)](https://codeclimate.com/github/ConnectCorp/nexmo-client)
============
Unofficial [Nexmo](https://www.nexmo.com/) Rest Client 
## Documentation
[Nexmo API Documentation](https://docs.nexmo.com/) 
## How to Install
```bash
$ composer require connect-corp/nexmo-client
```

## Usage examples

### Setting up the client object

```php
    $apiKey = 'api_key_from_nexmo_account';
    $apiSecret = 'api_secret_from_nexmo_account';
    $nexmo = new \Nexmo\Client($apiKey, $apiSecret);
```
    
### Sending a message
```php
	$from = '1234567890';
	$to = '15551232020';
	$text = 'hello world';
    try {
        $response = $nexmo->message->invoke($from, $to, 'text', $text);
    } catch (Exception $e) {
        die($e->getMessage());
    }
    foreach ($response['messages'] as $i => $m) {
        switch ($m['status']) {
        case '0':
            echo 'Message sent successfully:';
			print_r($m);
            break;

        default:
            echo 'Message sending failed:'
			print_r($m);
            break;
        }
    }
```
### Getting account balance
```php
	try {
	    $response = $nexmo->account->balance();
	} catch (Exception $e) {
        die($e->getMessage());
	}
	echo "Account balance is $response";
```
### Getting pricing by destination country
```php
	$country = 'US';
	try {
        $response = $nexmo->account->pricing->country($country);
	} catch (Exception $e) {
        die($e->getMessage());
	}
	echo 'Price is ' . $response->price();
```
### Getting pricing by recipient number
```php
	$number = '15551232020';
	try {
		// SMS pricing.
        $response = $nexmo->account->pricing->sms($number);
		// Voice pricing.
        $response = $nexmo->account->pricing->voice($number);
	} catch (Exception $e) {
        die($e->getMessage());
	}
	echo 'Price is ' . $response->price();
```
### Search for long virtual numbers by country
```php
	$country = 'US';
	try {
        $response = $nexmo->number->search($country);
	} catch (Exception $e) {
        die($e->getMessage());
	}
    $all = $response->all();
	if (isset($all['numbers'])) {
		foreach	($all['numbers'] as $n) {
            printf("%d  \$%01.2f  %-10s  %-15s\n", $n['msisdn'], $n['cost'], $n['type'], join(',', $n['features']));
		}
	}
```
### Buy a long virtual number
```php
	$country = 'US';
	$msisdn = '1234567890'; // Number found using $nexmo->number->search()
	try {
        $response = $nexmo->number->buy($country, $msisdn);
	} catch (Exception $e) {
        die($e->getMessage());
	}
	if (200 == $response['error-code']) {
		echo 'Number purchase success';
	}
```
### List long virtual numbers in your account
```php
	$country = 'US';
	try {
        $response = $nexmo->account->numbers();
	} catch (Exception $e) {
        die($e->getMessage());
	}
    $all = $response->all();
	if (isset($all['numbers'])) {
		foreach	($all['numbers'] as $n) {
            printf("%d  %-2s  %-10s  %-15s\n", $n['msisdn'], $n['country'], $n['type'], join(',', $n['features']));
		}
	}
```
### Cancel a long virtual number
```php
	$country = 'US';
	$msisdn = '1234567890'; // Number found using $nexmo->account->numbers()
	try {
        $response = $nexmo->number->cancel($country, $msisdn);
	} catch (Exception $e) {
        die($e->getMessage());
	}
	if (200 == $response['error-code']) {
		echo 'Number cancel success';
	}
```
## Contributors
https://github.com/ConnectCorp/nexmo-client/network/members
