<?php

namespace App\Lib\JWT;

use Firebase\JWT\JWT as BaseJWT;
use Firebase\JWT\Key;
use Exception;

class JWT
{

    private static function getPrivateKey(): string
    {
        return md5(env('SECRET_KEY'));
    }

    public static function encode($data, $privateKey = null): string
    {
        if ($privateKey === null) {
            $privateKey = self::getPrivateKey();
        }

        return BaseJWT::encode($data, $privateKey, 'HS256');
    }

    public static function match($jwt, $privateKey = null)
    {
        try {
            if ($privateKey === null) {
                $privateKey = self::getPrivateKey();
            }
            return BaseJWT::decode($jwt, new Key($privateKey, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }
}