<?php
    //global $globalterminID;
    session_start();
    include(__DIR__ . '/../common/DBconnect.php');
    //echo "testTERMINID";

    // Get parameters from the URL
    //$termin = $_POST['termin'];
    $PRIJE_MOD_termin = $_SESSION['PRIJE_MOD_termin'];
    $sourceFile = $_SESSION['UPDATE_termin'];

    $sqlzaDateID = "SELECT ID_termina FROM termin WHERE Termin_dan = '$PRIJE_MOD_termin'";

    
    $result = $conn->query($sqlzaDateID);
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $procesiranTerminID = $row['ID_termina'];
            echo "Termin ID: " . $procesiranTerminID;
            $_SESSION['procesiranTerminID'] = $procesiranTerminID;
            header("Location: $sourceFile.php");
            //global $globalterminID;
        } else {
            echo "No rows found for $PRIJE_MOD_termin";
        }
        $result->free();
    } else {
        echo "Error: " . $conn->error;
    }
    
    exit;