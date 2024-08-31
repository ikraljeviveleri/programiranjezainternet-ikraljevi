<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

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


<!-- Sadržaj -->
<main>
<body>

    <h2>Upravljaj postojećom rezervacijom</h2>
<!-- Korisnik unosi određena polje gdje se prepoznaje njegova rezervacija - temeljem toga može ju izmjeniti ili obrisati -->
    <form id="UpravljanjeRezervacijama" action="Rezervacije_php/GET_rezervacija.php" method="post">
    
    <label for="korisnicko_ime">Ime na rezervaciji:</label>
    <input type="text" name="korisnicko_ime" id="korisnicko_ime" required><br>
    
    <label for="film">Odaberite projekciju koju ste rezervirali:</label>
        <select name="film" id="film"  onchange="dobaviDatume()" required> 
                <?php
                $tableVariable = "Filmovi";
                include('filmovi/GET_FilmDetalji.php');

                echo '<option value= "">';
                foreach ($popis as $film_popis) {
                    echo '<option value="' . $film_popis['Film_ID'] . '">' . $film_popis['Ime_filma'] . '</option>';
                }   
                echo '</select>';
                ?>
        <br>

        <label for="rezervacija_ID">Broj rezervacije:</label>
        <input type="number" select name="rezervacija_ID" id="rezervacija_ID" required><br>

        <input type="submit" value="Pronađi moju rezervaciju">
    </form>

    <div id="reservationOptions" style="display: none;">
        <h3>Upravljajte rezervacijom:</h3>
        <button id="obriširezervaciju_btn">Ukloni rezervaciju</button>
        <button id="changeReservationBtn">Izmjeni rezervaciju</button>
    </div>

    <!-- SKRIPTA ZA UPRAVLJANJE REZERVACIJAMA -->
<script>
//var CRUD_korisnicko_ime;
//var CRUD_Film;
//var CRUD_Rezervacija;

// pokupi vrijednost iz elemenata
//var CRUD_korisnicko_ime = document.getElementById("korisnicko_ime").value;
//var CRUD_Film = document.getElementById("film").value;
//var CRUD_Rezervacija = document.getElementById("rezervacija_ID").value;


    // Provjera postojanja rezervacije
        document.getElementById("UpravljanjeRezervacijama").addEventListener("submit", function(event) {
            event.preventDefault();
            var CRUD_korisnicko_ime = document.getElementById("korisnicko_ime").value;
            var CRUD_Film = document.getElementById("film").value;
            var CRUD_Rezervacija = document.getElementById("rezervacija_ID").value;
            // Ajax provjera da li postoji rezervacija sa tim vrijednostima
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.responseText;
                    if (response.includes("Pronađena rezervacija")) {
                        document.getElementById("reservationOptions").style.display = "block";
                    } else {
                        alert("Rezervacija nije pronađena!");
                    }
                }
            };
            xhr.open("POST", "Rezervacije_php/GET_rezervacija.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("&korisnicko_ime=" + CRUD_korisnicko_ime + "&film=" + CRUD_Film + "&rezervacija_ID=" + CRUD_Rezervacija);
        });

// funkcija za brisanje već postojeće rezervacije
        document.getElementById("obriširezervaciju_btn").addEventListener("click", function() {
        if (confirm("Da li sigurno želite ukloniti vašu rezervaciju?")) {
            var CRUD_korisnicko_ime = document.getElementById("korisnicko_ime").value;
            var CRUD_Film = document.getElementById("film").value;
            var CRUD_Rezervacija = document.getElementById("rezervacija_ID").value;
                // Send AJAX request to delete_reservation.php
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if (xhr.status == 200) {
                            // Rezervacija se briše
                            alert("Rezervacija uspješno uklonjena");
                            var row = document.getElementById(korisnicko_ime + "-" + film + "-" + rezervacija_ID);
                            row.parentNode.removeChild(row);
                        } else {
                            // Error
                            alert("Error: " + xhr.responseText);
                        }
                    }
                };
                xhr.open("POST", "Rezervacije_php/DELETE_rezervaciju.php", true );
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("&korisnicko_ime=" + CRUD_korisnicko_ime + "&film=" + CRUD_Film + "&rezervacija_ID=" + CRUD_Rezervacija);
            }
        });


// funkcija za izmjenjivanje rezervacije
        document.getElementById("changeReservationBtn").addEventListener("click", function() {
            var CRUD_korisnicko_ime = document.getElementById("korisnicko_ime").value;
            var CRUD_Film = document.getElementById("film").value;
            var CRUD_Rezervacija = document.getElementById("rezervacija_ID").value;
        window.location.href = "Rezervacije_php/CHANGE_rezervacija.php?korisnicko_ime=" + encodeURIComponent(CRUD_korisnicko_ime) + "&film=" + encodeURIComponent(CRUD_Film) + "&rezervacija_ID=" + encodeURIComponent(CRUD_Rezervacija);
        });
    </script>

</body>
</html>
