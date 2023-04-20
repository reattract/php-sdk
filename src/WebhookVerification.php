<?php

namespace Reattract\Sdk;

use Reattract\Sdk\Configuration;
use Svix\Webhook;
use Svix\Exception\WebhookVerificationException;

class WebhookVerification
{
    public string $payload;
    /**
     * @var mixed[]
     */
    public array $header;

    /**
     * @param array<string, string> $header
     */
    public function __construct(string $payload, array $header)
    {
        $this->payload = $payload;
        $this->header = $header;
    }

    /**
     * @return array{'success': bool, 'error': null|WebhookVerificationException}
     */
    public function verify(): array
    {
        try {
            $wh = new Webhook($this->securityToken());
            $json = $wh->verify($this->payload, $this->header);
            return [
              'success' => true,
              'error' => null
            ];
        } catch (WebhookVerificationException $e) {
            return [
              'success' => false,
              'error' => $e
            ];
        }
    }

    private function securityToken(): string
    {
        return Configuration::$webhookSecretKey;
    }
}
