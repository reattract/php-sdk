<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;

class Customer 
{
  public static function create($userId, $json = []) 
  {
    $json['organization_user_id'] = $userId;
    return self::collectionRequest()->post($json);
  }
  
  public static function update($userId, $json = []) 
  {
    return self::memberRequest($userId)->patch($json);
  }

  public static function get($userId) 
  {
    return self::memberRequest($userId)->get();
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
    return new Request('/organization_customers');
  }

  private static function memberRequest($userId)
  {
    return new Request('/organization_customers/' . $userId);
  }
}
