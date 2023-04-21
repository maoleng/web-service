<?php

namespace Libraries\Request;

use JetBrains\PhpStorm\Pure;

class Request
{
    use HandleRequest;
    use CSRF;

    public $url = '/';
    public $method = 'index';

    public function __construct()
    {
        $this->getRequest();
//        $this->validateCsrf();
    }

    /**
     * Trả về tất cả tham số trong client tùy theo method
     *
     * @return array
     */
    public function all(): array
    {
        return $this->method === 'GET' ? $_GET : array_merge($_POST, $_FILES);
    }

    /**
     * Trả về giá trị của của key truyền vào
     *
     * @param $key
     * @return array|mixed|null
     */
    public function get($key): mixed
    {
        return $this->method === 'GET' ?
            ($_GET[$key] ?? null) :
            (array_merge($_POST, $_FILES)[$key] ?? null);
    }

    /**
     * Trả về các tham số trên query param
     * Có thể truyền key vào để lấy giá trị của key đó
     *
     * @param $key
     * @return string|array|null
     */
    public function query($key = null): string|array|null
    {
        return $key === null ? $_GET : ($_GET[$key] ?? null);
    }

    /**
     * Trả về các tham số trong form
     * Có thể truyền key vào để lấy giá trị của key đó
     *
     * @param $key
     * @return string|array|null
     */
    public function input($key = null): string|array|null
    {
        return $key === null ?
            array_merge($_POST, $_FILES) :
            (array_merge($_POST, $_FILES)[$key] ?? null);
    }

    /**
     * Trả về các giá trị không nằm trong các key truyền vào
     *
     * @param  array  $keys
     * @return array
     */
    public function except(array $keys = []): array
    {
        return  array_diff_key($this->all(), array_flip($keys));
    }

    /**
     * Trả về các giá trị của các key truyền vào
     *
     * @param  array  $keys
     * @return array
     */
    public function only(array $keys = []): array
    {
        $result = [];
        $data = $this->all();
        foreach ($data as $key => $value) {
            if (in_array($key, $keys, true)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }



}