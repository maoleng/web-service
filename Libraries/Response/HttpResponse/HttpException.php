<?php

namespace Libraries\Response\HttpResponse;

use RuntimeException;

trait HttpException
{

    public static function abort(int $code): void
    {
        $codes = self::getCodes();
        if (! in_array($code, $codes, true)) {
            throw new RuntimeException('Mã trạng thái không hợp lệ');
        }

        http_response_code($code);
        $message = str_replace('_', ' ', array_search($code, $codes, true));

        if (file_exists($user_config_view = asset('App/Views/vendor/abort.php'))) {
            require $user_config_view;
        } else {
            require asset('Libraries/Response/views/abort.php');
        }

        exit;
    }

    public static function terminate(string $message): void
    {
        http_response_code(self::HTTP_INTERNAL_SERVER_ERROR);
        if (file_exists($user_config_view = asset('App/Views/vendor/abort.php'))) {
            require $user_config_view;
        } else {
            require asset('Libraries/Response/views/abort.php');
        }

        exit;
    }

}