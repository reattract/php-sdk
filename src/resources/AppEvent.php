<?php

namespace Reattract\Reattract\Resources;

use Reattract\Reattract\Request;

class AppEvent 
{
  public static function create($eventName, $userId, $payload = null) 
  {
    $json = [
      'payload' => $payload,
      'event_name' => $eventName,
      'organization_user_id' => $userId
    ];
    return self::request()->post($json);
  }

  private static function request()
  {
    return new Request('/customer_events');
  }
}

