<?php

require_once 'app-mechanics.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="useapp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&display=swap" rel="stylesheet">
    <script src="techapp.js"></script>
     <script src="https://kit.fontawesome.com/07913d8309.js" crossorigin="anonymous"></script>
    <title>Main Page</title>
</head>
<body>
<div class="container">
    <div class="app_title">
        <h1>Location Chronicles</h1>
    </div>
    <div class="search_container">
        <form action="app-mechanics.php" method="post">
                <label>
                    <input class="search_input" type="search" placeholder="https://timesofmalta.com" name="search">
                </label>
                <span>
                    <input type="submit" value="Go" class="search">
                </span>
        </form>
        <span class="error_message">
            <?php
            if(isset($_SESSION["message"])){
                echo $_SESSION["message"];
            }
            ?>
        </span>
    </div>

</div>
</body>
</html>