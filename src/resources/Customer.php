<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;
use Reattract\Sdk\PaginatedResponse;

class Customer
{
    /**
     * @param array{first_name?: string, last_name?: string, email?: string} $customerData
     */
    public static function create(string $userId, array $customerData = []): PaginatedResponse
    {
        $customerData['organization_user_id'] = $userId;
        return self::collectionRequest()->post($customerData);
    }

    /**
     * @param array{first_name?: string, last_name?: string, email?: string} $customerData
     */
    public static function update(string $userId, array $customerData = []): PaginatedResponse
    {
        return self::memberRequest($userId)->patch($customerData);
    }

    public static function get(string $userId): PaginatedResponse
    {
        return self::memberRequest($userId)->get();
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
        return new Request('/organization_customers');
    }

    private static function memberRequest(string $userId): Request
    {
        return new Request('/organization_customers/' . $userId);
    }
}
