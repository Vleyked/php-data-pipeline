<?php
require __DIR__ . '/vendor/autoload.php';
// require __DIR__ . '/getSuniseSunset.php';
// require __DIR__ . '/getPlaces.php';
require __DIR__ . '/dailyTimes.php';


use Google\Cloud\BigQuery\BigQueryClient;

/**
 * Insert rows into the given table with explicitly giving row ids.
 *
 * @param string $datasetId The BigQuery dataset ID.
 * @param string $tableId The BigQuery table ID.
 * @param string $rowData1 Json encoded data to insert.
 * @param string $rowData2 Json encoded data to insert. For eg,
 *    $rowData1 = json_encode([
 *        "field1" => "value1",
 *        "field2" => "value2"
 *    ]);
 *    $rowData2 = json_encode([
 *        "field1" => "value1",
 *        "field2" => "value2"
 *    ]);
 */
function table_insert_rows_explicit_none_insert_ids(
    string $datasetId,
    string $tableId,
    string $rowData
)  {
    $bigQuery = new BigQueryClient([
        'projectId' => 'high-victor-361803',
        'credentials' => json_decode(file_get_contents('/app/bigquery.json'), true),
    ]);
    $dataset = $bigQuery->dataset($datasetId);
    $table = $dataset->table($tableId);

    $rowData = json_decode($rowData, true);
    // Omitting insert Id's in following rows.
    $rows = [
        ['data' => $rowData]
    ];



    $insertResponse = $table->insertRows($rows);

    if ($insertResponse->failedRows()) {
        $insertResponse = $row['errors'];
        printf('%s: %s' . PHP_EOL, $insertResponse['reason'], $insertResponse['message']);
    }
    // $query = <<<ENDSQL
    // SELECT date
    // FROM `high-victor-361803.vaimo_victor.astronomical`
    // GROUP BY date;
    // ENDSQL;
    // $queryJobConfig = $bigQuery->query($query);
    // $queryResults = $bigQuery->runQuery($queryJobConfig);

    return $queryResults;
}

function execute(): void {
    $places = get_places('./credentials.json', '1156V-Qgf4rv-0aqcVVPVsPlq5zsEgH8GSON6pguzd8Y');
    $response = get_daily_times($places, '2020-08-25');
    $new_dates = new \Ds\Set();

    // foreach ($response as $location => $dates) {
    //     foreach ($dates as $date => $times) {
    //         $set->add($date);
    //     }

    foreach ($response as $location => $dates) {
        foreach ($dates as $date => $times) {
            $new_row = '{"location":"' . $location . '","date":"' . $date . '","dawn":"' . $times[0] . '","dusk":"' . $times[1] . '","sunrise":"' . $times[2] . '","sunset":"' . $times[3] . '"}' . "\n";
            table_insert_rows_explicit_none_insert_ids('vaimo_victor', 'astronomical', $new_row);
        }
    }

}

execute();


// $rowData = json_encode([
//     'location' => 'Test',
//     'date' => '2019-01-01',
//     'dawn' => '6:24:47 AM',
//     'dusk' => '2:25:15 PM',
//     'sunrise' => '7:20:01 AM',
//     'sunset' => '7:20:01 AM'
// ]);

// $queryResults = table_insert_rows_explicit_none_insert_ids('vaimo_victor', 'astronomical',$rowData);
// var_dump($queryResults);

# var_dump($rowData);





?>