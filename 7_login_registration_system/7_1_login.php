<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'partials/_dbconnect.php';

  $login = false;
  $showError = false;
  $username =  $_POST['username'];
  $password =  $_POST['password'];
  $exist = false;

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  $num_of_rows = mysqli_num_rows($result);

  if ($num_of_rows == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        header("location: 7_welcome.php");
      } else {
        $showError = "Invalid credintials";
      }
    }
  } else {
    $showError = "Invalid credintials";
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
  if ($login) {
    echo '
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Welcome! </strong> You are logged in!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
  }
  ?>
  <?php
  if ($showError) {
    echo '
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failed!</strong> Some problem came, sorry.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> ';
  }
  ?>
  <div class="container">
    <h1 class="text-center">Log In</h1>

    <form action="7_1_login.php" method='POST'>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Log In</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  </script>
</body>

</html>