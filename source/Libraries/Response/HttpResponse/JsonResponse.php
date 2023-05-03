<?php

namespace Libraries\Response\HttpResponse;

trait JsonResponse
{

    public static function json(array $data = [], $code = self::HTTP_OK): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);

        exit;
    }

}