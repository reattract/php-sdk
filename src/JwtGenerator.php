<?php

namespace Reattract\Sdk;

use Reattract\Sdk\Configuration;

use Firebase\JWT\JWT;

class JwtGenerator
{
  public $expiredAt;
  public $scopes;

  public function __construct($expiredAt = null, $scopes = [])
  {
    if ($expiredAt === null) {
        $expiredAt = $this->getDefaultExpiredAt();
    }
      $this->expiredAt = $expiredAt;
      $this->scopes = implode(',', $scopes);
  }

  public function generate()
  {
    return JWT::encode($this->payload(), $this->key(), 'HS256');
  }

  private function payload() 
  {
    $jwtCreatedAt = new \DateTime();

    return [
      'exp' => $this->expiredAt->getTimestamp(),
      'nbf' => $jwtCreatedAt->getTimestamp(),
      'iss' => Configuration::$publicKey,
      'iat' =>  $jwtCreatedAt->getTimestamp()
    ];
  }
  
  private function key() 
  {
    return Configuration::$secretKey;
  }

  private function getDefaultExpiredAt() 
  {
    $currentDateTime = new \DateTime();
    // Add one week to the DateTime object
    $currentDateTime->add(new \DateInterval('P1W'));

    return $currentDateTime;
  }
}
