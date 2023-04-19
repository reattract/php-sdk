Reattract PHP SDK
-----------------

## Example integration

### Making calls

```php
<?php
// YourModule.php

require('vendor/autoload.php');

use Reattract\Reattract\Configuration;
use Reattract\Reattract\Resources\Customer;

// Configuration values are static and can be part of your application initializtion.
Configuration::$secretKey = '<secret_key>;
Configuration::$publicKey = '<public_key>';

// Resources, which map to http endpoints, can all be found in the resources folder.
// Fetch a paginated list of customers
$response = Customer::list();
print_r($response['body']);

// List call responses will be paginated and you can see the pagination data as follows
print_r($response['pagination']);

```

### Verfiying Webhooks
```php
// Verify webhooks

use Reattract\Reattract\Configuration;
use Reattract\Reattract\WebhookVerification;

Configuration::$webhookSecretKey = 'whsec_MfKQ9r8GKYqrTwjUPD8ILPZIo2LaLaSw';

// Example payload and headers
// The payload should be a raw payload
$payload = '{"test": 2432232314}';
$header = array(
        'svix-id'  => 'msg_p5jXN8AQM9LWM0D4loKWxJek',
        'svix-timestamp' => '1614265330',
        'svix-signature' => 'v1,g0hM9SsE+OTPJTGt/tmIKtSyZlE3uFJELVlNIOLJ1OE=',
        );

// Throws on error, returns the verified content on success
$wh = new WebhookVerification($payload, $header);
$result = $wh->verify();
// $result will be an associative array with the success status and the error [if present]
// [
//   'success' => false,
//   'error' => <error object>
// ];
```
