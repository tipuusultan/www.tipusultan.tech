<?php
require_once('config.php');
include_once __DIR__ . '/classes/Instagram.php';
filter_var_array($_GET, FILTER_SANITIZE_STRING);
if (!empty($_GET['url']) && !empty($_GET['action']) && filter_var($_GET['url'], FILTER_VALIDATE_URL) && ENABLE_API) {
    $domain = str_ireplace('www.', '', parse_url($_GET['url'], PHP_URL_HOST));
    if (!empty(explode('.', str_ireplace('www.', '', parse_url($_GET['url'], PHP_URL_HOST)))[1])) {
        $mainDomain = explode('.', str_ireplace('www.', '', parse_url($_GET['url'], PHP_URL_HOST)))[1];
    } else {
        $mainDomain = null;
    }
    if ($domain != 'instagram.com') {
        returnError('URL host must be instagram.com');
    }
    $instagram = new Instagram();
    $data = array();
    switch ($_GET['action']) {
        case 'post':
            $data['medias'] = $instagram->getPost($_GET['url']);
            $data['user'] = $instagram->getProfile(null, false);
            break;
        case 'profilePic':
            $username = str_replace('/', '', parse_url($_GET['url'])['path']);
            if ($username == '') {
                returnError('Invalid username.');
            }
            $data['user'] = $instagram->getProfile($username, true);
            $data['medias'] = $instagram->getProfilePicture($username, false);
            break;
        case 'profile':
            $username = str_replace('/', '', parse_url($_GET['url'])['path']);
            if ($username == '') {
                returnError('Invalid username.');
            }
            $data['user'] = $instagram->getProfile($username, true);
            $data['medias'] = $instagram->getPosts($username, false);
            break;
        case 'igtvVideos':
            $username = str_replace('/', '', parse_url($_GET['url'])['path']);
            if ($username == '') {
                returnError('Invalid username.');
            }
            $data['medias'] = $instagram->getIgtvVideos($username, true);
            $data['user'] = $instagram->getProfile(null, false);
            break;
        case 'story':
            $username = str_replace('/', '', parse_url($_GET['url'])['path']);
            if ($username == '') {
                returnError('Invalid username.');
            }
            $data['medias'] = $instagram->getStories($username);
            if (empty($data['medias'])) {
                returnError('No stories found for this account.');
            }
            $data['user'] = $instagram->getProfile($username, false);
            break;
        case 'highlights':
            $username = str_replace('/', '', parse_url($_GET['url'])['path']);
            if ($username == '') {
                returnError('Invalid username.');
            }
            $data['medias'] = $instagram->getHighlights($username);
            $data['user'] = $instagram->getProfile($username, false);
            break;
        case 'privatePost':
            $data['medias'] = $instagram->getPrivatePost($_GET['url']);
            $data['user'] = array();
            break;
        default:
            returnError('Invalid action.');
            break;
    }
    if ($data['medias'][0]['type'] === 'image' && SHOW_LATEST_DOWNLOADS && filter_var($data['medias'][0]['url'], FILTER_VALIDATE_URL)) {
        //addLine($data['medias'][0]['url'], __DIR__ . '/storage/latest-downloads.txt');
    }
    if (filter_var($data['medias'][0]['url'], FILTER_VALIDATE_URL)) {
        //increaseCount(__DIR__ . '/storage/download-count.txt');
        header('Content-Type: application/json');
        die(json_encode($data, JSON_PRETTY_PRINT));
    } else {
        returnError('Invalid post URL/username or does not exists.');
    }
} else {
    returnError('Invalid URL or token mismatch.');
}