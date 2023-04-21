<?php

namespace Libraries\Response\HttpResponse;

trait JsonResponse
{

    public static function json(array $data = []): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(self::HTTP_OK);
        echo json_encode($data);

        exit;
    }

}