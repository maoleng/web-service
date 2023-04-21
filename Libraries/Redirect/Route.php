<?php

namespace Libraries\Redirect;

class Route
{
    public static array $routes = [];

    public static function get($uri, $action): static
    {
        self::$routes['GET,'.$uri] = $action;

        return new static();
    }

    public static function post($uri, $action): static
    {
        self::$routes['POST,'.$uri] = $action;

        return new static();
    }

    public static function middleware($class): void
    {
        $last = array_key_last(self::$routes);
        self::$routes[$last][] = $class;
    }
}
