<?php
require_once('config.php');
include_once __DIR__ . '/classes/Instagram.php';
filter_var_array($_POST, FILTER_SANITIZE_STRING);
if (!empty($_POST['url']) && !empty($_POST['action']) && hash_equals($_SESSION['token'], $_POST['token']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
    $domain = str_ireplace('www.', '', parse_url($_POST['url'], PHP_URL_HOST));
    if (!empty(explode('.', str_ireplace('www.', '', parse_url($_POST['url'], PHP_URL_HOST)))[1])) {
        $mainDomain = explode('.', str_ireplace('www.', '', parse_url($_POST['url'], PHP_URL_HOST)))[1];
    } else {
        $mainDomain = null;
    }
    if ($domain != 'instagram.com') {
        returnError('URL host must be instagram.com');
    }
    $instagram = new Instagram();
    $data = array();
    preg_match('/instagram.com\/((\w|\.){1,30})/', $_POST['url'], $matches);
    if (!isset($matches[1]) || ($_POST['action'] != 'post' && $_POST['action'] != 'privatePost' && $matches[1] == 'p')) {
        returnError('Invalid username.');
    } else {
        $username = $matches[1];
    }
    $json = json_decode($_POST['json'], true);
    $data['user'] = array();
    $data['medias'] = array();
    switch ($_POST['action']) {
        case 'post':
            if (isset($json['graphql']['shortcode_media']['__typename']) != '') {
                $data['medias'] = $instagram->getPostFromData($json['graphql']['shortcode_media']);
            } else {
                $data['medias'] = $instagram->getPost($_POST['url']);
            }
            $data['user'] = $instagram->getProfile(null, false);
            break;
        case 'profilePic':
            if (isset($json['graphql']['user']['username']) != '') {
                $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
            } else {
                $data['user'] = $instagram->getProfile($username, true);
            }
            $data['medias'] = $instagram->getProfilePicture($data['user']['username'], false);
            break;
        case 'profile':
            if (isset($json['graphql']['user']['username']) != '') {
                $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
            } else {
                $data['user'] = $instagram->getProfile($username, true);
            }
            if (isset($json['graphql']['user']['edge_owner_to_timeline_media']['edges']) != '') {
                $data['medias'] = $instagram->getPostsFromData($json);
            } else {
                $data['medias'] = $instagram->getPosts($data['user']['username'], false);
            }
            break;
        case 'igtvVideos':
            if (isset($json['graphql']['user']['edge_felix_video_timeline']) != '') {
                $data['medias'] = $instagram->getIgtvVideosFromData($json);
            } else {
                $data['medias'] = $instagram->getIgtvVideos($username, true);
            }
            $data['user'] = $instagram->getProfile(null, false);
            break;
        case 'story':
            if (isset($json['graphql']['user']['username']) != '') {
                $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
            } else {
                $data['user'] = $instagram->getProfile($username, true);
            }
            $data['medias'] = $instagram->getStories($data['user']['id']);
            break;
        case 'highlights':
            if (isset($json['graphql']['user']['username']) != '') {
                $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
            } else {
                $data['user'] = $instagram->getProfile($username, true);
            }
            $data['medias'] = $instagram->getHighlights($data['user']['id']);
            break;
        case 'privatePost':
            $data['medias'] = $instagram->getPrivatePostFromData($json["source"]);
            $data['user'] = $instagram->getProfile(null, false);
            break;
        default:
            returnError('Invalid action.');
            break;
    }
    if(!isset($data['medias'][0]) || empty($data['medias'][0])){
        returnError('No media found.');
    }
    if(!isset($data['user']['id']) || empty($data['user']['id'])){
        returnError('User does not exist.');
    }
    increaseCount(__DIR__ . '/storage/download-count.txt');
    for ($i = 0; $i < count($data['medias']); $i++) {
        $previewUrl = $data['medias'][$i]['type'] == 'image' ? $data['medias'][$i]['url'] : $data['medias'][$i]['preview'];
        $data['medias'][$i]['preview'] = WEBSITE_URL . '/system/stream.php?' . http_build_query(array(
                'url' => $previewUrl,
                'type' => 'image',
                'token' => sha1($previewUrl . SALT)
            ));
        if (FORCE_DOWNLOAD) {
            $data['medias'][$i]['downloadUrl'] = WEBSITE_URL . '/dl.php?' . http_build_query(array(
                    'url' => $data['medias'][$i]['url'],
                    'type' => $data['medias'][$i]['type'],
                    'token' => sha1($data['medias'][$i]['url'] . SALT)
                ));
        }
    }
    if (SHOW_LATEST_DOWNLOADS && isset($data['medias'][0]) != '' && filter_var($data['medias'][0]['url'], FILTER_VALIDATE_URL) && $_POST['action'] != 'privatePost') {
        if (!empty($data['medias'][0]['preview'])) {
            addLine($data['medias'][0]['preview'], __DIR__ . '/storage/latest-downloads.txt');
        }
    }
    header('Content-Type: application/json');
    die(json_encode($data));
    /*
    if (filter_var($data['medias'][0]['url'], FILTER_VALIDATE_URL)) {
        increaseCount(__DIR__ . '/storage/download-count.txt');
        if (FORCE_DOWNLOAD) {
            for ($i = 0; $i < count($data['medias']); $i++) {
                $data['medias'][$i]['downloadUrl'] = WEBSITE_URL . '/dl.php?' . http_build_query(array(
                        'url' => $data['medias'][$i]['url'],
                        'type' => $data['medias'][$i]['type']
                    ));
            }
        }
        header('Content-Type: application/json');
        die(json_encode($data));
    }else {
        returnError('Invalid post URL/username or does not exists.');
    }*/
} else {
    returnError('Invalid URL or token mismatch.');
}