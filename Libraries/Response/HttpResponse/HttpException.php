<?php

namespace Libraries\Response\HttpResponse;

trait HttpException
{

    public static function abort(int $code): void
    {
        $codes = self::getCodes();
        if (! in_array($code, $codes, true)) {
            self::abort(500);
        }

        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');

        exit;
    }

}