<?php
require_once __DIR__ . '/config.php';

function decode_password($key)
{
    global $app_key;
    $key = str_replace(["-", "_"], ["+", "/"], $key);
    $key = base64_decode($key);
    $key = openssl_decrypt($key, "AES-128-ECB", $app_key, OPENSSL_RAW_DATA);
    return $key;
}

function encode_password($key)
{
    global $app_key;
    $key = openssl_encrypt($key, "AES-128-ECB", $app_key, OPENSSL_RAW_DATA);
    $key = base64_encode($key);
    $key = str_replace(["+", "/", "="], ["-", "_", ""], $key);
    return $key;
}

function replaceTildeWithServerPath($path)
{
    global $app_url;
    if ($_SERVER['SERVER_NAME'] === $app_url) {
        $wwwrootPath = '/wwwroot';
    } else {
        $wwwrootPath = $_SERVER['SERVER_NAME'];
    }
    if (substr($path, 0, 1) === '~') {
        $path = $wwwrootPath . substr($path, 1);
    }
    return $path;
}

ob_start(function ($buffer) {
    return preg_replace_callback('/(?:href|src)\s*=\s*["\'](.*?)["\']/', function ($matches) {
        return replaceTildeWithServerPath($matches[0]);
    }, $buffer);
});
