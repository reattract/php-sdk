<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;
use Reattract\Sdk\PaginatedResponse;

class InviteConversion
{
    /**
     * @param array<string, mixed> $customer
     */
    public static function create(string $userId, string|null $inviteCode = null, string|null $inviteSessionId = null, array $customer = []): PaginatedResponse
    {
        $json = [
          'organization_user_id' => $userId,
          'unique_code' => $inviteCode,
          'invite_session_id' => $inviteSessionId,
          'organization_customer' => $customer
        ];
        return self::collectionRequest()->post($json);
    }

    /**
     * @param array<string> $order
     */
    public static function list(int $limit = 20, int $page = 1, array $order = ['id desc']): PaginatedResponse
    {
        return self::collectionRequest()->get(
            [
            'sort' => $order,
            'pagination' => [
              'limit' => $limit,
              'page' => $page
            ]
      ]
        );
    }

    private static function collectionRequest(): Request
    {
        return new Request('/invite_conversions');
    }
}
