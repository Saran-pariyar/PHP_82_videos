<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'partials/_dbconnect.php';

  $showAlert = false;
  $showError = false;
  $username =  $_POST['username'];
  $password =  $_POST['password'];
  $cpassword =  $_POST['cpassword'];

  //now to see if the username already exists or not
  $existSQL = "SELECT * FROM `users` WHERE username = '$username'";
  $result = mysqli_query($conn, $existSQL);
  $numberExistRows = mysqli_num_rows($result);

  if ($numberExistRows > 0) {
    $showError = true; //now it will show error if there is a row that have the same username 
  } else {
    if (($password == $cpassword)) {
      $hash = password_hash($password, PASSWORD_DEFAULT); // saving password in hash code for protection
      $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp());";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $showAlert = true;
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>signup!</title>
</head>

<body>
  <?php
  require 'partials/_nav.php';
  ?>
  <?php
  if ($showAlert) {
    echo '
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account is successfully created!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
  }
  ?>
  <?php
  if ($showError) {
    echo '
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failed!</strong> Username is already taken or password do not match.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> ';
  }
  ?>

  <div class="container">
    <h1 class="text-center">Sign up!</h1>

    <form action="7_signup.php" method='POST'>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" maxlength="40" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="mb-3">
        <label for="cpassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="cpassword" name="cpassword">
        <div id="emailHelp" class="form-text">Make sure to type correctly</div>
      </div>
      <button type="submit" class="btn btn-primary">Sign up!</button>
    </form>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>