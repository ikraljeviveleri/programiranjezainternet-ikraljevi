<?php
// varijable
$PRIJE_MOD_korisnicko_ime = $_GET['korisnicko_ime'];
$PRIJE_MOD_film = $_GET['film'];
$PRIJE_MOD_ID_rezervacije = $_GET['rezervacija_ID'];
//echo "TS: $PRIJE_MOD_korisnicko_ime, $PRIJE_MOD_film, $PRIJE_MOD_termin";
//<?php
    setcookie("PRIJE_MOD_korisnicko_ime", $PRIJE_MOD_korisnicko_ime, time() + (86400 * 30), "/");
    setcookie("PRIJE_MOD_film", $PRIJE_MOD_film, time() + (86400 * 30), "/");
    setcookie("PRIJE_MOD_ID_rezervacije", $PRIJE_MOD_ID_rezervacije, time() + (86400 * 30), "/");
    //
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Izmjeni rezervaciju</title>

</head>
<body>

<h2>Izmjeni rezervaciju</h2>


<form id="Promjeni_rezervaciju" method="POST" action="UPDATE_termin.php" >
    <!-- <label for="newUsername">Promjena imena na rezervaciji:</label> -->
    <!-- <input type="text" id="newUsername" name="newUsername" value="<?php echo htmlspecialchars($PRIJE_MOD_korisnicko_ime); ?>"><br> -->

<!-- Izmjena filma + datumi ovisno o odabranom filmu -->
    <label for="film">Odaberite novu projekciju:</label>
        <select name="film" id="film"  onchange="dobaviDatume()"> 
                <?php
                $tableVariable = "Filmovi";
                include('../filmovi/GET_FilmDetalji.php');
                echo '<option value= "">';
                foreach ($popis as $film_popis) {
                    echo '<option value="' . $film_popis['Film_ID'] . '">' . $film_popis['Ime_filma'] . '</option>';
                }   
                echo '</select>';
                ?>
    <div  id="container"  style="overflow: auto;">
<!-- Broj mjesta za rezervaciju -->
    <label for="broj_mjesta">Broj mjesta:</label>
    <input type="number" name="broj_mjesta" id="broj_mjesta"  min="1" max="10" required><br>
<!-- Dobavi termin ovisno o filmu -->
    <label for="termin">Projekcija:</label>
    <select name="termin" id="termin"><br> </select>
<!-- tišla -->
    <br><br><button type="submit" value="Submit">Izmjeni rezervaciju!</button>

</div>
</form>


<script>
        // skripta za dobavljanje datuma ovisno o odabranom filmu pri kreiranju nove rezervacije
        function dobaviDatume() {
            var FilmID = document.getElementById("film").value;

            // Fetch available dates for the selected movie from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var availableDates = JSON.parse(this.responseText);

                    // Populate the select box with available dates
                    var dateSelect = document.getElementById("termin");
                    dateSelect.innerHTML = ""; // Clear previous options
                    availableDates.forEach(function(date) {
                        var option = document.createElement("option");
                        option.text = date;
                        option.value = date;
                        dateSelect.add(option);
                    });
                }
            };
            xhr.open("GET", "../filmovi/GET_Datumi_za_Film.php?Film_ID=" + FilmID, true);
            xhr.send();
        }
    </script>


</body>
</html>