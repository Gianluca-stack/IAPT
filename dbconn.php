<?php

$server_name = "localhost";
$username = "root";
$pwd = "Anex26!@";
$db_name = "Location Chronicles";

$conn = new mysqli($server_name, $username, $pwd, $db_name);

if ($conn->connect_error){

    die("Connection Failed: \n".$conn->connect_error);

}else{

    echo "Connection Successful! \n";

}