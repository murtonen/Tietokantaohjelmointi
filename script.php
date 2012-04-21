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
        // Tyyppimuuttuja sisään
        $type = $_POST["type"];

        // Tietokannan alustus
        $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
        $db_handle = pg_connect($options);

        if ($type == "opiskelija") {

            // Opiskelijan muuttujat sisaan
            $enimi = $_POST["enimi"];
            $snimi = $_POST["snimi"];
            $numero = $_POST["numero"];

            // Tarkistetaan ettei ollu tyhjia
            if (!empty($enimi) && !empty($snimi) && !empty($numero)) {
                // Tietokannan alustus 
                // Muodostetaan query
                $query = "insert into Opiskelija values('$numero','$enimi','$snimi')";
                $result = pg_exec($db_handle, $query);
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                }
            } else {
                echo "Missing input!";
            }
        } else if ($type == "edustaja") {

            // Edustajan opiskelijanumero sisaan
            $numero = $_POST["numero"];

            // Tarkistetaan tyhjien varalta
            if (!empty($numero)) {

                // Muodostetaan query
                $query = "insert into Edustaja values('$numero')";
                $result = pg_exec($db_handle, $query);
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                }
            } else {
                echo "Missing input!";
            }
        } else if ($type == "vaaliliitto") {
            // Muuttujat sisaan
            $nimi = $_POST["nimi"];
            $tunnus = $_POST["tunnus"];

            $query = "insert into Vaaliliitto values('$nimi','$tunnus')";
            $result = pg_exec($db_handle, $query);
            if ($result) {
                echo "The query executed successfully.<br>\n";
                echo "1 record added";
                echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
            } else {
                die('Error: ' . print pg_last_error($db_handle));
            }
        } else if ($type == "liitto") {

            // Muuttujat sisaan
            $numero = $_POST["numero"];
            $vaaliliitto = $_POST["vaaliliitto"];

            $query = "update edustaja set vaaliliitto = '$vaaliliitto' where vaalinumero = '$numero'";
            $result = pg_exec($db_handle, $query);
            if ($result) {
                echo "The query executed successfully.<br>\n";
                echo "1 record added";
                echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
            } else {
                die('Error: ' . print pg_last_error($db_handle));
            }
        } else if ($type == "rengas") {
            $numero = $_POST["numero"];
            $vaalirengas = $_POST["vaalirengas"];

            $query = "update edustaja set vaalirengas = '$vaalirengas' where vaalinumero = '$numero'";
            $result = pg_exec($db_handle, $query);
            if ($result) {
                echo "The query executed successfully.<br>\n";
                echo "1 record added";
                echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
            } else {
                die('Error: ' . print pg_last_error($db_handle));
            }
        } else if ($type == 'aanet') {
            $numero = $_POST["numero"];
            $edustaja = $_POST["edustaja"];
            $aanestyspaikka = $_POST["aanestyspaikka"];

            $query = "insert into paikka_aanet values('$edustaja','$aanestyspaikka','$numero')";
            $result = pg_exec($db_handle, $query);
            if ($result) {
                echo "The query executed successfully.<br>\n";
                echo "1 record added";
                echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
            } else {
                die('Error: ' . print pg_last_error($db_handle));
            }
        } else if ($type == "vaalirengas") {
            // Muuttujat sisaan
            $nimi = $_POST["nimi"];
            $tunnus = $_POST["tunnus"];

            $query = "insert into vaalirengas values('$nimi','$tunnus')";
            $result = pg_exec($db_handle, $query);
            if ($result) {
                echo "The query executed successfully.<br>\n";
                echo "1 record added";
            } else {
                die('Error: ' . print pg_last_error($db_handle));
                echo "<a href=\"http://www.cs.uta.fi/~vm92179/index.php\"> Back </a>";
            }
        }
        ?>
    </body>
</html>
