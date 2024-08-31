<?php


if (isset($_POST['korisnicko_ime']) && isset($_POST['film']) && isset($_POST['rezervacija_ID'])) {
    include(__DIR__ . '/../common/DBconnect.php');
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $film = $_POST['film'];
    $ID_rezervacije = $_POST['rezervacija_ID'];
    // TS
    //echo "film: $film, ime: $korisnicko_ime, ID: $ID_rezervacije";

    // SQL brisanje rezervacije
    $stmt = $conn->prepare("DELETE FROM rezervacija WHERE  korisnik = ? AND ID_filma = ? AND ID_rezervacije = ?");
    $stmt->bind_param("sss", $korisnicko_ime, $film, $ID_rezervacije);

    if ($stmt->execute()) {
        echo "Rezervacija obrisana!";
    } else {
        echo "Error: " . $stmt->error;
    }


// exit db
    $conn->close();

} else {
    // Troubleshooting
    echo "Error pri brisanju rezervacije.";
}

// $sqlzaDateID = "SELECT ID_termina FROM ID_rezervacije WHERE Termin_dan = '$ID_rezervacije'";
    // $result = $conn->query($sqlzaDateID);
    // if ($result) {
    //     $row = $result->fetch_assoc();
    //     if ($row) {
    //         $terminID = $row['ID_termina'];
    //         echo "Termin ID: " . $terminID;
    //     } else {
    //         echo "No rows found";
    //     }
    //     $result->free();
    // } else {
    //     echo "Error: " . $conn->error;
    // }
?>
    