<?php

namespace Libraries\Session;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Lưu vào session theo key và value
     *
     * @param  string  $key
     * @param $value
     * @return void
     */
    public static function put(string $key, $value = null): void
    {
        $_SESSION[$key] = $value;
    }


    /**
     * Lấy session theo key, nếu không truyền key thì lấy toàn bộ
     *
     * @param  string|null  $key
     * @return array|mixed
     */
    public static function get(?string $key = null): mixed
    {
        if (empty($key)) {
            return self::all();
        }
        $value = $_SESSION[$key] ?? null;
        if (in_array($key, $_SESSION['_flash'] ?? [], true)) {
            $flash_key = array_search($key, $_SESSION['_flash'], true);
            unset($_SESSION[$key], $_SESSION['_flash'][$flash_key]);
        }

        return $value;
    }


    /**
     * Lấy toàn bộ session
     *
     * @return array
     */
    public static function all(): array
    {
        unset($_SESSION['_flash']);
        $session = $_SESSION;
        foreach ($_SESSION['_flash'] ?? [] as $each) {
            unset($_SESSION[$each]);
        }

        return $session;
    }

    /**
     * Xóa session theo key
     *
     * @param  string  $key
     * @return void
     */
    public static function forget(string $key): void
    {
        $flash_key = array_search($key, $_SESSION['_flash'] ?? [], true);
        unset($_SESSION[$key], $_SESSION['_flash'][$flash_key]);
    }

    /**
     * Xóa toàn bộ session
     *
     * @return void
     */
    public static function flush(): void
    {
        $_SESSION = [];
    }

    /**
     * Kiểm tra một session theo key có tồn tại không
     *
     * @param  string  $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Lấy giá trị của session theo key truyền vào và xóa nó khỏi session
     *
     * @param  string  $key
     * @return mixed
     */
    public static function pull(string $key): mixed
    {
        $value = $_SESSION[$key];
        $flash_key = array_search($key, $_SESSION['_flash'], true);
        unset($_SESSION[$key], $_SESSION['_flash'][$flash_key]);

        return $value;
    }

    /**
     * Đẩy 1 phần tử vào key của session
     *
     * @param  string  $key
     * @param  null  $value
     * @return void
     */
    public static function push(string $key, $value = null): void
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Lưu session 1 lần
     *
     * @param  string  $key
     * @param  null  $value
     * @return void
     */
    public static function flash(string $key, $value = null): void
    {
        $_SESSION[$key] = $value;
        $_SESSION['_flash'][] = $key;
    }

}