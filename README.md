nexmo-client [![Build Status](https://travis-ci.org/ConnectCorp/nexmo-client.svg?branch=master)](https://travis-ci.org/ConnectCorp/nexmo-client) [![Code Climate](https://codeclimate.com/github/ConnectCorp/nexmo-client/badges/gpa.svg)](https://codeclimate.com/github/ConnectCorp/nexmo-client)
============
Unofficial [Nexmo](https://www.nexmo.com/) Rest Client 
## Documentation
[Nexmo API Documentation](https://docs.nexmo.com/) 
## How to Install
```composer require connect-corp/nexmo-client```

## Usage examples

### Setting up the client object

    $nexmo_client_options = array(
        'apiKey' => '…',
        'apiSecret' => '…',
        'debug' => false,
        'timeout' => 5.0,
    );
    $nexmo = new \Nexmo\Client($nexmo_client_options);

### Sending a message

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

### Getting account balance

	try {
	    $response = $nexmo->account->balance();
	} catch (Exception $e) {
        die($e->getMessage());
	}
	echo "Account balance is $response";

### Getting pricing by destination country

	$country = 'US';
	try {
        $response = $nexmo->account->pricing->country($country);
	} catch (Exception $e) {
        die($e->getMessage());
	}
	echo 'Price is ' . $response->price();

### Getting pricing by recipient number

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


### Search for long virtual numbers by country

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

### Buy a long virtual number

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

### List long virtual numbers in your account

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

### Cancel a long virtual number

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

## Contributors
- @CarsonF
- @com

