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
  <title>YouTube Thumnail Downloader</title>

  <style>
    body {
      height: 100%;
      background-color: #333;
      display: flex;
      color: #fff;
      text-shadow: 0 0.05rem 0.1rem rgba(0, 0, 0, .5);
      box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
    }


    @media only screen and (max-width: 600px) {
      nav {
        margin-top: 10px;
      }
    }

    #upperlist, #downlist{
      display: none;
    }
  </style>

</head>

<body>
  <!-- header section -->
  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <?php

include('../templates/single_header.php');

?>


    <main role="main" class="inner cover">
      <center>


<h1 class="mb-3">YouTube Video Thumnail Downloader</h1>
      <form onsubmit="event.preventDefault(); fetchlinks();">
      <input aria-label='URL input ' class='form-control' id='inputURL'
              placeholder='Enter the youtube URL here' type='text' />
            <input type='submit' class='btn btn-primary my-3' id='submitButton' type='button' value='Download' />
      </form>




  <div id='upperlist'>
    <a target="_blank" id="highlink" class="btn btn-success my-3">High Quality Download</a>
	</div>


	<div id='downlist'>
		<a target="_blank" id="lowlink"  class="btn btn-success my-3">Low Quality Download</button></a>
	</div>



</center>
    </main>

    <!-- foooter section  -->
    <footer class="mastfoot mt-auto">
      <div class="inner">
        <p>YouTube Thumnail Downloader by <a href="https://tipusultan.tech/">Tipu Sultan</a>.</p>
      </div>
    </footer>

  </div>


  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="js.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
</body>

</html>