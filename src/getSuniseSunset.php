<?php

function get_sunrise_sunset($date, $lat, $lng) {
    // "https://api.sunrisesunset.io/json?lat=38.907192&lng=-77.036873&date=1990-05-22";
    // Initialize cURL session

    $url = "https://api.sunrisesunset.io/json?lat=$lat&lng=$lng&timezone=UTC&date=$date";
    
    $ch = curl_init();
    // Set the URL to call and other cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec($ch);

    curl_close($ch);
    $response = json_decode($response, true);
    
    return $response;
}

// $response = get_sunrise_sunset('1990-05-22', '38.907192', '-77.036873');

// var_dump($response["results"]["sunset"]);
// var_dump($response["results"]["sunrise"]);

?>