<?php
require __DIR__ . '/getSuniseSunset.php';
require __DIR__ . '/getPlaces.php';

function get_three_month($date) {
    $date = new DateTime($date);
    $date->modify('+3 month');
    return $date->format('Y-m-d');
}

// function get_three_month($date) {
//     $date = new DateTime($date);
//     $date->modify('+1 day');
//     return $date->format('Y-m-d');
// }

function get_daily_times($places, $date) {
    
    $date = new DateTime($date);
    $date = $date->format('Y-m-d');
    $date_end = get_three_month($date);
    $daily_times = array();
    while ($date <= $date_end) {
        foreach ($places as $place => $coordinates) {
            $lat = $coordinates[0];
            $lng = $coordinates[1];
            $sunrise_sunset = get_sunrise_sunset($date, $lat, $lng);
            $sunrise_sunset = $sunrise_sunset["results"];
            $values = array( $sunrise_sunset["dawn"], $sunrise_sunset["dusk"], $sunrise_sunset["sunrise"], $sunrise_sunset["sunset"] );
            $daily_times[$place][$date] = $values;
        }
        $date = new DateTime($date);
        $date->modify('+1 day');
        $date = $date->format('Y-m-d');
    }
    return $daily_times;
}

// $places = get_places('./credentials.json', '1156V-Qgf4rv-0aqcVVPVsPlq5zsEgH8GSON6pguzd8Y');
// $response = get_daily_times($places, '2020-08-23');

# var_dump($response);

?>