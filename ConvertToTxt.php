<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '5G');
error_reporting(E_ALL);
ini_set('max_execution_time', '30000'); // 300 seconds = 5 minutes

$customDbHost = 'localhost';
$customDbUser = 'root';
$customDbPass = 'Root@123';
$customDbName = 'lawaro_29jan_2024';

$pdo = new PDO("mysql:host=$customDbHost;dbname=$customDbName", $customDbUser, $customDbPass);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = 'catalog_category_entity_int';
$selectSql = "SELECT * FROM $tableName WHERE attribute_id = 140 AND value != 0 AND store_id = 0";

try {
    $stmt = $pdo->query($selectSql);

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $category_value = fopen('category_value.txt', 'w');
    if ($category_value) {
        foreach ($results as $result) {
            $query = "UPDATE $tableName SET value = {$result['value']} WHERE entity_id = {$result['entity_id']} AND attribute_id = 140;";
            fwrite($category_value, $query . PHP_EOL);
        }
        fclose($category_value);
    } else {
        echo "Failed to open category_value.txt for writing.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>
