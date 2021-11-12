<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome to idiscuss!</title>
</head>

<body>
    <!-- put dbconnect above other thing to avoid errors while connecting to the database  -->
    <?php include 'partials/_dbconnect.php';  ?>
    <?php include 'partials/_header.php';  ?>

    <!-- search section starts from here  -->
    <div class="container my-3" style="min-height: 70vh;">
        <!-- this will show what keyword we were seraching for  -->
        <h1>Search results for <em>" <?php echo $_GET['search']; ?> " </em></h1>
        
        <?php
        $noResults = true;
        $searchValue = $_GET["search"];
        $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title,thread_desc) against ('$searchValue');";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $noResults = false; //if we enter in while loop that means there are the things that we searched 
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];

            $thread_id = $row['thread_id']; //we need think for put the lilink in our search result title href url below
            $url = "threads.php?threadid=".$thread_id; //we need this to put it in the href link below
            // display the search result 
            echo '        <div class="result">
                                <h3><a href="'.$url.'">' . $title . '</a></h3>
                                <p>' . $desc . '</p>
                            </div>
                            ';
        }
        if($noResults){
            //if we will not enter the while loop, the $noResult will be true and below will be displayed
            echo '<div class="jumbotron jumbotron-fluid bg-secondary text-light">
    <div class="container">
      <p class="display-4">No resut found</p>
      <p class="lead">Suggestions:
        <ul>
            <li>Make sure that all words are spelled correctly</li>
            <li>Try different keywords</li>
            <li>Try more general keywords</li>
            </ul>
      </p>
    </div>
  </div>';
        }
        ?>
</div>

        <?php include 'partials/_footer.php';  ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>