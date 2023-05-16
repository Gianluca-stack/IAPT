<?php

// create a form validation function
function validateForm($data): string
{
    $data = trim($data);
    $data = stripslashes($data);

    return htmlspecialchars($data);
}

// to check if link is valid
function isValidURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

function indexSearch($link): array
{
    if(empty($link)) {
        return array("error" => "Please enter a url!", "url" => "index.php");
    } else {
        if(!isValidURL($link)) {
            return array("error" => "Please enter a valid url!", "url" => "index.php");
        } else {
            return array("error" => "Url is Valid!", "url" => "news.php");
        }
    }
}

function newspage($link): array
{
    if(empty($link)) {
        return array("error" => "Please enter a url!", "url" => "news.php");
    } else {
        if(!isValidURL($link)) {
            return array("error" => "Please enter a valid url!", "url" => "news.php");
        } else {
            return array("error" => "Url is Valid!", "url" => "news.php");
        }
    }
}