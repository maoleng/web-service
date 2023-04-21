<?php

use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;
use Libraries\Redirect\Redirector;
use Libraries\Request\Request;
use Libraries\Response\Response;
use Libraries\Session\Session;

if (! function_exists('view')) {
    function view($view_name, $data = [])
    {
        $path = str_replace('.', '/', $view_name);
        $file_path = asset('/App/Views/'.$path.'.php');
        if (!file_exists($file_path)) {
            throwHttpException("VIEW $view_name NOT EXISTS");
        }
        foreach ($data as $key => $each) {
            ${$key} = $each;
        }
        authed();

        return require($file_path);
    }
}

if (! function_exists('section')) {
    function section($view_name): string
    {
        $path = str_replace('.', '/', $view_name);
        $file_path = asset('/App/Views/'.$path.'.php');
        if (!file_exists($file_path)) {
            throwHttpException("VIEW $view_name NOT EXISTS");
        }

        return $file_path;
    }
}

if (! function_exists('env')) {
    function env($key): string
    {
        $string_regex = $key.'=.*';
        $path = asset('/.env');
        preg_match("/$string_regex/", file_get_contents($path), $match);

        if (empty($match[0])) {
            throw new \RuntimeException('Environment key not found');
        }

        return substr(explode('=', $match[0])[1], 0, -1);
    }
}

if (! function_exists('asset')) {
    function asset($path = ''): string
    {
        if (str_contains($path, '\\')) {
            $path = str_replace('\\', '/', $path);
        }
        if (!in_array($path[0], ['\\', '/'])) {
            $path = '/'.$path;
        }

        return dirname(__DIR__, 2).$path;
    }
}

if (! function_exists('request')) {
    function request(): Request
    {
        require_once asset('Libraries/Request/Request.php');

        return new Request();
    }
}

if (! function_exists('url')) {
    function url($to = ''): string
    {
        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
        if (!str_starts_with($_SERVER['PHP_SELF'], '/index.php')) {
            $root .= substr($_SERVER['PHP_SELF'], 1, -10).'/';
        }
        if (str_starts_with($to, '/')) {
            $to = substr($to, 1);
        }

        return $root.$to;
    }
}

if (! function_exists('now')) {
    function now(): Carbon
    {
        return Carbon::now();
    }
}

if (! function_exists('session')) {
    function session($key = null)
    {
        return isset($key) ? Session::get($key) : (new Session());
    }
}

if (! function_exists('redirect')) {
    #[Pure]
    function redirect(): Redirector
    {
        return new Redirector();
    }
}

if (! function_exists('response')) {
    #[Pure]
    function response(): Response
    {
        return new Response();
    }
}

if (! function_exists('abort')) {
    function abort($code): void
    {
        response()->abort($code);
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token()
    {
        return session()->get('_token');
    }
}

if (! function_exists('csrf_token_field')) {
    function csrf_token_field()
    {
        echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
    }
}