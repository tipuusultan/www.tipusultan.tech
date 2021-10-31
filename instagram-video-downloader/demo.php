<?php

$url = "https://instagram-unofficial-api.herokuapp.com/unofficial/api/video?link=https://www.instagram.com/reel/CUPWYvoADBa/" ;
$json = file_get_contents($url);
$json = json_decode($json);
$file = $json->info;

$main = $file[0];

$link = $main->video_url;
echo $link;
?>