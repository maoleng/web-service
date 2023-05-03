<?php

namespace Libraries\Request;

use Closure;
use Exception;
use Libraries\Redirect\Route;
use Libraries\Response\Response;
use ReflectionClass;
use ReflectionFunction;
use Throwable;

trait HandleRequest
{

    public function action()
    {
        $routes = $this->getRoutes();
        $key = $this->method.','.$this->url;
        // Nếu route hiện tại không khớp với cái nào trong route.php thì kiểm tra trường hợp url tùy chọn
        if (empty($routes[$key])) {
            [$key, $optionals] = $this->getUrlOptional($routes);
            // Nếu trường hợp tùy chọn vẫn không thỏa mãn thì trả về lỗi
            if (empty($routes[$key])) {
                abort(Response::HTTP_NOT_FOUND);
            }
        }

        // Nếu action là 1 Closure
        if ($routes[$key] instanceof Closure) {
            return $this->handleAction($routes[$key], $optionals ?? []);
        }

        // Nếu action là 1 hàm của Controller
        $arr_action = explode(',', $routes[$key]);
        $controller_name = str_replace('App\Http\Controllers\\', '', $arr_action[0]);
        $method_name = $arr_action[1];
        $controller_path = asset('/App/Http/Controllers/'.$controller_name.'.php');
        if (! file_exists($controller_path)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $class_name = '\App\Http\Controllers\\'.$controller_name;
        require asset($class_name.'.php');
        $class = new $class_name();
        if (! method_exists($class, $method_name)) {
            abort(Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if (isset($arr_action[2])) {
            require asset($arr_action[2].'.php');
            $middleware = new $arr_action[2]();
            $middleware->handle();
        }

        return $this->handleAction([$class, $method_name], $optionals ?? []);
    }

    private function handleAction($function, $optionals)
    {
        $action = $function instanceof Closure ?
            (new ReflectionFunction($function)) :
            (new ReflectionClass($function[0]))->getMethod($function[1]);
        $request_params = $action->getParameters();
        if (!empty($request_params)) {
            $request_name = $request_params[0]->getType()->getName();
            require_once asset($request_name.'.php');
            $request = new $request_name;
        }

        try {
            return $function instanceof Closure ?
                $function($request ?? $this, ...$optionals) :
                $function[0]->{$function[1]}($request ?? $this, ...$optionals);
        } catch (Throwable|Exception $e) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Convert array từ mảng có hình dạng như file route.php thành mảng 1 chiều
     *
     * @return array
     */
    private function getRoutes(): array
    {
        require('route.php');
        $routes = [];
        $route_groups = (new Route())::$routes;
        foreach ($route_groups as $key => $route_group) {
            if (str_starts_with($key, 'GET') || str_starts_with($key, 'POST') ||
                str_starts_with($key, 'PUT') || str_starts_with($key, 'DELETE')
            ) {
                $routes[$key] = $route_group instanceof Closure ? $route_group : implode(',', $route_group);
            } else {
                foreach($route_group as $uri_method => $action) {
                    $explode = explode(',', $uri_method);
                    $arr_key = $explode[0].',/'.$key.($explode[1] === '/' ? '' : $explode[1]);
                    $routes[$arr_key] = $action instanceof Closure ? $action : implode(',', $action);
                }
            }
        }

        return $routes;
    }

    /**
     * Lấy những biến cho trường hợp đường dẫn tùy chọn trên URL
     * Ví dụ như: domain.com/post/xin_chao_cac_ban thì xin_chao_cac_ban là phần tùy chọn
     */
    private function getUrlOptional($routes): array
    {
        $key = $this->method.','.$this->url;
        $arr_keys = array_keys($routes);
        $optionals = [];
        foreach ($arr_keys as $arr_key) {
            if (! str_contains($arr_key, '{')) {
                continue;
            }
            $route_paths = explode('/', $arr_key);
            $url_paths = explode('/', $key);
            if (count($route_paths) !== count($url_paths)) {
                continue;
            }
            $valid = true;
            $optionals = [];
            foreach ($route_paths as $i => $path) {
                $is_custom_key = str_starts_with($path, '{');
                if ($path !== $url_paths[$i] && ! $is_custom_key) {
                    $valid = false;
                    break;
                }
                if ($is_custom_key) {
                    $optionals[] = $url_paths[$i];
                }
            }
            if (! $valid) {
                continue;
            }
            break;
        }

        return [
            empty($optionals) ? null : ($arr_key ?? null),
            $optionals,
        ];
    }

    /**
     * Thiết lập cho mỗi request đến máy chủ:
     * Khởi tạo URL và METHOD của mỗi request
     *
     * @return void
     */
    private function getRequest(): void
    {
        $url = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
        if (! str_starts_with($_SERVER['PHP_SELF'], '/index.php')) {
            $url = str_replace(substr($_SERVER['PHP_SELF'], 0, -10), '', $url);
        }
        $this->url = $url;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
}