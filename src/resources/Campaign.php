<?php

namespace Reattract\Reattract\Resources;

use Reattract\Reattract\Request;

class Customer 
{
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
    return new Request('/campaigns');
  }
}