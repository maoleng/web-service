<?php

namespace Libraries\Response\HttpResponse;

trait TextResponse
{

    public static function message(string $message = ''): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        http_response_code(self::HTTP_FOUND);
        echo $message;

        exit;
    }

    public static function html(string $message = ''): void
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code(self::HTTP_FOUND);
        echo $message;

        exit;
    }

}