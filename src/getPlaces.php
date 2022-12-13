<?php

require_once 'vendor/autoload.php';

function get_places(string $path_credentials, string $spreadsheetId) {
    // configure the Google Client
    $client = new \Google_Client();
    $client->setApplicationName('Google Sheets API');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType('offline');
    $path = $path_credentials;
    $client->setAuthConfig($path);

    // configure the Sheets Service
    $service = new \Google_Service_Sheets($client);

    $spreadsheetId = $spreadsheetId;
    $spreadsheet = $service->spreadsheets->get($spreadsheetId);

    // Read the data from the spreadsheet
    $range = 'Sheet1';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    // Print the data
    $places = array();

    if (empty($values)) {
        printf("No data found.\n");
    } else {
        foreach ($values as $row) {
            if ($row[0] != "Name"){
                $places[$row[0]] = [$row[1], $row[2]];
            }
        }
    }

    return $places;
}

// $places = get_places('./credentials.json', '1156V-Qgf4rv-0aqcVVPVsPlq5zsEgH8GSON6pguzd8Y');
// var_dump($places);

?>