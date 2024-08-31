<?php
        include(__DIR__ . '/../common/DBconnect.php');
        // Cookie polja
        $PRIJE_MOD_korisnicko_ime = $_COOKIE['PRIJE_MOD_korisnicko_ime'];
        $PRIJE_MOD_film = $_COOKIE['PRIJE_MOD_film'];
        $PRIJE_MOD_rezervacija = $_COOKIE['PRIJE_MOD_ID_rezervacije'];
        // varijable za nova polja
        $termin = $_POST['termin'];
        $film = $_POST['film'];
        $brojmjesta = $_POST["broj_mjesta"];

        // sql za pronac terminID ovisno o terminu
        $sqlzaDateID = "SELECT ID_termina FROM termin WHERE Termin_dan = '$termin'";      
        $result = $conn->query($sqlzaDateID);
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $ID_termina = $row['ID_termina'];
                // TS
                //echo "Termin ID: " . $ID_termina;
                
            } else {
                echo "error pri result var";
            }
            $result->free();
        } else {
            echo "Error: " . $conn->error;
        }
        
        // TS!
        //echo "UPDATE rezervacija  INNER JOIN termin ON rezervacija.ID_termina = termin.ID_termina  SET rezervacija.ID_termina = termin.ID_termina, rezervacija.ID_filma = '$film', rezervacija.broj_mjesta = '$brojmjesta'  WHERE rezervacija.korisnik = '$PRIJE_MOD_korisnicko_ime' AND rezervacija.ID_rezervacije = '$PRIJE_MOD_rezervacija'";
        
        $sql = "UPDATE rezervacija  INNER JOIN termin ON rezervacija.ID_termina = termin.ID_termina  SET rezervacija.ID_termina = termin.ID_termina, rezervacija.ID_filma = '$film', rezervacija.broj_mjesta = '$brojmjesta'  WHERE rezervacija.korisnik = '$PRIJE_MOD_korisnicko_ime' AND rezervacija.ID_rezervacije = '$PRIJE_MOD_rezervacija'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Podatci uspješno uneseni!";
        } else {
            echo "PROBLEM PRI UNOSU: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        