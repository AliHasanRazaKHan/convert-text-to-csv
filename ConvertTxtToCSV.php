<?php
// Set error reporting and memory limit
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '5G');
error_reporting(E_ALL);
ini_set('max_execution_time', '30000'); // 300 seconds = 5 minutes

$logs = fopen("logs.txt", "r");
$logsData = [];

if (($logs = fopen("logs.txt", "r")) !== FALSE) {
    while (($rows = fgetcsv($logs, 1000, "\t")) !== FALSE) {
        $logsData[] = $rows;
    }
    fclose($logs);
}

$logsCsv = fopen('Output/logs.csv', 'w');
if ($logsCsv !== FALSE) {
    foreach ($logsData as $log) {
        $rowData = []; // Initialize an array to hold the data for a single row
        foreach ($log as $data) {
            $rowData = array_merge($rowData, explode(' ', $data));
        }

        if (fputcsv($logsCsv, $rowData) === false) {
            echo "Error writing to CSV file.";
            break;
        }
    }
    fclose($logsCsv);
} else {
    echo "Failed to open output file.";
}
?>
