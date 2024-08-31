<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "programiranjezainterntet";
$tableName = "filmovi";
$port = 3307;

// spajanje na bazu
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// error check za spajanje na bazu
if ($conn->connect_error) {
    die("Fail pri spajanju na bazu: " . $conn->connect_error);
}

?>