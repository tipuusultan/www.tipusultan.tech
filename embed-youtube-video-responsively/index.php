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
  <title>Responsive YouTube Embed Code Generator</title>

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
<!-- header section -->
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
<?php

include('../templates/single_header.php');

?>

<center>
  <main role="main" class="inner cover">

    <h1 id="heading" >Responsive YouTube Embed Code Generator</h1>
    <br>
    <div class="input-group flex-nowrap container">
        <input  placeholder="Enter the YouTube Video URL" id='url' type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
      </div>
      
<button  class="btn btn-primary my-2" onclick="get() , load()">Submite</button>
<br>
<div id="loading">
  <p style="color: aliceblue;margin-left: 6px;">Generating Your Privacy Policy....</p>
</div>
<br>
<div class="container" id="preview">

</div><br>
<div id="getcodesection" style="display: none;">
<h2>Here you code</h2>
<textarea class="afterclick" name="code" id="code"></textarea><br>
<button id="copy"  class="btn btn-primary afterclick mb-5 my-2" onclick="copy()">Copy Code</button>
</div>


</main>

 </center>
<!-- foooter section  -->
<footer class="mastfoot mt-auto">
  <div class="inner">
    <p>Responsive YouTube Embed Code Generator by <a href="https://tipusultan.tech/">Tipu Sultan</a>.</p>
  </div>
</footer> 
</div>

  <script>
    

    function get(){
          document.getElementById('loading').style.display = 'flex';
          document.getElementById('heading').style.display = 'none';

            var url = document.getElementById('url').value;
            if (url.includes('youtube.com')){
            ss = url.substring(url.lastIndexOf("=")+1)
            let newurl = 'https://youtube.com/embed/' 
            var nurl = newurl.concat(ss)
            console.log(nurl);

            // adding the code to text area
            let code = document.getElementById('code').innerHTML = "<style>.youtube-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .youtube-embed iframe, .youtube-embed object, .youtube-embed embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='youtube-embed'><iframe src='"+ nurl +"' "+ "frameborder='0' allowfullscreen></iframe></div>"
            let pre = document.getElementById('preview').innerHTML = "<style>.youtube-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .youtube-embed iframe, .youtube-embed object, .youtube-embed embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='youtube-embed'><iframe src='"+ nurl +"' "+ "frameborder='0' allowfullscreen></iframe></div>"
            document.getElementById('getcodesection').style.display = ''

        }
        else{
            ss = url.substring(url.lastIndexOf("/")+1)
            let newurl = 'https://youtube.com/embed/' 
            var nurl = newurl.concat(ss)
            console.log(nurl);
            // adding the code to text area
            let code = document.getElementById('code').innerHTML = "<style>.youtube-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .youtube-embed iframe, .youtube-embed object, .youtube-embed embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='youtube-embed'><iframe src='"+ nurl +"' "+ "frameborder='0' allowfullscreen></iframe></div>"
            let pre = document.getElementById('preview').innerHTML = "<style>.youtube-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .youtube-embed iframe, .youtube-embed object, .youtube-embed embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='youtube-embed'><iframe src='"+ nurl +"' "+ "frameborder='0' allowfullscreen></iframe></div>"
            document.getElementById('getcodesection').style.display = ''

        }
        }





        // copy text function
        function copy() {
  /* Get the text field */
  var copyText = document.getElementById("code");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); 
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}



// loading function
function load(){
  setTimeout(() => { 
document.getElementById('loading').style.display = 'none';
document.getElementById('code').style.display = 'flex';
document.getElementById('copy').style.display = 'flex';
}, 1000);

}




  </script>
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
</body>

</html>