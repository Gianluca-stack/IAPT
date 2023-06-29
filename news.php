<?php
    require_once 'app-mechanics.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    // add a marker for each location
        window.onload = function(){
            <?php for ($i=0; $i < count($_SESSION["locations"]); $i++): ?>
                var lat = <?php echo $_SESSION["locations"][$i]["latitude"]; ?>;
                var lng = <?php echo $_SESSION["locations"][$i]["longitude"]; ?>;
                var location = {lat: lat, lng: lng};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 11,
                    center: location
                });
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            <?php endfor; ?>
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
        <div id="map"></div>
    </div>

    <div class="search_results">
        <h3 class="results">
            Location/s:
            <?php 
            
            for($i = 0; $i < count($_SESSION["locations"]); $i++): 

                if($i == count($_SESSION["locations"]) - 1){
                    echo $_SESSION["locations"][$i]["location"];
                }else{
                    echo $_SESSION["locations"][$i]["location"] . ", ";
                }

            endfor;
                
            ?>
            |
            Articles:
            <?php
                echo count($_SESSION["articles"]);
            ?>
        </h3>
    </div>

    <div class="grid-container">
        <?php for($i = 0; $i < count($_SESSION["articles"]); $i++): ?>
                <div class="news-container">
                    <div class="view-overlay">
                        <a href="<?php echo $_SESSION["articles"][$i]["article_url"] ?>" class="view-button" target="_blank" >View</a>
                    </div>
                    <div class="news-content">
                        <div class="news-flex">
                            <section class="news-details">
                                <div class="location">
                                    <h3>Location: <?php echo $_SESSION["articles"][$i]["article_location"] ?></h3>
                                </div>
                                <div class="date">
                                    <h3>Date: <?php echo $_SESSION["articles"][$i]["article_date"] ?></h3>
                                </div>
                            </section>
                        </div>
                        <div class="description">
                            <div>
                                <h2><?php echo $_SESSION["articles"][$i]["article_title"] ?></h2>
                            </div>
                            <div>
                                <h4>Abstract</h4>
                            </div>
                            <section class="description">
                                <p><?php echo $_SESSION["articles"][$i]["article_desc"] ?></p>
                            </section>
                            <div>
                                <h3>By <?php echo $_SESSION["articles"][$i]["article_publisher"] ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endfor; ?>
    </div>
    <!-- add feedback button -->
    <div class="feedback">
        <button class="feedback-button" onclick="FeedbackPage();">Feedback</button>
    </div>
</body>
</html>