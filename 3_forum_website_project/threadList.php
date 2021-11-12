<!-- //the only thing threadList.php need from the index.php is catid value, from the url  -->
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
  // the catid in index.php is taken from the $id variable from there and is used here so that it has same id value 
  // we will get the catid for the $id from the hreflink in the index.php, that we give
  $id = $_GET['catid']; //this is id that we got from the link (line number 65 of index.php) and it can be of any name, not just 'catid'
  $sql = " SELECT * FROM `categories` WHERE category_id=$id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
  }
  ?>

  <?php
  // the below code will add question with title and description 
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];
  // echo $method;
  if ($method == "POST") {
    // insert thread into database 
    $th_title = $_POST['title']; //getting from the form below
    $th_desc = $_POST['desc'];

//making sure that users does not accidently input html tags 
    // saving site from potential XSS attacks 
    $th_title = str_replace("<","&lt;",$th_title); //if there is a "<" tag, it will be replaced with &lt; which is html entities for that sign 
    $th_title = str_replace(">","&gt;",$th_title);

    $th_desc = str_replace("<","&lt;",$th_desc); //if there is a "<" tag, it will be replaced with &lt; which is html entities for that sign 
    $th_desc = str_replace(">","&gt;",$th_desc);

    $sno = $_POST['sno'];//getting value from the hidden input from the form below, we did the same thing in comment too
    $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp());";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;

    if ($showAlert) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong>  Your thread has been successfully added.Please wait for community to respond.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
  }
  ?>
  <div class="container my-4 bg-light">
    <div class="jumbotron">
      <h1 class="display-4">Welcome to <?php echo $catname ?> forums</h1>
      <p class="lead">
        <?php echo $catdesc ?>
      </p>
      <p>This is a peer to peer forum to share knowledge</p>
      <div class="btn btn-success btn-lg" href="#" role="button">Learn more </div>
    </div>
  </div>

  <?php
  // <!-- code to start discussion if we are logged in  -->

  //This 'start a discussion' form will be printed if we are logged in 
  // the below if condition is the way to find if user is logged in or not 
  //the below line that will give us form to start the discussion will be echod if are logged in
  if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {    

    // in form action, we gave request uri so that it also acceptsthe url after "?"sign

    echo ' <div class="container">
  <h1 class="container">Start a discussion</h1>
  <form action="'. $_SERVER["REQUEST_URI"].'" method="POST">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Problem Title </label>
      <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">Keep title as short as possible</div>
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Elaborate your concern</label>
      <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
      <input type="hidden" name="sno" value="'.$_SESSION['sno'].'"
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
  </div>';
  } 
  else {
    echo '<div class="container">
        <h1 class="container">Start a discussion</h1>
      <p class="lead">You are not logged in. Please log in to start discussion</p>
      </div>
    
    ';
  }
  ?>

  <h1 class="container">Browser Questions</h1>

  <?php
  $id = $_GET['catid'];
  $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
  $result = mysqli_query($conn, $sql);

  $noResult = true;
  while ($row = mysqli_fetch_assoc($result)) {
    $noResult = false;
    $id = $row['thread_id'];
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_time = $row['timestamp'];
    $thread_user_id = $row['thread_user_id']; //getting thread_user_id from the 'threads' table

    $sql2 = "SELECT user_email FROM `users` WHERE sno = $thread_user_id;"; //for gettin the user email id to display
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2); //it will store the column that we want (there can only be one column with our given thread_user_id) ...
    // $row2['user_email']; --we will use this in below string  to get the email of the user 

    


    //this string will print the question, title and little description from the database(threadList)
    echo '
    <div class="container bg-light">
    <div class="media my-3 mr-3">
      <img class="mr-3" src="img/userdefault.png" width="54px" alt="Generic placeholder image">
      <div class="media-body">
      <p class="my-0">Asked by: <b>'.$row2['user_email'].'</b></P>
      <p class="my-0"><i>' . $thread_time . '</i></p>
       <h5 class="mt-0 "><a class="text-dark" href="threads.php?threadid=' . $id . '">' . $title . '</a></h5> 
        <p>' . $desc . '</p> 
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