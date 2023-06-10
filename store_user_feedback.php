<?php

// ----------------- DATABASE CONNECTION -----------------

include 'dbconn.php';

// ----------------- SET CONNECTION TO DATABASE -----------------

$conn = OpenCon();

// ----------------- CHECK CONNECTION -----------------

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ----------------- VARIABLES -----------------

$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

// ----------------- INSERT DATA INTO DATABASE -----------------

$sql = "INSERT INTO user_feedback (user_name, user_email, user_message) VALUES ('$name', '$email', '$message')";
// use mysqli()
$result = mysqli_query($conn, $sql);

// ----------------- STORE RESULT -----------------

if ($result) {
    $_SESSION["message"] = "Feedback sent successfully!";
} else {
    $_SESSION["message"] = "Feedback not sent!";
}

// ----------------- REDIRECT TO FEEDBACK PAGE -----------------

header("Location: User_feedback.php");

// ----------------- CLOSE CONNECTION -----------------

CloseCon($conn);

?>
