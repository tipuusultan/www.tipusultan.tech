<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="http://tipusultan.pythonanywhere.com/static/main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title>Instagram Video Downloader</title>

<style>

body{
  height: 100%;
    background-color: #333;
    display: flex;
    color: #fff;
    text-shadow: 0 0.05rem 0.1rem rgba(0, 0, 0, .5);
    box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
    
}

#loading {
      display: none;
      background: rgb(4, 130, 214);
      width: 20px;
      height: 30px;
      border-radius: 5px;
      animation-name: loading;
      animation-duration: 1s;
      animation-iteration-count: 1;
      margin-top: 20px;
    }

    @keyframes loading {
      from {
        width: 0px;
      }

      to {
        width: 100%;
      }
    }


.form-group{
  margin-top: 20px;
}


#code{
  width: 100%;
  height: 200px;
}

@media only screen and (max-width: 600px) {
        nav{
          margin-top: 10px;
        }
      }


.afterclick{
  display: none;
}

  </style>

</head>
<body>

<?php
$file = "";
  //Creating Variable

//Getting Json File From URL?__a=1
if(isset($_GET['url'])) {
    $url = $_GET['url'];
    if(strpos($url , '?') == true){
        $unwanted_url = strpbrk($url,'?');
        $final_url = str_replace($unwanted_url,'',$url);
        $json = file_get_contents("https://instagram-unofficial-api.herokuapp.com/unofficial/api/video?link=".$final_url);
        $json = json_decode($json);
      }

      else{
        $json = file_get_contents("https://instagram-unofficial-api.herokuapp.com/unofficial/api/video?link=".$url);
        $json = json_decode($json);
      }
    

    //Let's get the images into $html and image array to $arr... 
    // $video_or_audio =  $json->graphql->shortcode_media->is_video;
    // if ($video_or_audio == 1){
    //     $file = $json->graphql->shortcode_media->video_url;
    // }
    // else{
    // $file = $json->graphql->shortcode_media->display_resources[2]->src;
    // }
$file = $json->info;

$main = $file[0];

$link = $main->video_url;


}

?>

<!-- header section -->
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  
<?php

include('../templates/single_header.php');

?>


  <main role="main" class="inner cover">

    <div class="title px-3 py-3">
      <h1 class="text-center">Instagram Video Downloader</h1>
    </div>

<center>
      <div class="container"> 
        <form action="" method="get">
        <p id="blank_url" style="color: red; display: none;">*Enter your Photo/Video URL*</p>
        <input name='url' class="form-control" type="text" placeholder="Paste URL here...">
        <button id="first-download" class="btn btn-primary my-3">Download</button>
        </form>
        </div>


        <?php

if(isset($_GET['url'])) {
?>
<a target='_blank' href="<?php echo $link ?>" class="btn btn-success">Download Here</a>
<?php
}
?>

  </center>
</main>

<!-- foooter section  -->
<footer class="mastfoot mt-auto">
  <div class="inner">
    <p>Instagram Photo and Video Downloader by <a href="https://tipusultan.tech/">Tipu Sultan</a>.</p>
    
  </div>
</footer> 
</div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>


</body>

</html>