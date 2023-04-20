<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;

class InviteConversion
{
    public static function create($userId, $inviteCode = null, $inviteSessionId = null, $customer = [])
    {
        $json = [
          'organization_user_id' => $userId,
          'unique_code' => $inviteCode,
          'invite_session_id' => $inviteSessionId,
          'organization_customer' => $customer
        ];
        return self::collectionRequest()->post($json);
    }

    public static function list($limit = 20, $page = 1, $order = ['id desc'])
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

    private static function collectionRequest()
    {
        return new Request('/invite_conversions');
    }
}
