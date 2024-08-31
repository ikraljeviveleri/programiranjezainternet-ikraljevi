<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

</head>

<!-- Skripte za upravljanje modalom -->
<script>
    // Funkcija za otvaranje modala za svaki film
    function openModal(ID_Filma) {
        var modal = document.getElementById('modal-' + ID_Filma);
        modal.style.display = "block";

        var ID_Filma_za_termin = ID_Filma;
        // start
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //JSon parse
            var var_termini = JSON.parse(this.responseText);

            // popis termina s servera -> modal
            var popisTermina = modal.querySelector("#termin");
            popisTermina.innerHTML = "";

            // za svaki termin -> polje
            var_termini.forEach(function(date) {
                var option = document.createElement("option");
                option.text = date;
                option.value = date;
                popisTermina.add(option);
            });
        }

    };

    // GET za termine ovisno o ID_Filma
    xhr.open("GET", "filmovi/GET_Datumi_za_Film.php?Film_ID=" + ID_Filma_za_termin, true);
    xhr.send();

    }
    

    // Exit button
    function closeModal(ID_Filma) {
        var modal = document.getElementById('modal-' + ID_Filma);
        modal.style.display = "none";
    }

    // Funkcija koja zatvara modal ako klikneš van modala
    window.onclick = function(event) {
        var modals = document.getElementsByClassName('modal');
        for (var i = 0; i < modals.length; i++) {
            if (event.target == modals[i]) {
                modals[i].style.display = "none";
            }
        }
    }

</script>

<body>
<!-- Navigacija -->
<div>
    <nav>
        <a href="index_page.html">Naslovnica</a>
        <a href="kino_program.php">Kino Program</a>
        <a href="upravljaj_rezervacijama.php">Upravljanje rezervacijama</a>
    </nav>
</div>
<br><br><br>

     <!-- Raspored Filmova -->
     <section>
        <h2>Današnji raspored:</h2>
        
        <?php
        include('filmovi/GET_filmove.php');
    
        // Kreiraj film section za svaki film iz tablice
        while ($row = $result->fetch_assoc()) {
            $ID_Filma = $row['Film_ID'];
            $Ime_filma = $row['Ime_filma'];
            $Dob_ograniceno = $row['Dob_ograniceno'];
            $Opis_filma = $row['Opis_filma'];
            
            // SFW dob
            if ($Dob_ograniceno == "1") {
                $Dob_ograniceno = "Dob: 18+";
            } else {
                $Dob_ograniceno = "Dob: prikladno za sve dobi";
            }

            // kreiraj item za svaki entry u tablici filmovi
            ?>
            <div class="item">
                <h3><?php echo htmlspecialchars($Ime_filma); ?></h3>
                <p><?php echo htmlspecialchars($Opis_filma); ?></p>
                <p><?php echo htmlspecialchars($Dob_ograniceno); ?></p>
                <button onclick="openModal(<?php echo $ID_Filma; ?>)">Rezerviraj!</button>
            </div>
            
            <!-- Modal za svaki film -->
            <div id="modal-<?php echo $ID_Filma; ?>" class="modal">

            <!-- Definicija modala -->
            <div class="modal-content">
                <span class="close" onclick="closeModal(<?php echo $ID_Filma; ?>)">&times;</span>
                <h2>Kreiraj rezervaciju za <?php echo htmlspecialchars($Ime_filma); ?></h2>
                <form id="kreiraj_rezervaciju-<?php echo $ID_Filma; ?> "  action="Rezervacije_php/CREATE_rezervacija.php" method="post">
                <input type="hidden" name="ID_Filma" value="<?php echo $ID_Filma; ?>">

                    <label for="korisnicko_ime">Ime za rezervaciju:</label>
                    <input type="text" name="korisnicko_ime" id="korisnicko_ime" required><br>

                    <label for="broj_mjesta">Broj mjesta:</label>
                    <input type="number" name="broj_mjesta" id="broj_mjesta"  min="1" max="10" required><br>
                                      
                    <label for="termin">Odaberite termin:</label>
                    <select id="termin" name="termin" required></select><br><br>

                    <input type="submit" value="Kreiraj rezervaciju!">
                </form>
            </div>
            
            </div>
            <?php
            
            }
            ?>

    </section>

    <!-- footer -->
    <br><br><br>
    <footer>
        <p>&copy; Raspored filmova je prikazan za današnji dan. Život je kratak, pogledaj film.</p>
    </footer>

</body>
</html>