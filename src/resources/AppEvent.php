<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;
use Reattract\Sdk\PaginatedResponse;

class AppEvent
{
    /**
     * @param mixed $payload
     */
    public static function create(string $eventName, string $userId, mixed $payload = null): PaginatedResponse
    {
        $json = [
          'payload' => $payload,
          'event_name' => $eventName,
          'organization_user_id' => $userId
        ];
        return self::request()->post($json);
    }

    private static function request(): Request
    {
        return new Request('/customer_events');
    }
}
