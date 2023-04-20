<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;
use Reattract\Sdk\PaginatedResponse;

class InviteSession
{
    public static function get(string $userId): PaginatedResponse
    {
        return self::memberRequest($userId)->get();
    }

    private static function memberRequest(string $userId): Request
    {
        return new Request('/invite_sessions/' . $userId);
    }
}
