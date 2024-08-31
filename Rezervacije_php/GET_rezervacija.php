<?php
include(__DIR__ . '/../common/DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // varijable iz upravljaj_rezervacijom
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $film = $_POST['film'];
    $ID_rezervacije = $_POST['rezervacija_ID'];

    // Query baze
    $sql = "SELECT * FROM rezervacija WHERE korisnik = '$korisnicko_ime' AND ID_filma = '$film' AND ID_rezervacije ='$ID_rezervacije'";
    $result2 = $conn->query($sql);

    if ($result2->num_rows > 0) {
        // Rezervacija pronađena!
        echo "Pronađena rezervacija $ID_rezervacije za korisnika $korisnicko_ime, odabrani film: $film.<br>";
    } else {
        // za troubleshooting!
        echo "Rezervacija za korisnika $korisnicko_ime s brojem rezervacije $ID_rezervacije NE postoji!";
    }
}

$conn->close();
?>