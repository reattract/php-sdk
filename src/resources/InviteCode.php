<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;

class InviteCode 
{
  public static function create($userId, $campaignId = null) 
  {
    $json = [
      'organization_user_id' => $userId,
      'campaign_id' => $campaignId
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
    return new Request('/invite_codes');
  }
}
