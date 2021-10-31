<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="style.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title>Privacy Policy Generator</title>

  <style>

body{
  height: 100%;
    background-color: #333;
    display: flex;
    color: #fff;
    text-shadow: 0 0.05rem 0.1rem rgba(0, 0, 0, .5);
    box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
    
}

*, ::after, ::before {
    box-sizing: border-box;
}

    #loading {
      display: none;
      background: rgb(4, 130, 214);
      width: 20px;
      height: 30px;
      border-radius: 5px;
      animation-name: loading;
      animation-duration: 4s;
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

    #policy {
      display: none;
    }


.form-group{
  margin-top: 20px;
}



@media only screen and (max-width: 600px) {
        #tubehenchod{
          margin-top: 50px
        }
        nav{
          margin-top: 10px;
        }
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

  <h1 id="tubehenchod" style="margin-bottom: 40px;" class="text-center">Privacy Policy Generator</h1>
  <div class="container">
    <div id="allfields">
    <p style="color: red;display: none;" id="blank_field_error">Blank Field not allowed!</p>
    <div class="form-group">
      <input type="text" placeholder="Your Website Name" class="form-control" id="websitename" aria-describedby="NameHelp">
    </div>
    <div class="form-group">
      <input placeholder="Website URL" type="url" class="form-control" id="websitelink">
    </div>
    <div class="form-group">
      <input placeholder="Email address" type="email" class="form-control" id="websiteemail" aria-describedby="emailHelp">
    </div>
    <button onclick="get()" type="submit" class="btn btn-primary">Submit</button>
  </div>
    <div id="loading">
      <p style="color: aliceblue;margin-left: 6px;">Generating Your Privacy Policy....</p>
    </div>


    <div style="display: none;" id="success" class="alert alert-success my-3" role="alert">
      <b>Your Privacy Policy has been generated Successfully!</b>  
    </div>

    <button id="copy" style="display: none;" onclick="myFunction()" class="btn btn-primary">Copy</button>

    <div class="input-group my-5">
      <textarea id="policy" style="height: 500px;" class="form-control" aria-label="With textarea"></textarea>
    </div>
  </div>
</main>

 
<!-- foooter section  -->
<footer class="mastfoot mt-auto">
  <div class="inner">
    <p>Privacy Policy Page Generator by <a href="https://tipusultan.tech/">Tipu Sultan</a>.</p>
  </div>
</footer> 
</div>

  <script>
    function get() {
      var name = document.getElementById('websitename').value;
      var link = document.getElementById('websitelink').value;
      var email = document.getElementById('websiteemail').value;
      let policy = document.getElementById('policy');
      policy.innerHTML = `<h2>Privacy Policy for ${name}</h2>
<p>At ${name}, accessible from ${link}, one of our main priorities is the privacy of our visitors.
This Privacy Policy document contains types of information that is collected and recorded by ${name}
and how we use it.</p>
<p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to
Contact through email at <b>${email}</b></p>
<h2>Log Files</h2>
<p>${name} follows a standard procedure of using log files. These files log visitors when they visit websites.
All hosting companies do this and a part of hosting services' analytics. The information collected by log files include 
internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, 
and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the
 information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic 
 information.</p>
<h2>Cookies and Web Beacons</h2>
<p>Like any other website, ${name} uses 'cookies'. These cookies are used to store information including visitors' 
preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' 
experience by customizing our web page content based on visitors' browser type and/or other information.</p>
<h2>Google DoubleClick DART Cookie</h2>
<p>Google is one of a third-party vendor on our site. It also uses cookies, known as DART cookies, to serve ads to our site
 visitors based upon their visit to www.website.com and other sites on the internet. However, visitors may choose to decline
  the use of DART cookies by visiting the Google ad and content network Privacy Policy at the following URL – 
  <a href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a></p>
<h2>Privacy Policies</h2>
<P>You may consult this list to find the Privacy Policy for each of the advertising partners of ${name}. Our Privacy 
Policy was created with the help of the <a href="https://tipusultan.tech">Tipu Sultan Privacy Policy Generator</a></p>
<p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in 
their respective advertisements and links that appear on ${name}, which are sent directly to users' browser. They 
automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of 
their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>
<p>Note that ${name} has no access to or control over these cookies that are used by third-party advertisers.</p>
<h2>Third Pary Privacy Policies</h2>
<p>${name}'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the 
respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and 
instructions about how to opt-out of certain options. You may find a complete list of these Privacy Policies and their links
 here: Privacy Policy Links.</p>
<p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie 
management with specific web browsers, it can be found at the browsers' respective websites. What Are Cookies?</p>
<h2>Children's Information</h2>
<p>Another part of our priority is adding protection for children while using the internet. We encourage parents
 and guardians to observe, participate in, and/or monitor and guide their online activity.</p>
<p>${name} does not knowingly collect any Personal Identifiable Information from children under the age of 13. If 
you think that your child provided this kind of information on our website, we strongly encourage you to Contact 
immediately and we will do our best efforts to promptly remove such information from our records.</p>
<h2>Online Privacy Policy Only</h2>
<p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards
 to the information that they shared and/or collect in ${name}. This policy is not applicable to any information 
 collected offline or via channels other than this website.</p>
<h2>Consent</h2>
<p>By using our website, you hereby consent to our Privacy Policy and agree to its Terms and Conditions.</p>

`
      
// velidation of text fields
if (name=='' || email =='' || link == '' ){
  var blank_field_error = document.getElementById('blank_field_error');
  blank_field_error.style.display = '';
}

else{
  document.getElementById('loading').style.display = 'flex';
  load()
}


}


function load(){
  setTimeout(() => {
policy.style.display = 'flex'; 
document.getElementById('loading').style.display = 'none';
document.getElementById('success').style.display = '';
document.getElementById('allfields').style.display = 'none'
document.getElementById('tubehenchod').style.display = 'none'
document.getElementById('copy').style.display = ''
}, 3000);

}


function myFunction() {
  var copyText = document.getElementById("policy");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
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