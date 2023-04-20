<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;
use Reattract\Sdk\PaginatedResponse;

class InviteCode
{
    public static function create(string $userId, string|null $campaignId = null): PaginatedResponse
    {
        $json = [
          'organization_user_id' => $userId,
          'campaign_id' => $campaignId
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
        return new Request('/invite_codes');
    }
}
