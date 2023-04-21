<?php

if (! function_exists('cleanData')) {
    function cleanData($data): array|string
    {
        if (is_array($data)) {
            return array_map(static function ($each) {
                return $each === null ? null : addslashes($each);
            }, $data);
        }

        return addslashes($data);
    }
}