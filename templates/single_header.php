<header class="masthead mb-auto">
    <div class="inner">
     <a style='color:white' href="/"><h3 class="masthead-brand">Tipu Sultan Tools</h3></a> 
      <nav class="nav nav-masthead justify-content-center">
        <a class="nav-link active" href="/">Home</a>
        <li class="nav-item dropdown ml-2 mr-2">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Tools
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
        <?php


include('../templates/db.php');


$sql = "SELECT * FROM tools";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
  ?>


          <li><a class="dropdown-item" href="../<?php  echo $row['link'] ?>"><?php  echo $row['title'] ?></a></li>

      
      <?php
    }
    
    ?>
        </ul>
      </li>

        <a class="nav-link" href="/about.html">About</a>
        <a class="nav-link" href="/contact.html">Contact</a>
      </nav>
    </div>
  </header>