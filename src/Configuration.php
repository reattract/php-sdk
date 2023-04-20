<?php

namespace Reattract\Sdk;

class Configuration
{
    public static string $publicKey = '';
    public static string $secretKey = '';
    public static string $webhookSecretKey = '';
    public static string $apiVersion = '/v1';
    public static string $apiHost = 'api.reattract.io';
    public static bool $useSsl = true;
    public static int|null $port = null;

    public static function url(): string
    {
        $scheme = (self::$useSsl) ? 'https://' : 'http://';

        $url = $scheme . self::$apiHost;

        if (self::$port != null) {
            $url .= ':' . self::$port;
        }

        $url .= self::$apiVersion;

        return $url;
    }
}
