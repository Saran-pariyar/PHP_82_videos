<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">Hello</div>
    <?php
    echo "Hello world";
    //single line comment
    $a = 1; 
    $b = 2;

    $a += 1;
    echo "<br>";
    echo $a + $b;
    echo "<br>";

    //comparison operator returns binary
    echo var_dump(1 <= 4);
    echo "<br>";
    $myVar = (false xor true); //xor will return true if one is true and another is false
    echo $myVar;

    echo "<br>";
    $dataType = "67";
    echo var_dump($dataType);
    echo "<br>";
    echo $dataType;

    //defining a constant datatype
    define('PI' , 3.14); //better to define a constant datatype at top
    echo "<br>";
    echo PI;

    function associative_array(){
        $favCol = array('shubam' => 'red', 'rohan' => 'green', 'harry' =>'brown'  );
         foreach ($favCol as $key => $value){
        echo "Favorite color of $key is $value <br>";}}
    
    function others_imp(){
        $dateVar = date("dS F Y , g:i A"); //you can see the parameters that you can use to get different       date results
        echo "Today's date is $dateVar <br>";
        $d = date("Y");
        echo "Copyright $d | All rights reserved"; //do it so that you don't have to change the date with       time of many pages in your site
        }
    ?>
</body>
</html>