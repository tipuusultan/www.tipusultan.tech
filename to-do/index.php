<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>To Do - Bost Up your Work</title>
  </head>
  <body>

  <?php

include('../templates/header.php');

?>




<h1 class="text-center my-4">To-Do List</h1>

<div class="container px-5 mx-5">
   <div class="form-group">
       <label for="title">Title</label>
       <input type="text" class="form-control" id="title">
       <span style="color: red;" id="title_blank"></span>
       <div class="form-group">
       <label class="my-2" for="desctiptin">Description</label>
       <textarea class="form-control" name="description" id="description"></textarea>
       <span style="color: red;" id="des_blank"></span>

   </div>
   <button id="add" class="btn btn-primary my-3">Add to List</button>
</div>


<div class="items my-5">
    <h3>Your Task</h3>

    <table id='allitems' class="table">
        <thead>
          <tr>
            <th scope="col">SNo</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <tr>
            <th scope="row">1</th>
            <td>Fuck</td>
            <td>You need to fuck in this week</td>
          <td><button class="btn-sm btn btn-primary">Delete</button></td>

          </tr>
       


        </tbody>
      </table>

  
      <p style="display: none; color: red;" id="noitem">*Please add some task*</p>

<script>







function getAndUpdate() {
    let title = document.getElementById('title').value;
    let description = document.getElementById('description').value;

if (title == "") {
    document.getElementById('title_blank').innerHTML = '<b>*Title not should be Blank<b>'
    return false
}


if (description == "") {
    document.getElementById('des_blank').innerHTML = '<b>*Description not should be Blank<b>'
    return false
}




    if (localStorage.getItem('items') == null){
        itemjson = [];
        itemjson.push([title, description])
        localStorage.setItem('items', JSON.stringify(itemjson))        
    }
    else{
        itemjsonstr = localStorage.getItem('items');
        itemjson = JSON.parse(itemjsonstr);
        itemjson.push([title, description]);
        localStorage.setItem('items', JSON.stringify(itemjson))        
    }

    if (localStorage.getItem('items') != "[]"){
    document.getElementById('allitems').style.display=""
}
    update()
}

function update() {
    if (localStorage.getItem('items') == "[]"){
    document.getElementById('allitems').style.display="none"
    document.getElementById('noitem').style.display = ''
}

else{
  document.getElementById('noitem').style.display = 'none'

}


    if (localStorage.getItem('items') == null){
        itemjson = [];
        localStorage.setItem('items', JSON.stringify(itemjson))        
    }
    else{
        itemjsonstr = localStorage.getItem('items');
        itemjson = JSON.parse(itemjsonstr);
    }


    tablebody = document.getElementById('tableBody');
    let str = ''
    itemjson.forEach((element,index ) => {
        str += `
        <tbody id="tableBody">
          <tr>
            <th scope="row">${index+1}</th>
            <td id='com_title-${index}'>${element[0]}</td>
            <td id='com_des-${index}'>${element[1]}</td>
          <td><button class="btn-sm btn btn-primary " onclick="deleted(${index})">Delete</button></td>
          
          </tr>
          `
        });
        // <td><button class="btn-sm btn btn-primary" id="bg-${index}" onclick="completed(${index})">Complete</button></td>

document.getElementById('tableBody').innerHTML = str
}

var add = document.getElementById('add')
add.addEventListener('click' , getAndUpdate)
update()


function deleted(itemIndex) {
    console.log('Delete '+itemIndex)
    itemjsonstr = localStorage.getItem("items");
    itemjson = JSON.parse(itemjsonstr);
    itemjson.splice(itemIndex, 1)
    localStorage.setItem('items' , JSON.stringify(itemjson))
    update()

}


// function completed(indexitem) {
//     document.getElementById('bg-'+indexitem).style.backgroundColor ='green'
//     var com_title = document.getElementById('com_title')
//     var com_des = document.getElementById('com_des')
//     var com_title = document.getElementById('com_title-'+indexitem).style.textDecoration = 'line-through'
//     document.getElementById('com_des-'+indexitem).style.textDecoration = 'line-through'
    
// }






</script>

<style>
.demotext{
  text-decoration: line-through;
}
</style>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
  </body>
</html>