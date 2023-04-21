<?php

namespace Libraries\Request;

use JetBrains\PhpStorm\Pure;

class Request
{
    use HandleRequest;

    public $url = '/';
    public $method = 'index';

    public function __construct()
    {
        $this->getRequest();
    }

    /**
     * Trả về tất cả tham số trong client tùy theo method
     *
     * @return array
     */
    public function all(): array
    {
        $body = file_get_contents('php://input');
        if (str_starts_with($_SERVER['CONTENT_TYPE'] ?? '', 'multipart/form-data')) {
            preg_match_all('/-\d+.*\n-/sU', $body, $fields);
            $body = [];
            foreach ($fields[0] as $field) {
                preg_match('/name=".*"/sU', $field, $key);
                $key = substr($key[0], 6, -1);
                preg_match('/\r\n\r\n.*-/s', $field, $content);
                $content = substr($content[0], 6, -3);
                preg_match('/\d+\r\n.*filename=".*"/sU', $field, $file_name);
                if (isset($file_name[0])) {
                    preg_match('/filename=".*"/', $file_name[0], $file_name);
                    $file_name = substr($file_name[0], 10, -1);
                    $body[$key] = [
                        'file_name' => $file_name,
                        'file_content' => $content,
                    ];
                } else {
                    $body[$key] = $content;
                }
            }
        } else {
            $body = (array) json_decode($body, false);
        }

        return array_merge($_GET, $_POST, $_FILES, $body);
    }

    /**
     * Trả về giá trị của của key truyền vào
     *
     * @param $key
     * @return array|mixed|null
     */
    public function get($key): mixed
    {
        return $this->all()[$key] ?? null;
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