<?php

session_start();

require 'queryValidation.php';
require 'news_article_scraping.php';

require 'dbconn.php';

// Check if the link is valid

$link = "";
$urlResult = NULL;
$article_data = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") { # If the form is submitted

    # Set connection to database
    $conn = OpenCon();

    # Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    # Validate the form
    $link = validateForm($_POST["search"]);
    # Store the previous url
    $previous_url = $_SERVER['HTTP_REFERER'];

    if($previous_url == "http://localhost/IAPT/IAPT/index.php"){

        $urlResult = indexSearch($link);

    } else if ($previous_url == "http://localhost/IAPT/IAPT/news.php"){

        $urlResult = newspage($link);

    }

    $_SESSION["url"] = $urlResult["url"];

    if ($urlResult["error"]) {

        $error = $urlResult["error"];
        $_SESSION["message"] = $error;
    }

    header("Location: " . $urlResult["url"]);

    if ($urlResult["error"] == "Url is Valid!") {

        // ----------------- SCRAPING -----------------

        $article_data = scraping($link);
        $size = count($article_data);
        $_SESSION["results"] = $size;
        $numberOfLocations = 0;
        $full_string = "";

        // ----------------- NER -----------------
  
        for ($i = 0; $i < $size; $i++) {
            $full_string .= $article_data[$i] . ' ';
        }

        $args = array(
            'text' => $full_string,
        );

        $serializedArgs = json_encode($args);

        $output = shell_exec("python NER.py '$serializedArgs'");

        $result = json_decode($output, true);

        // ----------------- GEOCODING -----------------

        // store each location coordinates in an array
        $locations_coordinates = array();
      
        foreach ($result as $location) {

            $args_geocoding = $location;

            $serializedArgs_geocoding = json_encode($args_geocoding);
    
            $output_geocoding = shell_exec("python getcoordinates.py '$serializedArgs_geocoding'");
            
            $result_geocoding = json_decode($output_geocoding, true);
    
            // array_push($locations_coordinates, $result_geocoding);
            // if result_geocoding is empty, don't add it to the array
            if (!empty($result_geocoding)) {
                array_push($locations_coordinates, $result_geocoding);
            }
        }


        $_SESSION["locations"] = $locations_coordinates;

        // ----------------- DATABASE [Retrieving Articles] -----------------

        // Fetch articles which match the location and store all the articles in an array
        $articles = array();

        foreach ($locations_coordinates as $location_data) {

            $lat = $location_data["latitude"];
            $long = $location_data["longitude"];

            $sql = "SELECT * FROM articles WHERE latitude = '$lat' AND longitude = '$long';";
            $result = mysqli_query($conn, $sql);
            $resultcheck = mysqli_num_rows($result);

            if ($resultcheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($articles, $row);
                }
            }
            
        }

        // Store it in a session
        $_SESSION["articles"] = $articles;

    }

    CloseCon($conn);

    exit();
}


