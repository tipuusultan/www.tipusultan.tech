<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta name="description" content="We provide 100% FREE tools to Boost Up your Work and make your work easy.">
    <meta name="keywords" content="color code Generate, facebook video downloader, instagram video downloader, to-do lsit, privacy policy page Generator, gradient html color Generator, youtube thumnail downloader, youtube embed code Generator, ">
    <link rel="canonicial" href="www.tipusultan.tech/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>100% Free Tools to Boost up your Work - Tipu Sultan</title>
  </head>
  <body>

<!-- header start -->
  

  <?php

include('templates/header.php');
include('templates/db.php');

?>


<!-- header end -->

<!-- body start -->


<div class="container" style='display: flex; flex-direction: row;   flex-flow: row wrap; width: 90%; margin: auto;'>
<?php


$sql = "SELECT * FROM tools";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
  ?>

    <div class="card my-3" style="width: 18rem;">
        <!-- <div class="instagram-logo">
        <img src="download.jfif" class="card-img-top" alt="...">
    </div> -->
        <div class="card-body">
          <h5 class="card-title"><?php  echo $row['title'] ?></h5>
          <p class="card-text"><?php  echo $row['description'] ?></p>
          <a href="<?php  echo $row['link'] ?>" class="btn btn-primary">Click Here</a>
        </div>
      </div>

      
      <?php
    }
    
    ?>
  </div>


<h3 class="text-center mb-3 ml-2 mr-3">I am happy to say that, There are a lot <br> of tools coming soon...<a href="https://www.instagram.com/tipu09sultan/">Let's Talk on Instagram</a></h3>

<center>
<p>Want to know How to build a PC at home?<a href="https://theproductsreviewer.com/pc-build-for-cyberpunk-under-65000/">Click Here</a></p>
</center>

<!-- body end -->






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>