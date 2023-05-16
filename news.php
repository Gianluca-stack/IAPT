<?php
    require_once 'app-mechanics.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="usenews_page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
    <script src="techapp.js"></script>
    <script src="https://kit.fontawesome.com/07913d8309.js" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBLb1a4yud9V2PiKFXTEI2VYrWv6Yfggg&libraries=places"></script>
    <script>
        window.onload = function(){
            getCityCoordinates();
        };
    </script>
    <title>News</title>
</head>
    <body>
        <div class="navbar-container">
            <div class="navbar">
                <h1 class="app_title" onclick="HomePage();">Location Chronicles</h1>
                <div class="news-search">
                    <form action="app-mechanics.php" method="post">
                        <label>
                            <input class="nav_search_input" type="search" placeholder="https://timesofmalta.com" name="search">
                        </label>
                        <span>
                            <input type="submit" value="Go" class="nav_search">
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
        </div>

        <div class="map_container">
              <div id="map">
                   
              </div>
        </div>

        <div class="search_results">
            <h3 class="results">News Articles found:
                <?php
                    if(isset($_SESSION["results"])){
                        echo $_SESSION["results"];
                    }
                ?>
            </h3>
        </div>
        <div class="grid-container">
            <?php for($i = 1; $i <= 10; $i++): ?>
                <div class="news-container">
                    <div class="news-flex">
                        <section class="news-details">
                            <div class="location">
                                <h3>Location: Valletta</h3>
                            </div>
                            <div class="date">
                                <h3>Date: 20/11/2022</h3>
                            </div>
                        </section>
                    </div>
                    <!-- <div class="view-article">
                        <h4>View</h4>
                    </div> -->
                    <div class="description">
                        <div>
                            <h2>Panama Papers</h2>
                        </div>
                        <div>
                            <h4>Abstract</h4>
                        </div>
                        <section class="description">
                            <p>The journalists on the investigative team found business transactions by many important figures
                                in world politics, sports, and art. While many of the transactions were legal, since the data is incomplete, questions remain in many other cases; still others
                                seem to clearly indicate ethical if not legal impropriety. Some disclosures –
                                tax avoidance in very poor countries by very wealthy entities and individuals for example</p>
                        </section>
                        <div>
                            <h3>By Newsbook</h3>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </body>
</html>




