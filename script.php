<!DOCTYPE HTML PUBLIC
                 "-//W3C//DTD HTML 4.01 Transitional//EN"
                 "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Doing stuff...</title>
</head>
<body>

<?php

// Muuttujat sisaan
$type = $_POST["type"];


// Tarkistukset oliko niissa tavaraa
if ($type == "opiskelija") {
    
    // Opiskelijan muuttujat sisaan
    $enimi = $_POST["enimi"];
    $snimi = $_POST["snimi"];
    $numero = $_POST["numero"];

    if (!empty($enimi) && !empty($snimi) && !empty($numero) ) {
    // Tietokannan alustus
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);
    
    // Muodostetaan query
    $query = "insert into Opiskelija values('$numero','$enimi','$snimi')";
    $result = pg_exec($db_handle, $query);
    if ($result) {
    echo "The query executed successfully.<br>\n";
    } else {
        die('Error: '.mysql.error());
    }
echo "1 record added";
    } else {
        echo "Missing input!";
    }
} else if ($type == "edustaja") {
    $numero = $_POST["numero"];

    if (!empty($enimi) && !empty($snimi) && !empty($numero) ) {
    // Tietokannan alustus
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);
    
    // Muodostetaan query
    $query = "insert into Edustaja values('$numero')";
    $result = pg_exec($db_handle, $query);
    if ($result) {
    echo "The query executed successfully.<br>\n";
    } else {
        die('Error: '.mysql.error());
    }
echo "1 record added";
    } else {
        echo "Missing input!";
    }
    
} else if ($type == "vaaliliitto") {
    // Muuttujat sisaan
    $numero = $_POST["numero"];
    $nimi = $_POST["nimi"];
    $tunnus = $_POST["tunnus"];
    $vaaliliitto = $_POST["vaaliliitto"];
    
    // Tietokannan alustus
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);

    if ($vaaliliitto == "new") {
        $query = "insert into Vaaliliitto values('$nimi','$tunnus')";
        $result = pg_exec($db_handle, $query);
        if ($result) {
        echo "The query executed successfully.<br>\n";
        } else {
        die('Error: '.mysql.error());
        }
        echo "1 record added";
    }
} else if ($type == "liitto") {
        
    // Muuttujat sisaan
    $numero = $_POST["numero"];
    $vaaliliitto = $_POST["vaaliliitto"];
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);
    $query = "update edustaja set vaaliliitto = '$vaaliliitto' where vaalinumero = '$numero'";
    $result = pg_exec($db_handle, $query);
        if ($result) {
        echo "The query executed successfully.<br>\n";
        } else {
        die('Error: '.mysql.error());
        }
        echo "1 record added";   
} else if ($type == "rengas") {
    $numero = $_POST["numero"];
    $vaalirengas = $_POST["vaalirengas"];
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);
    $query = "update edustaja set vaalirengas = '$vaalirengas' where vaalinumero = '$numero'";
    $result = pg_exec($db_handle, $query);
        if ($result) {
        echo "The query executed successfully.<br>\n";
        } else {
        die('Error: '.mysql.error());
        }
        echo "1 record added"; 
    
} else if ($type == 'aanet') {
    $numero = $_POST["numero"];
    $edustaja = $_POST["edustaja"];
    $aanestyspaikka = $_POST["aanestyspaikka"];
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);
    $query = "insert into paikka_aanet values('$edustaja','$aanestyspaikka','$numero')";
    $result = pg_exec($db_handle, $query);
        if ($result) {
        echo "The query executed successfully.<br>\n";
        } else {
        die('Error: '.mysql.error());
        }
        echo "1 record added"; 
}
?>
</body>
</html>
