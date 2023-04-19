Reattract PHP SDK
-----------------

# Example integration

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
