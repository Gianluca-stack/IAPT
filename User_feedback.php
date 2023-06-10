<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="feedback_form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
    <script src="techapp.js"></script>
    <script src="https://kit.fontawesome.com/07913d8309.js" crossorigin="anonymous"></script>
    <title>Feedback</title>
</head>
<body>
            <div class="navbar-container">
                <div class="navbar">
                    <h1 class="app_title" onclick="HomePage();">Location Chronicles</h1>
                    <ul class="nav-list">
                            <li class="nav-item">
                                <a href="news.php" class="nav-link" id="News"><i class="fa-solid fa-arrow-left"></i></a>
                            </li>
                    </ul>
                 </div>
            </div>

            <!-- feedback form -->
            <div class="feedback_form">
                <form action="store_user_feedback.php" method="post">
                    <div class="feedback_form_container">
                        <div class="feedback_form_title">
                            <h2>Feedback</h2>
                        </div>
                        <hr>
                        <div class="feedback_form_content">
                            <div class="feedback_form_content_name">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="feedback_form_content_email">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="feedback_form_content_message">
                                <textarea name="message" id="message" class="form-control" cols="30" rows="10" placeholder="Enter your message" required></textarea>
                            </div>
                            <div class="feedback_form_content_submit">
                                <input type="submit" value="Submit" name="submit" id="submit">
                            </div>
                        </div>
                    </div>
                </form>
                <span class="error_message">
                    <?php
                        if (isset($_SESSION["message"])) {
                            echo $_SESSION["message"];
                            unset($_SESSION["message"]);
                        }
                    ?>
                </span>
            </div>
</body>
</html>