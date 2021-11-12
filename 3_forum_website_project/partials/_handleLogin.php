<?php
//the below 3 lines will show the errors in the code on the browser page
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//now if the request method is post, we will do the following action
$showError = "false";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    //checking if there is any email in db
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        //we are checking if $pass is equal to the 'user_pass' from the database (user_pass is from database)
        if (password_verify($pass, $row['user_pass'])) {
            //session will start if success
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno']; //we need this so that we can get the sno of the user to know who asked question or posted comment
            //the above $_SESSION['sno'] will store the sno of the user that posted the comment or discussion
            $_SESSION['useremail'] = $email;
            
            header("Location:/CWH-php/3_forum_website_project/index.php");
            exit();
        }
        //whatever happens, we will be redirectd to the homepage
        header("Location:/CWH-php/3_forum_website_project/index.php");
    }
}
