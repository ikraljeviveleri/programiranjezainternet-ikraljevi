<?php


//include 'DBconnect.php';
include(__DIR__ . '/../common/DBconnect.php');

if (isset($_GET['Film_ID'])) {
    $ID_za_query = $_GET['Film_ID'];

    // SQL query za filmove
    $sql = "SELECT Termin_dan FROM termin WHERE ID_filma = $ID_za_query";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error query: " . $conn->error);
    }

    // Spremi datume u array
    $dates = array();
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['Termin_dan'];
    }

    // Zatvori bazu
    $conn->close();

    // spakiraj u Json i pošalji dates varijablu nazad
    header('Content-Type: application/json');
    echo json_encode($dates);
} else {
    // Ako filmID nije poslan
    echo "Request nije valja - ne postoji FilmID!";
}
?>