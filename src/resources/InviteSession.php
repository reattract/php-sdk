<?php

namespace Reattract\Reattract\Resources;

use Reattract\Reattract\Request;

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
