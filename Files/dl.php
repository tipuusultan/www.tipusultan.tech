<?php
require_once __DIR__ . '/system/config.php';
if (!empty($_GET['url']) && !empty($_GET['type']) && !empty($_GET['token'])) {
    $_GET['type'] = urldecode($_GET['type']);
    $_GET['token'] = urldecode($_GET['token']);
    filter_var($_GET['url'], FILTER_SANITIZE_URL);
    filter_var($_GET['type'], FILTER_SANITIZE_STRING);
    filter_var($_GET['token'], FILTER_SANITIZE_STRING);
    if (filter_var($_GET['url'], FILTER_VALIDATE_URL) && ($_GET['type'] === 'image' || $_GET['type'] === 'video') && hash_equals(sha1($_GET['url'] . SALT), $_GET['token'])) {
        $fileExtension = $_GET['type'] === 'image' ? 'jpg' : 'mp4';
        $urlExtension = explode('.', parse_url($_GET['url'], PHP_URL_PATH))[2];
        if ($fileExtension === $urlExtension) {
            session_write_close();
            forceDownload($_GET['url'], "", $fileExtension);
        } else {
            http_response_code(403);
        }
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(404);
}