<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Welcome to idiscuss!</title>
</head>

<body>
  <?php include 'partials/_dbconnect.php';  ?>
  <?php include 'partials/_header.php';  ?>
  <?php
  //from this threads.php page, we control the comments and from threadList.php, we control the discussion
  $id = $_GET['threadid'];
  $sql = " SELECT * FROM `threads` WHERE thread_id=$id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_user_id = $row['thread_user_id'];
    //query to find the name of the poster of the question
    $sql2 = "SELECT user_email FROM `users` WHERE sno = $thread_user_id;"; //for gettin the user email id to display
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2); //it will store the column that we want (there can only be one column with our given thread_user_id) ...
    $posted_by = $row2['user_email'];
  }
  ?>
  <?php
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];
  // echo $method;
  if ($method == "POST") {
    // insert comment into database 
    $comment = $_POST['comment']; //getting from the form below
    
    //making sure that users does not accidently input html tags 
    // saving site from potential XSS attacks 
    $comment = str_replace("<","&lt;",$comment); //if there is a "<" tag, it will be replaced with &lt; which is html entities for that sign 
    $comment = str_replace(">","&gt;",$comment);

    $sno = $_POST['sno'];//we got this value from the hidden input tag from below code on line no 84(inside the string)


    $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp());";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;

    if ($showAlert) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong>  Your comment has been added.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
  }
  ?>

  <div class="container my-4 bg-light">
    <div class="jumbotron">
      <h1 class="display-4"> <?php echo $title; ?> </h1>
      <p class="lead">
        <?php echo $desc; ?>
      </p>
      <p>This is a peer to peer forum to share knowledge</p>
      <p>Posted by :  <em><?php echo $posted_by ?></em></p>
    </div>
  </div>

  <?php //I think this one code is not useful
  // $showAlert = false;
  // $method = $_SERVER['REQUEST_METHOD'];
  // // echo $method;
  // if ($method == "POST") {
  //   // insert thread into database 
  //   $th_title = $_POST['title']; //getting from the form below
  //   $th_desc = $_POST['desc'];
  //   $th_sno = $_POST['sno'];
  //   $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$th_sno', current_timestamp());";
  //    $result = mysqli_query($conn, $sql);
  // }
  ?>

  <?php
  // <!-- code to add comment if we are logged in  -->

  if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
    //in the form below, we gave one input tag hidden and value of $_SESSION['sno'] to get the user sno to get their email
    //we can get the $_SESSION['sno'] value in the above code using $sno = $_POST['sno']
    echo '
<div class="container">
  <h1 class="container">Post a comment</h1>
  <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
      <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
      <input type="hidden" name="sno" value="'.$_SESSION['sno'].'"
    </div>
    <button type="submit" class="btn btn-success">Post comment</button>
  </form>
  </div>';
  } else {
    echo '<div class="container">
        <h1 class="container">Write a comment</h1>
      <p class="lead">You are not logged in. Please log in to comment</p>
      </div>';
  }
  ?>
  <h1 class="container">Discussion</h1>
  <?php
  $id = $_GET['threadid'];
  $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
  $result = mysqli_query($conn, $sql);

  $noResult = true;
  while ($row = mysqli_fetch_assoc($result)) {
    $noResult = false;
    $id = $row['comment_id'];
    $content = $row['comment_content'];
    $comment_time = $row['comment_time']; //getting time from the comment table from database
    //below 4 lines  are copied from the threadList.php to get the user_email
    
    $thread_user_id = $row['comment_by']; //getting thread_user_id from the 'threads' table
    $sql2 = "SELECT user_email FROM `users` WHERE sno = $thread_user_id;"; //for gettin the user email id to display
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2); //it will store the column that we want (there can only be one column with our given thread_user_id) ...

    echo '
    <div class="container bg-light">
    <div class="media my-3 mr-3">
      <img class="mr-3" src="img/userdefault.png" width="54px" alt="Generic placeholder image">
      <div class="media-body">
      <p class="my-0"><b>'.$row2['user_email'].' :</b></P>
      <p class="my-0"><i>' . $comment_time . '</i></p>
       ' . $content . '
      </div>
    </div>
    </div>
  ';
  }
  if ($noResult) {
    echo '<div class="jumbotron jumbotron-fluid bg-secondary text-light">
    <div class="container">
      <p class="display-4">No comments found</p>
      <p class="lead">Be the first person to comment!</p>
    </div>
  </div>';
  }
  ?>


  <?php include 'partials/_footer.php';  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>