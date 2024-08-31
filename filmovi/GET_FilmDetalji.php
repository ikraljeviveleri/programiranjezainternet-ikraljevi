<?php

//include 'DBconnect.php';
include(__DIR__ . '/../common/DBconnect.php');

$query = "SELECT * FROM $tableVariable";
            
$result = mysqli_query($conn, $query);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if (mysqli_num_rows($result) > 0) {
    $popis = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $popis = [];
}

?>