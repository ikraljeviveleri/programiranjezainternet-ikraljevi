<?php
include(__DIR__ . '/../common/DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$phpFILM = isset($_POST["ID_Filma"]) ? $_POST["ID_Filma"] : "";
$phpTERMIN = $_POST["termin"];
$phpBROJMJESTA = $_POST["broj_mjesta"];
$phpKORISNIK = $_POST["korisnicko_ime"];

// pronađi TerminID - kako bi uspješno spremio u tablicu sve rezultate
    $sqlzaDateID = "SELECT ID_termina FROM termin WHERE Termin_dan = '$phpTERMIN'";
    $result = $conn->query($sqlzaDateID);
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $terminID = $row['ID_termina'];
            //echo "Termin ID: " . $terminID;
        } else {
            echo "TerminID nije pronađen";
        }
        $result->free();
    } else {
        echo "Error: " . $conn->error;
    }

// Spremi rezervaciju u tablciu
$sql = "INSERT INTO rezervacija (ID_filma, ID_termina, broj_mjesta, korisnik) VALUES ('$phpFILM', '$terminID', '$phpBROJMJESTA', '$phpKORISNIK')";

// ako oke -> print
if ($conn->query($sql) === TRUE) {
    $result = mysqli_query($conn, "SELECT LAST_INSERT_ID()");
    $row = mysqli_fetch_row($result);
    $Id_rezervacije = $row[0];

    // echo "Test posljednje dodanog ID rezervacije " . $Id_rezervacije;
    echo "Podatci uspješno uneseni - možete se vratiti na prijašnju stranicu! ID vaše rezervacije: $Id_rezervacije";
    // json format, detalji erzervacije
    // echo json_encode([
    //     'ID_rezervacije' => $Id_rezervacije,
    //     'ime' => $phpKORISNIK,
    //     'film' => $phpFILM,
    //     'termin' => $phpTERMIN,
    //     'broj_mjesta' => $phpBROJMJESTA
    // ]);

} else {
    echo "PROBLEM PRI UNOSU: " . $sql . "<br>" . $conn->error;
}

// exit
$conn->close();
}


?>