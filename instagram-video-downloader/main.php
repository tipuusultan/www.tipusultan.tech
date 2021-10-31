<?php
$file = "";
//Creating Variable

//Getting Json File From URL?__a=1
if(isset($_GET['url'])) {
    $url = $_GET['url'];
    // remove unwanted part of URL and Get the JSON
    if(strpos($url , '?') == true){
        $unwanted_url = strpbrk($url,'?');
        $final_url = str_replace($unwanted_url,'',$url);
        $json = file_get_contents($final_url."?__a=1");
        $json = json_decode($json);
      }
      else{
        $json = file_get_contents($url."?__a=1");
        $json = json_decode($json);
      }
    
    //   check video or image 
    $video_or_audio =  $json->graphql->shortcode_media->is_video;
    if ($video_or_audio == 1){
        $file = $json->graphql->shortcode_media->video_url;

    }
    else{
        $file = $json->graphql->shortcode_media->display_resources[2]->src;
    }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Photo Downloader</title>
</head>
<body>
    <h1>Instax - Instagram Downloader</h1>
    <form action="" method="get">
    <input type="text" name="url" id="">
    <button type="submit">GRAB</button>
    </form>

    <?php

if(isset($_GET['url'])) {
?>
<a target='_blank' href="<?php echo $file ?>" class="btn btn-primary">Download</a>
<?php
}
?>
   
</body>
</html>
