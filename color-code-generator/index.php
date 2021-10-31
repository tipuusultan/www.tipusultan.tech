<!doctype html>
<html lang="en">

<head>
  <title>HTML Color Code Generator - Get Color HTML code</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="Generate or browse beautiful gradient color combinations for your designs. Find HTML gradient color code using Our Color Code picker">
  <meta name="keywords" content="color code Generate, HTML color code Generator, colo code, HTML color code, HTML color code Generator, Random Color Code Generator,html color doe, what is color code, gradient , ">
  <link rel="canonicial" href="www.tipusultan.tech/gradient-color-code-generator">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="http://tipusultan.pythonanywhere.com/static/main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <style>
.title{
    margin-top: 2em;
}


    body {
      height: auto;
      background-color: #141414;
      display: flex;
      color: #fff;
    }

    #onecolorcode{
        width: 60%;
    }


    @media only screen and (max-width: 600px) {
      nav {
        margin-top: 10px;
      }
    }

    .onecolor1 , .color1 , .color2{
        width: 100px;
        height: 100px;
    }

 

    #colorcode{
        width: 60%;
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
                <div class="container">  
                     <div class="row">  
                          <div class="col text-center">  
                               <h2 class="title">HTML Color Code Generator</h2>  
                   
                   <input oninput="setfrominput()" type="text" id="onecolorcode" class="my-3"><br>
                   <input class="onecolor1 my-2" type="color" name="onecolor1" value="#141414" />  
                   <p>Color Picker</p>
                            
                            <div class="my-3">
                               <button onclick="copyText()" class="copy_pro btn btn-primary">Copy Color Code</button>  
                               <button onclick="generateRandom()" class="random-btn btn btn-light ml-2">Generate random</button>  
                            </div>
                          </div>  
                     </div>  
                </div>  



                <div style="margin-top: 3em;" class="container">  
                    <div class="row">  
                         <div class="col text-center">  
                              <h2 class="gcg">Gradient Color Code Generator</h2>  
                  
                  <input type="text" id="colorcode" class="my-3"><br>
                              <input class="color1 my-2" type="color" name="color1" value="#141414" />  
                              <input class="color2" type="color" name="color2" value="#141414" />  
                           <br>
                           <div class="my-3">
                              <button onclick="copyText()" class="copy_pro btn btn-primary">Copy Color Code</button>  
                              <button onclick="generateRandom()" class="random-btn btn btn-light ml-2">Generate random</button>  
                           </div>
                         </div>  
                    </div>  
               </div>  

           </center>

           
    </main>


    

    <!-- foooter section  -->
    <footer class="mastfoot mt-auto">
      <div class="inner">
        <p>HTML Color Code Generator by <a href="https://tipusultan.tech/">Tipu Sultan</a>.</p>
      </div>
    </footer>

  </div>
  <Script>    
   const onecolor1 = document.querySelector(".onecolor1");  
   const currentSelection = document.querySelector(".current-bg");  
   const Copy_pro = document.querySelector(".copy_pro");  
   const randomButton = document.querySelector(".random-btn");  
   function setGradient() {  
    document.body.style.background = `${onecolor1.value}`;  
        document.getElementById('onecolorcode').value = `${onecolor1.value}`
   }  

function setfrominput(){
    var val = document.getElementById('onecolorcode').value;
        onecolor1.value = val;
        document.body.style.background = val;
    }


   function generateRandom() {  
        const randomonecolor1 = Math.random().toString(16).slice(2, 8).toUpperCase();  
        onecolor1.value = `#${randomonecolor1}`;  
        setGradient();  
   }  
   function copyText() {  
       console.log("Copied")
        var onecolorcode = document.getElementById('onecolorcode')
        onecolorcode.select();
        onecolorcode.setSelectionRange(0, 99999);
        document.execCommand("copy");
   }  
   window.addEventListener("load", setGradient);  
   onecolor1.addEventListener("input", setGradient);  
    </Script>    









<Script>    
   const color1 = document.querySelector(".color1");  
   const color2 = document.querySelector(".color2");  
   function setGradient() {  
        document.body.style.background = `linear-gradient(to right, ${color1.value}, ${color2.value})`;  
        document.getElementById('colorcode').value = `linear-gradient (to right, ${color1.value} , ${color2.value})`
   }  
   function generateRandom() {  
        const randomColor1 = Math.random().toString(16).slice(2, 8).toUpperCase();  
        const randomColor2 = Math.random().toString(16).slice(2, 8).toUpperCase();  
        color1.value = `#${randomColor1}`;  
        color2.value = `#${randomColor2}`;  
        setGradient();  
   }  
   function copyText() {  
       console.log("Copied")
        var colorcode = document.getElementById('colorcode')
        colorcode.select();
        colorcode.setSelectionRange(0, 99999);
        document.execCommand("copy");
   }  
   window.addEventListener("load", setGradient);  
   color1.addEventListener("input", setGradient);  
   color2.addEventListener("input", setGradient);  
    </Script>    




  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
</body>
  
