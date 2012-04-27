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
        include('yhteys.php');

        // Tyyppimuuttujan putsaus
        $sanitize = filter_var('$_POST["type"]', FILTER_SANITIZE_STRING);
        $type = $sanitize;

        // Tietokannan alustus
        //$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
        $db_handle = dbconnect();

        if ($type == "opiskelija") {

            // Opiskelijan muuttujat sisaan
            $enimi = filter_var('$_POST["enimi"]', FILTER_SANITIZE_STRING);
            $snimi = filter_var('$_POST["snimi"]', FILTER_SANITIZE_STRING);
            $numero = filter_var('$_POST["numero"]', FILTER_SANITIZE_NUMBER_INT);

            // Tarkistetaan ettei ollu tyhjia ja että numero on validi int and oikealla rangella
            if ($numero > 9999 && $numero < 100000) {
                $valid = true;
            } else {
                $valid = false;
            }
            if (!empty($enimi) && !empty($snimi) && !empty($numero) && filter_var('$numero', FILTER_VALIDATE_INT) && $valid) {

                // Muodostetaan query
                $query = "insert into Opiskelija values('$numero','$enimi','$snimi')";
                $result = pg_exec($db_handle, $query);
                // Tarkastetaan onnistuiko ja annetaan ilmoitus
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<br><a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                    echo "<br><a href=\"index.php\"> Back </a>";
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == "edustaja") {

            // Edustajan opiskelijanumero sisaan
            $numero = filter_var('$_POST["numero"]', FILTER_SANITIZE_NUMBER_INT);

            // Validointi
            if ($numero > 9999 && $numero < 100000) {
                $valid = true;
            } else {
                $valid = false;
            }
            // Tarkistetaan tyhjien varalta
            if (!empty($numero) && filter_var('$numero', FILTER_VALIDATE_INT) && $valid) {

                // Muodostetaan query
                $query = "insert into Edustaja values('$numero')";
                $result = pg_exec($db_handle, $query);
                // Tarkastetaan onnistuiko ja annetaan ilmoitus
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<br><a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                    echo "<br><a href=\"index.php\"> Back </a>";
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == "vaaliliitto") {

            // Muuttujat sisaan ja niiden sanitointi
            $nimi = filter_var('$_POST["nimi"]', FILTER_SANITIZE_STRING);
            $tunnus = filter_var('$_POST["tunnus"]', FILTER_SANITIZE_STRING);

            // Validointi
            if (!empty($nimi) && !empty($tunnus)) {
                // Muodostetaan query
                $query = "insert into Vaaliliitto values('$nimi','$tunnus')";
                $result = pg_exec($db_handle, $query);
                // Tarkastetaan onnistuiko ja annetaan ilmoitus
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<br><a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                    echo "<br><a href=\"index.php\"> Back </a>";
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == "liitto") {

            // Muuttujat sisaan ja niiden sanitointi
            $numero = filter_var('$_POST["numero"]', FILTER_SANITIZE_NUMBER_INT);
            $vaaliliitto = filter_var('$_POST["vaaliliitto"]', FILTER_SANITIZE_STRING);

            // Validointi
            if ($numero > 9999 && $numero < 100000) {
                $valid = true;
            } else {
                $valid = false;
            }

            // Validointi
            if (!empty($numero) && filter_var('$numero', FILTER_VALIDATE_INT) && $valid && !empty($vaaliliitto)) {
                // Muodostetaan query
                $query = "update edustaja set vaaliliitto = '$vaaliliitto' where vaalinumero = '$numero'";
                $result = pg_exec($db_handle, $query);
                // Tarkastetaan onnistuiko ja annetaan ilmoitus

                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == "rengas") {
            // Muuttujat sisaan ja niiden validointi
            $numero = filter_var('$_POST["numero"]', FILTER_SANITIZE_NUMBER_INT);
            $vaalirengas = filter_var('$_POST["vaalirengas"]', FILTER_SANITIZE_STRING);

            // Validointi
            if ($numero > 9999 && $numero < 100000) {
                $valid = true;
            } else {
                $valid = false;
            }

            // Validointi
            if (!empty($numero) && filter_var('$numero', FILTER_VALIDATE_INT) && $valid && !empty($vaalirengas)) {

                // Kyselyn muodostaminen
                $query = "update edustaja set vaalirengas = '$vaalirengas' where vaalinumero = '$numero'";
                $result = pg_exec($db_handle, $query);
                // Tarkastetaan onnistuiko ja annetaan ilmoitus

                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == 'aanet') {
            // Muuttujat sisaan ja validointi
            $numero = filter_var('$_POST["numero"]', FILTER_SANITIZE_NUMBER_INT);
            $edustaja = filter_var('$_POST["edustaja"]', FILTER_SANITIZE_NUMBER_INT);
            $vaaliliitto = filter_var('$_POST["vaaliliitto"]', FILTER_SANITIZE_STRING);

            // Validointi
            if ($edustaja > 9999 && $edustaja < 100000 && $numero >= 0) {
                $valid = true;
            } else {
                $valid = false;
            }

            // Validointi
            if (!empty($numero) && filter_var('$numero', FILTER_VALIDATE_INT) && $valid && !empty($vaaliliitto)) {
                // Kyselyn muodostaminen
                $query = "insert into paikka_aanet values('$edustaja','$aanestyspaikka','$numero')";
                $result = pg_exec($db_handle, $query);
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == "vaalirengas") {
            // Muuttujat sisaan ja validointi

            $nimi = filter_var('$_POST["nimi"]', FILTER_SANITIZE_STRING);
            $tunnus = filter_var('$_POST["tunnus"]', FILTER_SANITIZE_STRING);

            // Validointi
            if (!empty($nimi) && (!empty($tunnus))) {
                $query = "insert into vaalirengas values('$nimi','$tunnus')";
                $result = pg_exec($db_handle, $query);
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added";
                    echo "<a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                    echo "<a href=\"index.php\"> Back </a>";
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        } else if ($type == "lpaikka") {
            // Muuttujat sisään ja validointi
            $nimi = filter_var('$_POST["nimi"]', FILTER_SANITIZE_STRING);
            $tunnus = filter_var('$_POST["tunnus"]', FILTER_SANITIZE_STRING);
            if (!empty($nimi) && (!empty($tunnus))) {
                $query = "INSERT INTO aanestyspaikka VALUES('$nimi', '$tunnus')";
                $result = pg_exec($db_handle, $query);
                if ($result) {
                    echo "The query executed successfully.<br>\n";
                    echo "1 record added \n";
                    echo "<a href=\"index.php\"> Back </a>";
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                    echo "<a href=\"index.php\"> Back </a>";
                }
            } else {
                echo "Missing or incorrect input!";
                echo "<br><a href=\"index.php\"> Back </a>";
            }
        }
        ?>
    </body>
</html>
