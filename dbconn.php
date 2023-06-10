<?php

function OpenCon(){
    $dbhost = "localhost";
    $dbuser = "Gianluca_Sciberras";
    $dbpass = "Anex26!@";
    $db = "location_chronicles";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connection failed: %s\n". $conn -> error);

    return $conn;

}

function CloseCon($conn){
    $conn -> close();
}