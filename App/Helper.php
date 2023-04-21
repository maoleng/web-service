<?php

if (! function_exists('prettyMoney')) {
    function prettyMoney($money): string
    {
        return number_format($money, 0, '', ',');
    }
}

if (! function_exists('getRequestHeader')) {
    function getRequestHeader($key): ?string
    {
        return apache_request_headers()[$key] ?? null;
    }
}

if (! function_exists('authed')) {
    function authed()
    {
        return $_SESSION['user'] ?? null;
    }
}


