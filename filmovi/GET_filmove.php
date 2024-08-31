<?php
include(__DIR__ . '/../common/DBconnect.php');

// prikaži ako postoji error
error_reporting(E_ALL);  
ini_set('display_errors', 1);

// Prikaži sve iz tablice 
$sql = "SELECT * FROM $tableName";
$result = $conn->query($sql);

// Error provjera
if ($result === false) {
    die("Error executing query: " . $conn->error);
}