<?php
session_start();
echo 'logging you out...please wait...';

session_destroy();
session_unset();
//after doing the above action, our username and password will be removed and we will redirect to index.php
header("Location:/CWH-php/3_forum_website_project/index.php")
?>