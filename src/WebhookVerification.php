<?php

namespace Reattract\Sdk;

use Reattract\Sdk\Configuration;
use Svix\Webhook;
use Svix\Exception\WebhookVerificationException;

class WebhookVerification
{
  public $payload;
  public $header;

  public function __construct($payload, $header)
  {
    $this->payload = $payload;
    $this->header = $header;
  }

  public function verify()
  {
    try
    {
      $wh = new Webhook($this->securityToken());
      $json = $wh->verify($this->payload, $this->header);
      return [
        'success' => true,
        'error' => null
      ];
    } 
    catch (WebhookVerificationException $e)
    {
      return [
        'success' => false,
        'error' => $e
      ];
    }
  }

  private function securityToken()
  {
    return Configuration::$webhookSecretKey;
  }
}
