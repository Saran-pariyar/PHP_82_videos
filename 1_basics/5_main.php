<?php
require '5_dataConnect.php'; 
// include '5_dataConnect.php'; 

// require will not let other code run if file is not found 
// include  will  let other code run if file is not found (Just give warning but other code will run)
//both will show error if there is syntaxt error in the file that you included,required
                     //working with file
$text_file = readfile('5_myFile.txt');
echo $text_file; //this will also return the number of character in the file
echo '<br>';
readfile('5_myFile.txt'); //directly do this if you don't want the number of characters 

$fileptr = fopen("5_myFile.txt" , "r"); 
if(!$fileptr){
    die("<br> There is an error while connecting to the file <br>");
}
else{
    echo "<br>Sucessfully connected <br>";
}
// $content = fread($fileptr , 6); //this will read only 6 characters of file , including spaces too
$content = fread($fileptr , filesize('5_myFile.txt')); //this will read all the characters in the file
echo $content;
// echo fgets($fileptr); //this will only read the first line of the file //you can read all thing by using while loop till it return false
// echo fgetc($fileptr); //only reads characters, (you can use them in a loop and make it run till you find a character that you want)
fclose($content); //to free the memory for another resource
fclose($fileptr);
echo "<br>";

?>