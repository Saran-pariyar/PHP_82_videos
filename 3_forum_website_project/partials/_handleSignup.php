<?php
//the below 3 lines will show the errors in the code on the browser page
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);
//now if the request method is post, we will do the following action
$showError = "false";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //it will connect to the DB if the request method is 'post'
    include '_dbconnect.php';
    // getting items with name in the form 
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];

    //checking whether this email exists 
    $existSQL = "SELECT * FROM `users` WHERE user_email='$user_email'";
    //we took the $conn variable from the _dbconnect.php that we included
    $result = mysqli_query($conn, $existSQL);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $showError = "Email already in use";
    }
    //this else will run if the given email does not exist 
    else {
        if ($pass == $cpass) {
            //  making the hash of the password 
            $hash = password_hash($pass,PASSWORD_DEFAULT);
            //we removed sno because it is auto incremented and we used $hash in the password to store it as hash code
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            echo $result;

            if($result){
                $showAlert = true;
                //after the signup is successful, the person will be redirected to the hompage
                // and the signupsuccess = true line 
                header("Location:/CWH-php/3_forum_website_project/index.php?signupsuccess=true");
                exit();//exiting after the signup is done
            }
        }
        //shows error if the password and confirm password did not match
        else {
            $showError = "Password did not match";
        }
    }
    //if signup failed, they will be redirected to  this link
    header("Location:/CWH-php/3_forum_website_project/index.php?signupsuccess=false&error=$showError");


}

?>