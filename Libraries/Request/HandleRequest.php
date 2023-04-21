<?php

namespace Libraries\Request;

use Closure;
use Error;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
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
        if (empty($routes[$key])) {
            // Nếu route hiện tại không khớp với cái nào trong route.php thì kiểm tra trường hợp url tùy chọn
            $arr_keys = array_keys($routes);
            $url_optional = $this->getUrlOptional();
            foreach ($arr_keys as $arr_key) {
                if (str_starts_with($arr_key, $url_optional['str_starts_with'])) {
                    preg_match('/\/{[a-z]+}/', $arr_key, $match);
                    $key = $url_optional['no_optional_url'].$match[0];
                    $optional_value = $url_optional['optional_value'];
                }
            }
            // Nếu trường hợp tùy chọn vẫn không thỏa mãn thì trả về lỗi
            if (empty($routes[$key])) {
                abort(Response::HTTP_NOT_FOUND);
            }
        }

        // Nếu action là 1 Closure
        if ($routes[$key] instanceof Closure) {
            return $this->handleAction($routes[$key], $optional_value ?? null);
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

        return $this->handleAction([$class, $method_name], $optional_value ?? null);
    }

    private function handleAction($function, $optional_value = null)
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
                $function($request ?? $this, $optional_value) :
                $function[0]->{$function[1]}($request ?? $this, $optional_value);
        } catch (Throwable|Exception $e) {
            $message = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();
            $errors = $e->getTrace();
            require asset('Libraries/Response/views/debug.php');

            return false;
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
    #[ArrayShape([
        'optional_value' => "null|string", 'no_optional_url' => "string", 'str_starts_with' => "string"
    ])]
    private function getUrlOptional(): array
    {
        $key = $this->method.','.$this->url;
        $arr = explode('/', $key);
        $optional_value = array_pop($arr);
        if (empty($optional_value)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $url = implode('/', $arr);

        return [
            'optional_value' => $optional_value,
            'no_optional_url' => $url,
            'str_starts_with' => $url.'/{',
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