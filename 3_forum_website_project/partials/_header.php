<?php
//the below 3 lines will show the errors in the code on the browser page
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);


// in the login button, we added data-bs-toggle="modal" and data-bs-target="#loginModal" from the login.php  modal itself
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="#">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
    //the code also worked without include '_dbconnect.php' but also we include it to avoid may-cause errors
        include '_dbconnect.php';
      //getting categories from the sql
      // we also need the cat_id to put it in href to go to our desired category 
      $sql = "SELECT category_name,category_id FROM `categories` LIMIT 3";//when we use limit 3, otherwise all the categories will be shown
      $result = mysqli_query($conn, $sql);
      while($row= mysqli_fetch_assoc($result)){
          echo '<li><a class="dropdown-item" href="threadList.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
          
      }

        echo ' </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>';
    //the below code is only for login functionality... 
session_start();
if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
  //we gave name to input tag and form action to "search.php" so that we can make it work
  //we did method="get" so that user can use or share the url with others too...
  //to understand, watch php video no66 from 2:40 time to understand 
  echo '
  <form class="d-flex " action="search.php" method="GET">
<input class=" me-2 " type="search" name="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success" type="submit">Search</button>

<p class="text-light mx-2 my-auto">Welcome - ' . $_SESSION['useremail'] . '</p>
<a href="partials/_logout.php" class="btn btn-outline-success  mx-3">Log out</a>
</form>';
  //we took the useremail from the session of _handleLogin.php page 
} else {
  echo '
      <form class="d-flex" action="search.php" method="GET">
      <input class="form-control me-2" name = "search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
      <div class="btn btn-outline-success  mx-3" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</div>
      <div class="btn btn-outline-success mx-1" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up!</div>
  ';
}
echo '
  </div>
</div>
</nav>
';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
//the below code is the way to find out if user is logged in or not
if (isset($_GET['signupsuccess']) && ($_GET['signupsuccess'] == "true")) {
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You can now log in!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
// we commented this because the alert will show without trying to signup 
// else{
//   echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
//   <strong>Failed!</strong> You can now log in!
//   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';
// }
