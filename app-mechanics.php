<?php

session_start();

require 'queryValidation.php';
require 'news_article_scraping.php';
require 'NER.php';


// Check if the link is valid

$link = "";
$urlResult = NULL;
$article_data = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $link = validateForm($_POST["search"]);
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
        // Scraping article from the provided url
        $article_data = scraping($link);
        $size = count($article_data);
        $_SESSION["results"] = $size;
        $seperated_data = array();
        $numberOfLocations = 0;

        // NER algorithm
        for($i = 0; $i < $size; $i++){
            $temp_paragraph = $article_data[$i];

            $token = strtok($temp_paragraph, " ");

            while($token != false){

                $temp_token = "";

                // Remove punctuation
                for($j = 0; $j < strlen($token); $j++){
                    if($token[$j] != "." && $token[$j] != "," && $token[$j] != "?" && $token[$j] != "!" && $token[$j] != ":" && $token[$j] != ";"){
                        $temp_token .= $token[$j];
                    }
                }
                $seperated_data[] = $temp_token;
                $token = strtok(" ");
            }
        }
    }

    exit();
}


