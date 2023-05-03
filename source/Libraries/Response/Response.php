<?php

namespace Libraries\Response;

use Libraries\Request\Request;
use Libraries\Response\HttpResponse\JsonResponse;
use Libraries\Response\HttpResponse\TextResponse;
use Libraries\Response\HttpResponse\HttpException;
use ReflectionClass;

class Response
{
    use JsonResponse;
    use TextResponse;
    use HttpException;

    public string $targetUrl;
    public int $statusCode;
    public Request $request;

    public const HTTP_OK = 200;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    public const HTTP_FOUND = 302;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    public const HTTP_REQUEST_URI_TOO_LONG = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;

    public static function getCodes(): array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }


}