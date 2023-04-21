<?php

namespace Libraries\Redirect;

class Redirector
{

    public static function to($url): void
    {
        header('Location: '.$url);

        exit;
    }

    public static function route($path): void
    {
        static::to(url($path));
    }

    public static function back(): void
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            static::to($_SERVER['HTTP_REFERER']);
        }

        static::to(url());
    }



}
