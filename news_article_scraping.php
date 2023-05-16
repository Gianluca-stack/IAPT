<?php

require_once __DIR__ . "../../vendor/autoload.php";

use voku\helper\HtmlDomParser;

function scraping($url): int|array|string|null
{
//    $url = "https://timesofmalta.com/articles/view/abela-says-delay-magisterial-inquiry-sofias-death-unacceptable.1025159";

// cURL request
    $curl = curl_init();
// url to reach with a GET HTTP request
    curl_setopt($curl, CURLOPT_URL, $url);
// returned data as a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
// execute curl request and get HTML of the page as a string
    $html = curl_exec($curl);
// release curl resources

    if ($html  === false){
        return "Error: " . curl_error($curl);
    }

    $dom = HtmlDomParser::str_get_html($html);

    if(!$dom){
        return "Error: Invalid HTMl String";
    }

    $data = $dom->find("p")->text;

    curl_close($curl);

    return $data;
}