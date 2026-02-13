<?php
    $server = "localhost";

    $username = "root";

    $password = "";

    $db = "fruitkha_db";

    $conn = mysqli_connect($server, $username, $password, $db);

    if($conn){
        // echo "database conneected";
    }else{
        echo 'connection error';
    }
?>