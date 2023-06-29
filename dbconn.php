<?php

# This file is used to connect to the database
function OpenCon(){
    # Set connection variables
    $dbhost = "localhost"; 
    $dbuser = "Gianluca_Sciberras";
    $dbpass = "Anex26!@";
    $db = "location_chronicles";

    # Create connection, if connection fails, print error and returns code error
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connection failed: %s\n". $conn -> error);

    # Return connection
    return $conn;

}

# This function is used to close the connection
function CloseCon($conn){
    # Close connection
    $conn -> close();
}