<?php
/**
 * @param int $list
 */
function showLastDownloads($list = 6)
{
    $logFile = __DIR__ . '/storage/latest-downloads.txt';
    $fileData = array_slice(file($logFile), 0, $list);
    $buttons = "";
    $images = "";
    for ($i = 0; $i < $list && !empty($fileData[$i]); $i++) {
        if ($i === 0) {
            $buttons .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '" class="active"></li>';
        } else {
            $buttons .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '"></li>';
        }
        $images .= ($i === 0) ? '<div class="carousel-item active">' : '<div class="carousel-item">';
        $images .= '<a href="' . $fileData[$i] . '&dl=1">';
        $images .= '<img class="d-block w-100" src="' . $fileData[$i] . '">';
        $images .= '</a></div>';
    }
    printf('<ol class="carousel-indicators">%s</ol>', $buttons);
    printf('<div class="carousel-inner">%s</div>', $images);
}

/**
 * @param $countFile
 */
function increaseCount($countFile)
{
    $fp = fopen($countFile, 'c+');
    flock($fp, LOCK_EX);
    $count = (int)fread($fp, filesize($countFile));
    ftruncate($fp, 0);
    fseek($fp, 0);
    fwrite($fp, $count + 1);
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * @param $file
 */
function removeSameLines($file)
{
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = array_unique($lines);
    file_put_contents($file, implode(PHP_EOL, $lines));
}

/**
 * @param string $string
 * @param $file
 */
function addLine($string, $file)
{
    $file_data = "$string\n";
    $file_data .= file_get_contents($file);
    file_put_contents($file, $file_data);
    removeSameLines($file);
}

/**
 * @param array $menu
 */
function generateMenu($menu)
{
    foreach ($menu as $title => $url) {
        echo '<li class="nav-item"><a href="' . $url . '" class="nav-link">' . $title . '</a></li>';
    }
}

/**
 * @return string
 * @throws Exception
 */
function generateToken()
{
    if (defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION > 5) {
        $token = bin2hex(random_bytes(32));
    } else {
        if (function_exists('mcrypt_create_iv')) {
            $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
    return $token;
}

/**
 * @param string $errorMsg
 */
function returnError($errorMsg)
{
    $error = array('error' => $errorMsg);
    header('Content-Type: application/json');
    die(json_encode($error));
}

/**
 * @param $id
 * @param bool $echo
 * @return mixed
 */
function language($id, $echo = true)
{
    if ($echo === true) {
        echo constant($id);
    } else {
        return constant($id);
    }
    return "";
}

/**
 * @param $url
 * @return string
 */
function getMainDomain($url)
{
    $host = parse_url($url, PHP_URL_HOST);
    $mainHost = strtolower(trim($host));
    $count = substr_count($mainHost, '.');
    if ($count === 2) {
        if (strlen(explode('.', $mainHost)[1]) > 3) $mainHost = explode('.', $mainHost, 2)[1];
    } else if ($count > 2) {
        $mainHost = getMainDomain(explode('.', $mainHost, 2)[1]);
    }
    return $mainHost;
}

/**
 * @param int $length
 * @return string
 */
function randomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * @param $remoteUrl
 * @param $fileName
 * @param $fileType
 */
function forceDownload($remoteUrl, $fileName, $fileType)
{
    if (empty($fileName)) {
        $fileName = randomString();
    }
    $fileName = $fileName . "." . "$fileType";
    $context_options = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: public');
    if (isset($_SERVER['HTTP_REQUEST_USER_AGENT']) && strpos($_SERVER['HTTP_REQUEST_USER_AGENT'], 'MSIE') !== FALSE) {
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }
    header('Connection: Close');
    ob_clean();
    flush();
    readfile($remoteUrl, "", stream_context_create($context_options));
    exit;
}