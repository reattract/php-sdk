<?php

namespace Reattract\Sdk;

class Configuration
{
    public static $publicKey = null;
    public static $secretKey = null;
    public static $webhookSecretKey = null;
    public static $apiVersion = '/v1';
    public static $apiHost = 'api.reattract.io';
    public static $useSsl = true;
    public static $port = null;

    public static function url()
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
