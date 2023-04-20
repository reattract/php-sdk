<?php

namespace Reattract\Sdk;

use Reattract\Sdk\Configuration;

use Firebase\JWT\JWT;

class JwtGenerator
{
    public \DateTime $expiredAt;
    public string $scopes;

    /**
     * @param string[] $scopes
     */
    public function __construct(\DateTime $expiredAt = null, array $scopes = [])
    {
        if ($expiredAt === null) {
            $expiredAt = $this->getDefaultExpiredAt();
        }
        $this->expiredAt = $expiredAt;
        $this->scopes = implode(',', $scopes);
    }

    public function generate(): string
    {
        return JWT::encode($this->payload(), $this->key(), 'HS256');
    }

    /**
     * @return array{'exp': int, 'nbf': int, 'iss': string, 'iat': int}
     */
    private function payload(): array
    {
        $jwtCreatedAt = new \DateTime();

        return [
          'exp' => $this->expiredAt->getTimestamp(),
          'nbf' => $jwtCreatedAt->getTimestamp(),
          'iss' => Configuration::$publicKey,
          'iat' =>  $jwtCreatedAt->getTimestamp()
        ];
    }

    private function key(): string
    {
        return Configuration::$secretKey;
    }

    private function getDefaultExpiredAt(): \DateTime
    {
        $currentDateTime = new \DateTime();
        // Add one week to the DateTime object
        $currentDateTime->add(new \DateInterval('P1W'));

        return $currentDateTime;
    }
}
