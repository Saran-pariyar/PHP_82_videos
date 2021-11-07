<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <title>Welcome to idiscuss!</title>
</head>

<body>
  <?php include 'partials/_header.php';  ?>
  <?php include 'partials/_dbconnect.php';  ?>
  <?php
  $id = $_GET['threadid']; 
  $sql = " SELECT * FROM `threads` WHERE thread_id=$id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
  }
  ?>
  <?php
$showAlert = false;
$method = $_SERVER['REQUEST_METHOD'];
// echo $method;
if ($method == "POST"){
  // insert comment into database 
  $comment =$_POST['comment']; //getting from the form below
  
  $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '0', current_timestamp());";
  $result = mysqli_query($conn, $sql);
  $showAlert = true;

  if($showAlert){
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
      <p><b>Posted by Harry</b></p>
    </div>
  </div>

  <?php
$showAlert = false;
$method = $_SERVER['REQUEST_METHOD'];
// echo $method;
if ($method == "POST"){
  // insert thread into database 
  $th_title =$_POST['title']; //getting from the form below
  $th_desc = $_POST['desc'];
  $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '0', current_timestamp());";
  $result = mysqli_query($conn, $sql);
//   $showAlert = true;

//   if($showAlert){
//     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
//              <strong>Success!</strong>  Your thread has been successfully added.Please wait for community to respond.
//               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//           </div>';
//   }
}
?>


<div class="container">
  <h1 class="container">Post a comment</h1>
  <form action="<?php $_SERVER['REQUEST_URI']; //we gave request uri so that it also acceptsthe url after '?'sign ?>" method="POST">
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
      <textarea class="form-control" id="comment" name='comment' rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Post comment</button>
  </form>
  </div>

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
    echo '
    <div class="container bg-light">
    <div class="media my-3 mr-3">
      <img class="mr-3" src="img/userdefault.png" width="54px" alt="Generic placeholder image">
      <div class="media-body">
      <p class="my-0"><b>Anonymous user :</b></P>
      <p class="my-0"><i>'.$comment_time.'</i></p>
       '.$content.'
      </div>
    </div>
    </div>
  ';
  }
  if ($noResult) {
    echo '<div class="jumbotron jumbotron-fluid bg-secondary text-light">
    <div class="container">
      <p class="display-4">No threads found</p>
      <p class="lead">Be the first person question!</p>
    </div>
  </div>';
  }
  ?>
  
  
  <?php include 'partials/_footer.php';  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>