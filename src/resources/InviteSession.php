<?php

namespace Reattract\Sdk\Resources;

use Reattract\Sdk\Request;

class InviteSession 
{
  public static function get($userId) 
  {
    return self::memberRequest($userId)->get();
  }

  private static function memberRequest($userId)
  {
    return new Request('/invite_sessions/' . $userId);
  }
}
