<?php

/**
 * Class Instagram
 * @author (c) 2020 Niche Office https://nicheoffice.web.tr
 * @version 2.0
 */

class Instagram
{
    /**
     * @var string
     */
    private $cookieFile = __DIR__ . '/../storage/cookie.txt';
    /**
     * @var string
     */
    private $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36';
    /**
     * @var string
     */
    private $pageContent;
    /**
     * @var string
     */
    private $username;
    /**
     * @var array
     */
    private $userProfile;
    /**
     * @var array
     */
    private $medias;

    public function __construct()
    {
        $this->cookieFile = __DIR__ . '/../storage/cookie-' . rand(1, COOKIE_COUNT) . '.txt';
    }

    /**
     * @param string $url
     * @param bool $cookies
     * @return string
     */
    public function getContents($url, $cookies = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cookie ' . file_get_contents($this->cookieFile)
        ));
        if (ENABLE_PROXIES) {
            $proxy = PROXIES[rand(0, count(PROXIES) - 1)];
            curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ":" . $proxy['port']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy['type']);
            if (!empty($proxy['username']) && !empty($proxy['password'])) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['username'] . ":" . $proxy['password']);
            }
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param string $url
     * @return mixed
     */
    private function getPostShortcode($url)
    {
        if (substr($url, -1) != '/') {
            $url .= '/';
        }
        preg_match('/\/(p|tv|reel)\/(.*?)\//', $url, $output);
        return ($output['2'] ?? '');
    }

    /**
     * @param string $url
     * @return int|string|null
     */
    public static function getHighlightId($url)
    {
        preg_match('/stories\/highlights\/(?|([0-9]+)|[^\/]+\/(\d+))/', $url, $highlightId);
        $highlightId = (isset($highlightId[1]) != '') ? $highlightId[1] : null;
        if (is_numeric($highlightId)) {
            return $highlightId;
        } else if (preg_match('/s\/(.*)/', $url, $highlightId)) {
            $url = unshorten($url);
            return self::getHighlightId($url);
        } else {
            return null;
        }
    }


    /**
     * @param string $username
     * @param bool $requestAgain
     * @return array
     */
    public function getProfile($username = null, $requestAgain = false)
    {
        if (!empty($this->userProfile['id'])) {
            return $this->userProfile;
        } else {
            $this->pageContent = $this->getContents('https://instagram.com/' . ($username) . '/?__a=1');
        }
        $data = json_decode($this->pageContent, true)['graphql']['user'] ?? null;
        if (empty($data)) {
            return null;
        }
        $userProfile = array(
            'id' => $data['id'],
            'username' => $data['username'],
            'fullName' => $data['full_name'],
            'profilePicUrl' => $data['profile_pic_url_hd'],
            'biography' => $data['biography'],
            'followers' => $data['edge_followed_by']['count'],
            'following' => $data['edge_follow']['count']
        );
        $this->userProfile = $userProfile;
        return $userProfile;
    }


    public function getProfileFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        $userProfile = array(
            'id' => $data['id'],
            'username' => $data['username'],
            'fullName' => $data['full_name'],
            'profilePicUrl' => $data['profile_pic_url_hd'],
            'biography' => $data['biography'],
            'followers' => $data['edge_followed_by']['count'],
            'following' => $data['edge_follow']['count']
        );
        $this->userProfile = $userProfile;
        return $userProfile;
    }

    /**
     * @param string $jsonData
     * @return array
     */
    public function getPrivateProfile($jsonData)
    {
        if (!empty($this->userProfile)) {
            return $this->userProfile;
        }
        $data = (json_decode($jsonData, true)['graphql']['shortcode_media']['owner']) ?? '';
        if (empty($data)) {
            return null;
        }
        $userProfile = array(
            'id' => $data['id'],
            'username' => $data['username'],
            'fullName' => $data['full_name'],
            'profilePicUrl' => $data['profile_pic_url'],
            'biography' => '',
            'followers' => 'N/A',
            'following' => ''
        );
        $this->userProfile = $userProfile;
        return $userProfile;
    }

    /**
     * @param string $username
     * @param bool $requestAgain
     * @return array
     */
    public function getProfilePicture($username = null, $requestAgain = false)
    {
        /*$this->pageContent = ($requestAgain === false) ? $this->pageContent : $this->getContents('https://instagram.com/' . $username . '/?__a=1');
        $data = (json_decode($this->pageContent, true)['graphql']['user']) ?? '';*/
        //$data = $this->getProfile($username);
        $data = $this->getProfile($username);
        if (empty($data['profilePicUrl'])) {
            return null;
        }
        $medias = array();
        array_push($medias, array(
            'type' => 'image',
            'fileType' => 'jpg',
            'url' => $data['profilePicUrl'],
            'downloadUrl' => $data['profilePicUrl'] . '&dl=1'
        ));
        return $medias;
    }

    public function getProfilePictureFromData($data)
    {
        if (empty($data['profilePicUrl'])) {
            return null;
        }
        $medias = array();
        array_push($medias, array(
            'type' => 'image',
            'fileType' => 'jpg',
            'url' => $data['profile_pic_url_hd'],
            'downloadUrl' => $data['profile_pic_url_hd'] . '&dl=1'
        ));
        return $medias;
    }

    /**
     * @param string $username
     * @param bool $requestAgain
     * @return array
     */
    public function getIgtvVideos($username, $requestAgain = false)
    {
        $this->pageContent = ($requestAgain === false) ? $this->pageContent : $this->getContents('https://instagram.com/' . $username . '/?__a=1');
        $data = json_decode($this->pageContent, true);
        if (empty($data)) {
            return null;
        }
        $userProfile = array(
            'id' => $data['graphql']['user']['id'],
            'username' => $data['graphql']['user']['username'],
            'fullName' => $data['graphql']['user']['full_name'],
            'profilePicUrl' => $data['graphql']['user']['profile_pic_url_hd'],
            'biography' => $data['graphql']['user']['biography'],
            'followers' => $data['graphql']['user']['edge_followed_by']['count'],
            'following' => $data['graphql']['user']['edge_follow']['count']
        );
        $this->userProfile = $userProfile;
        $videos = $data['graphql']['user']['edge_felix_video_timeline']['edges'];
        $medias = array();
        foreach ($videos as $video) {
            $post = $video['node'];
            $video = $this->getPost('https://instagram.com/tv/' . $post['shortcode'] . '/', true)[0];
            array_push($medias, $video);
        }
        return $medias;
    }

    public function getIgtvVideosFromData($data)
    {
        $userProfile = array(
            'id' => $data['graphql']['user']['id'],
            'username' => $data['graphql']['user']['username'],
            'fullName' => $data['graphql']['user']['full_name'],
            'profilePicUrl' => $data['graphql']['user']['profile_pic_url_hd'],
            'biography' => $data['graphql']['user']['biography'],
            'followers' => $data['graphql']['user']['edge_followed_by']['count'],
            'following' => $data['graphql']['user']['edge_follow']['count']
        );
        $this->userProfile = $userProfile;
        $videos = $data['graphql']['user']['edge_felix_video_timeline']['edges'];
        $medias = array();
        foreach ($videos as $video) {
            $post = $video['node'];
            $video = $this->getPost('https://instagram.com/tv/' . $post['shortcode'] . '/', true)[0];
            array_push($medias, $video);
        }
        return $medias;
    }

    /**
     * @param string $url
     * @return array
     */
    public function getPrivatePost($url)
    {
        $medias = array();
        $suffix = (substr($url, -1) === '/') ? 'media/?size=l&dl=1' : '/media/?size=l&dl=1';
        array_push($medias, array(
            'type' => 'private',
            'fileType' => 'jpg',
            'url' => $url . $suffix,
            'downloadUrl' => $url . $suffix
        ));
        return $medias;
    }


    public function getPrivatePostFromData($data)
    {
        $medias = array();
        $mediaData = $this->getMediaDataFromPage($data);
        $userProfile = array(
            'id' => $mediaData['owner']['id'],
            'username' => $mediaData['owner']['username'],
            'fullName' => $mediaData['owner']['full_name'],
            'profilePicUrl' => $mediaData['owner']['profile_pic_url'],
            'biography' => '',
            'followers' => $mediaData['owner']['edge_followed_by']['count'],
            'following' => ''
        );
        $this->userProfile = $userProfile;
        foreach ($mediaData['links'] as $link) {
            array_push($medias, array(
                'type' => $link['type'],
                'fileType' => $link['type'] == 'video' ? 'mp4' : 'jpg',
                'url' => $link['url'],
                'preview' => $link['type'] == 'video' ? $link['preview'] : 'jpg',
                'downloadUrl' => $link['url'] . "&dl=1"
            ));
        }
        return $medias;
    }

    function getMediaDataFromPage($pageSource)
    {
        preg_match_all("/window.__additionalDataLoaded.'.{5,}',(.*).;/", $pageSource, $matches);
        preg_match_all('/<script type="text\/javascript">window._sharedData = (.*?);<\/script>/', $pageSource, $output);
        if (isset($matches[1][0]) != '') {
            $json = $matches[1][0];
        } else if (isset($output[1][0]) != '') {
            $json = $output[1][0];
        }
        $data = json_decode($json, true);
        if (isset($data['entry_data']['PostPage']) != "") {
            $data = $data['entry_data']['PostPage'][0];
        }
        if ($data['graphql']['shortcode_media']['__typename'] == "GraphImage") {
            $imagesdata = $data['graphql']['shortcode_media']['display_resources'];
            $length = count($imagesdata);
            $media_info['links'][0]['type'] = 'image';
            $media_info['links'][0]['url'] = $imagesdata[$length - 1]['src'];
            $media_info['links'][0]['status'] = 'success';
        } else {
            if ($data['graphql']['shortcode_media']['__typename'] == "GraphSidecar") {
                $counter = 0;
                $multipledata = $data['graphql']['shortcode_media']['edge_sidecar_to_children']['edges'];
                foreach ($multipledata as $media) {
                    if ($media['node']['is_video'] == "true") {
                        $media_info['links'][$counter]["url"] = $media['node']['video_url'];
                        $media_info['links'][$counter]["type"] = 'video';
                        $media_info['links'][$counter]['preview'] = $media['node']['display_url'];
                    } else {
                        $length = count($media['node']['display_resources']);
                        $media_info['links'][$counter]["url"] = $media['node']['display_resources'][$length - 1]['src'];
                        $media_info['links'][$counter]["type"] = 'image';
                    }
                    $counter++;
                    $media_info['type'] = 'media';
                }
                $media_info['status'] = 'success';
            } else {
                if ($data['graphql']['shortcode_media']['__typename'] == "GraphVideo") {
                    $videolink = $data['graphql']['shortcode_media']['video_url'];
                    $media_info['links'][0]['type'] = 'video';
                    $media_info['links'][0]['url'] = $videolink;
                    $media_info['links'][0]['status'] = 'success';
                    $media_info['links'][0]['preview'] = $data['graphql']['shortcode_media']['display_resources'][0]['src'];
                } else {
                    $media_info['links']['status'] = 'fail';
                }
            }
        }
        $media_info["owner"] = $data['graphql']['shortcode_media']['owner'];
        return $media_info;

    }

    public function getVideoUrl($postShortcode)
    {
        $this->userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36';
        $pageContent = file_get_contents('https://www.instagram.com/p/' . $postShortcode);
        preg_match_all('/"video_url":"(.*?)",/', $pageContent, $out);
        if (!empty($out[1][0])) {
            return str_replace('\u0026', '&', $out[1][0]);
        } else {
            return null;
        }
    }

    /**
     * @param string $postUrl
     * @param bool $igtv
     * @param bool $jsonData
     * @return array
     */
    public function getPost($postUrl, $igtv = false, $jsonData = false)
    {
        if (!$jsonData) {
            $postShortcode = $this->getPostShortcode($postUrl);
            /*
            $endpointUrl = ($igtv === true) ? 'https://www.instagram.com/tv/' . $postShortcode . '/?__a=1' : 'https://www.instagram.com/p/' . $postShortcode . '/?__a=1';
            $this->pageContent = $this->getContents($endpointUrl);
            $data = (json_decode($this->pageContent, true)['graphql']['shortcode_media']) ?? '';
            */
            $endpointUrl = 'https://www.instagram.com/graphql/query/?query_hash=55a3c4bad29e4e20c20ff4cdfd80f5b4&variables=%7B%22shortcode%22:%22' . $postShortcode . '%22%7D';
            $this->pageContent = $this->getContents($endpointUrl, true);
            $data = (json_decode($this->pageContent, true)['data']['shortcode_media']) ?? '';
            if (empty($data)) {
                return null;
            }
        } else {
            $data = (json_decode($jsonData, true)['graphql']['shortcode_media']) ?? '';
            if (empty($data)) {
                return null;
            }
        }
        $userProfile = array(
            'id' => $data['owner']['id'],
            'username' => $data['owner']['username'],
            'fullName' => $data['owner']['full_name'],
            'profilePicUrl' => $data['owner']['profile_pic_url'],
            'biography' => '',
            'followers' => $data['owner']['edge_followed_by']['count'],
            'following' => ''
        );
        $this->userProfile = $userProfile;
        $medias = array();
        switch ($data['__typename']) {
            case 'GraphImage':
                $i = count($data['display_resources']) - 1;
                array_push($medias, array(
                    'type' => 'image',
                    'fileType' => 'jpg',
                    'url' => $data['display_resources'][$i]['src'],
                    'downloadUrl' => $data['display_resources'][$i]['src'] . '&dl=1'
                ));
                break;
            case 'GraphVideo':
                if ((explode('.', $data['video_url'])[4] ?? '') == 'jpg') {
                    $data['video_url'] = $this->getVideoUrl($data['shortcode']);
                }
                array_push($medias, array(
                    'type' => 'video',
                    'fileType' => 'mp4',
                    'preview' => $data['display_url'],
                    'url' => $data['video_url'],
                    'downloadUrl' => $data['video_url'] . '&dl=1'
                ));
                break;
            case 'GraphSidecar':
                $sidecarPosts = $data['edge_sidecar_to_children']['edges'];
                foreach ($sidecarPosts as $post) {
                    $post = $post['node'];
                    switch ($post['__typename']) {
                        case 'GraphImage':
                            $i = count($post['display_resources']) - 1;
                            array_push($medias, array(
                                'type' => 'image',
                                'fileType' => 'jpg',
                                'url' => $post['display_resources'][$i]['src'],
                                'downloadUrl' => $post['display_resources'][$i]['src'] . '&dl=1'
                            ));
                            break;
                        case 'GraphVideo':
                            if ((explode('.', $post['video_url'])[4] ?? '') == 'jpg') {
                                $post['video_url'] = $this->getVideoUrl($post['shortcode']);
                            }
                            array_push($medias, array(
                                'type' => 'video',
                                'fileType' => 'mp4',
                                'preview' => $post['display_url'],
                                'url' => $post['video_url'],
                                'downloadUrl' => $post['video_url'] . '&dl=1'
                            ));
                            break;
                    }
                }
                break;
        }
        return $medias;
    }

    /**
     * @param $data
     * @return array
     */
    public function getPostFromData($data)
    {
        $userProfile = array(
            'id' => $data['owner']['id'],
            'username' => $data['owner']['username'],
            'fullName' => $data['owner']['full_name'],
            'profilePicUrl' => $data['owner']['profile_pic_url'],
            'biography' => '',
            'followers' => $data['owner']['edge_followed_by']['count'],
            'following' => ''
        );
        $this->userProfile = $userProfile;
        $medias = array();
        switch ($data['__typename']) {
            case 'GraphImage':
                $i = count($data['display_resources']) - 1;
                array_push($medias, array(
                    'type' => 'image',
                    'fileType' => 'jpg',
                    'url' => $data['display_resources'][$i]['src'],
                    'downloadUrl' => $data['display_resources'][$i]['src'] . '&dl=1'
                ));
                break;
            case 'GraphVideo':
                if ((explode('.', $data['video_url'])[4] ?? '') == 'jpg') {
                    $data['video_url'] = $this->getVideoUrl($data['shortcode']);
                }
                array_push($medias, array(
                    'type' => 'video',
                    'fileType' => 'mp4',
                    'preview' => $data['display_url'],
                    'url' => $data['video_url'],
                    'downloadUrl' => $data['video_url'] . '&dl=1'
                ));
                break;
            case 'GraphSidecar':
                $sidecarPosts = $data['edge_sidecar_to_children']['edges'];
                foreach ($sidecarPosts as $post) {
                    $post = $post['node'];
                    switch ($post['__typename']) {
                        case 'GraphImage':
                            $i = count($post['display_resources']) - 1;
                            array_push($medias, array(
                                'type' => 'image',
                                'fileType' => 'jpg',
                                'url' => $post['display_resources'][$i]['src'],
                                'downloadUrl' => $post['display_resources'][$i]['src'] . '&dl=1'
                            ));
                            break;
                        case 'GraphVideo':
                            if ((explode('.', $post['video_url'])[4] ?? '') == 'jpg') {
                                $post['video_url'] = $this->getVideoUrl($post['shortcode']);
                            }
                            array_push($medias, array(
                                'type' => 'video',
                                'fileType' => 'mp4',
                                'preview' => $post['display_url'],
                                'url' => $post['video_url'],
                                'downloadUrl' => $post['video_url'] . '&dl=1'
                            ));
                            break;
                    }
                }
                break;
        }
        return $medias;
    }

    /**
     * @param string $username
     * @param bool $requestAgain
     * @return array
     */
    public function getPosts($username, $requestAgain = false)
    {
        $this->pageContent = ($requestAgain === false) ? $this->pageContent : $this->getContents('https://instagram.com/' . $username . '/?__a=1');
        $data = json_decode($this->pageContent, true);
        if (empty($data)) {
            return null;
        }
        $posts = $data['graphql']['user']['edge_owner_to_timeline_media']['edges'];
        $medias = array();
        foreach ($posts as $post) {
            $post = $post['node'];
            switch ($post['__typename']) {
                case 'GraphImage':
                    array_push($medias, array(
                        'type' => 'image',
                        'fileType' => 'jpg',
                        'url' => $post['display_url'],
                        'downloadUrl' => $post['display_url'] . '&dl=1'
                    ));
                    break;
                case 'GraphVideo':
                    $postDetail = $this->getPost('https://instagram.com/p/' . $post['shortcode'] . '/');
                    array_push($medias, $postDetail[0]);
                    break;
                case 'GraphSidecar':
                    $sidecarPosts = $this->getPost('https:/instagram.com/p/' . $post['shortcode'] . '/');
                    foreach ($sidecarPosts as $sidecarPost) {
                        array_push($medias, $sidecarPost);
                    }
                    break;
                default:
                    break;
            }
        }
        return $medias;
    }

    public function getPostsFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        $posts = $data['graphql']['user']['edge_owner_to_timeline_media']['edges'];
        $medias = array();
        foreach ($posts as $post) {
            $post = $post['node'];
            switch ($post['__typename']) {
                case 'GraphImage':
                    array_push($medias, array(
                        'type' => 'image',
                        'fileType' => 'jpg',
                        'url' => $post['display_url'],
                        'downloadUrl' => $post['display_url'] . '&dl=1'
                    ));
                    break;
                case 'GraphVideo':
                    $postDetail = $this->getPost('https://instagram.com/p/' . $post['shortcode'] . '/');
                    array_push($medias, $postDetail[0]);
                    break;
                case 'GraphSidecar':
                    $sidecarPosts = $this->getPost('https:/instagram.com/p/' . $post['shortcode'] . '/');
                    foreach ($sidecarPosts as $sidecarPost) {
                        array_push($medias, $sidecarPost);
                    }
                    break;
                default:
                    break;
            }
        }
        return $medias;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getStories($userId)
    {
        //$userId = $this->getProfile($username, true)['id'];
        $baseUrl = 'https://www.instagram.com/graphql/query/?query_id=17873473675158481&variables=';
        //$variables = '{"reel_id":["' . $userId . '"],"tag_names":[],"location_ids":[],"highlight_reel_ids":[],"precomposed_overlay":false,"show_story_viewer_list":true,"story_viewer_fetch_count":50,"story_viewer_cursor":""}';
        //$variables = '{"reel_ids":["' . $userId . '"],"only_stories":true,"stories_prefetch":true,"stories_video_dash_manifest":false,"precomposed_overlay":false,}';
        $variables = '{"precomposed_overlay":false,"reel_ids":["' . $userId . '"]}';
        $stories = $this->getContents($baseUrl . urlencode($variables), true);
        $data = json_decode($stories, true);
        if (isset($data['data']['reels_media'][0]['items']) == '') {
            return array();
        }
        $stories = $data['data']['reels_media'][0]['items'];
        $medias = array();
        foreach ($stories as $story) {
            switch ($story['__typename']) {
                case 'GraphStoryImage':
                    $i = count($story['display_resources']) - 1;
                    array_push($medias, array(
                        'type' => 'image',
                        'fileType' => 'jpg',
                        'url' => $story['display_resources'][$i]['src'],
                        'downloadUrl' => $story['display_resources'][$i]['src'] . '&dl=1'
                    ));
                    break;
                case 'GraphStoryVideo':
                    $i = count($story['video_resources']) - 1;
                    array_push($medias, array(
                        'type' => 'video',
                        'fileType' => 'mp4',
                        'preview' => $story['display_url'],
                        'url' => $story['video_resources'][$i]['src'],
                        'downloadUrl' => $story['video_resources'][$i]['src'] . '&dl=1'
                    ));
                    break;
            }
        }
        return $medias;
    }

    /**
     * @param int $reelId
     * @param string $username
     * @return array
     */
    public function getStory($reelId, $username)
    {
        $userId = $this->getProfile($username, true)['id'];
        $baseUrl = 'https://www.instagram.com/graphql/query/?query_id=17873473675158481&variables=';
        $variables = '{"reel_ids":["' . $userId . '"],"precomposed_overlay":false}';
        $stories = $this->getContents($baseUrl . urlencode($variables), true);
        $data = json_decode($stories, true);
        if (empty($data)) {
            return null;
        }
        if (isset($data['data']['reels_media']['0']['items']) == '') {
            return array();
        }
        $stories = $data['data']['reels_media']['0']['items'];
        $medias = array();
        foreach ($stories as $story) {
            if ($story['id'] == $reelId) {
                switch ($story['__typename']) {
                    case 'GraphStoryImage':
                        $i = count($story['display_resources']) - 1;
                        array_push($medias, array(
                            'type' => 'image',
                            'fileType' => 'jpg',
                            'url' => $story['display_resources'][$i]['src'],
                            'downloadUrl' => $story['display_resources'][$i]['src'] . '&dl=1'
                        ));
                        break;
                    case 'GraphStoryVideo':
                        $i = count($story['video_resources']) - 1;
                        array_push($medias, array(
                            'type' => 'video',
                            'fileType' => 'mp4',
                            'preview' => $story['display_url'],
                            'url' => $story['video_resources'][$i]['src'],
                            'downloadUrl' => $story['video_resources'][$i]['src'] . '&dl=1'
                        ));
                        break;
                }
            }
        }
        return $medias;
    }

    /**
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getHighlights($userId, $limit = 2)
    {
        $baseUrl = 'https://www.instagram.com/graphql/query/?query_hash=e74d51c10ecc0fe6250a295b9bb9db74&variables=';
        $variables = '{"user_id":"' . $userId . '","include_chaining":true,"include_reel":true,"include_suggested_users":false,"include_logged_out_extras":false,"include_highlight_reels":true,"include_related_profiles":false}';
        $highlights = $this->getContents($baseUrl . urlencode($variables), true);
        $data = json_decode($highlights, true);
        if (empty($data)) {
            return null;
        }
        $highlights = $data['data']['user']['edge_highlight_reels']['edges'];
        $medias = array();
        $i = 1;
        foreach ($highlights as $highlight) {
            $highlight = $highlight['node'];
            if ($i <= $limit) {
                $highlightMedias = $this->getHighlight($highlight['id']);
                if (empty($highlightMedias)) {
                    break;
                } else {
                    foreach ($highlightMedias as $highlightMedia) {
                        array_push($medias, $highlightMedia);
                    }
                    $i++;
                }
            } else {
                break;
            }
        }
        return $medias;
    }

    /**
     * @param integer $reelId
     * @return array
     */
    public function getHighlight($reelId)
    {
        $baseUrl = 'https://www.instagram.com/graphql/query/?query_hash=ba71ba2fcb5655e7e2f37b05aec0ff98&variables=';
        $variables = '{"reel_ids":[],"tag_names":[],"location_ids":[],"highlight_reel_ids":["' . $reelId . '"],"precomposed_overlay":false,"show_story_viewer_list":true,"story_viewer_fetch_count":50,"story_viewer_cursor":"","stories_video_dash_manifest":false}';
        $reel = $this->getContents($baseUrl . urlencode($variables), true);
        $data = json_decode($reel, true);
        if (empty($data)) {
            return null;
        }
        $reelMedias = $data['data']['reels_media'];
        $medias = array();
        foreach ($reelMedias as $reelMedia) {
            foreach ($reelMedia['items'] as $item) {
                switch ($item['__typename']) {
                    case 'GraphStoryImage':
                        $i = count($item['display_resources']) - 1;
                        array_push($medias, array(
                            'type' => 'image',
                            'fileType' => 'jpg',
                            'url' => $item['display_resources'][$i]['src'],
                            'downloadUrl' => $item['display_resources'][$i]['src'] . '&dl=1'
                        ));
                        break;
                    case 'GraphStoryVideo':
                        $i = count($item['video_resources']) - 1;
                        array_push($medias, array(
                            'type' => 'video',
                            'fileType' => 'mp4',
                            'preview' => $item['display_url'],
                            'url' => $item['video_resources'][$i]['src'],
                            'downloadUrl' => $item['video_resources'][$i]['src'] . '&dl=1'
                        ));
                        break;
                }
            }
        }
        return $medias;
    }
}