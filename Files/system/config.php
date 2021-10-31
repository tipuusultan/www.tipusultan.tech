<?php
/**
 * Instagram Photo, Video and Story Downloader
 * @version 3.1.0
 * @author Niche Office (contact@nicheoffice.web.tr)
 * @support https://support.nicheoffice.web.tr
 */
/**
 * Do not forget to add your Instagram cookies
 * You can check this guide if you don't know how can you do it
 * https://bit.ly/2A96SGU
 */
const WEBSITE_URL = '.';
const WEBSITE_TITLE = 'Tipu Sultan Tools';
const TEMPLATE_NAME = 'default';
const DEFAULT_LANGUAGE = 'en';
const SHOW_LATEST_DOWNLOADS = true;
const ENABLE_API = false;
const FORCE_DOWNLOAD = true;
const SALT = 'fs343xxd*?sdşawj42?'; // Fill with random text
const COOKIE_COUNT = 1;
const ENABLE_PROXIES = false;
/*
 * Available proxy types: CURLPROXY_HTTP, CURLPROXY_HTTPS, CURLPROXY_SOCKS4, CURLPROXY_SOCKS5
 * If it does not require authentication leave blank username and password
 */
const PROXIES = [
    [
        'ip' => '',
        'port' => '',
        'username' => '',
        'password' => '',
        'type' => 'CURLPROXY_HTTP'
    ]
];
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['token'])) {
    try {
        $_SESSION['token'] = generateToken();
    } catch (Exception $e) {
        $_SESSION['token'] = randomString(30);
    }
}
require_once __DIR__ . '/../language/' . DEFAULT_LANGUAGE . '.php';
$menu = array(
    'Homepage' => WEBSITE_URL
);