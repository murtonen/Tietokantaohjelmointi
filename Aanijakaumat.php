<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Sijoitukset liitottain/renkaittain.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        // Yhteysmetodi sisaan
        include('yhteys.php');
        
        // Tyyppimuuttujan putsaus
        $to_san = $_POST["type"];
        $sanitized = filter_var($to_san, FILTER_SANITIZE_STRING);
        $type = $sanitized;
        
        // Tietokannan alustus
        $db_handle = dbconnect();
        
        // Kyselyn muodostaminen ja toteuttaminen
        $query = "SELECT * FROM vaaliliitto";
        $result = pg_exec($db_handle, $query);
        
        // Muuttujien alustukset
        $selects = "";
        $selects.="<OPTION VALUE=\"choose\"> Valitse </option>";
        $selectstwo = "";
        $selectstwo.="<OPTION VALUE=\"choose\"> Valitse </option>";
        $selectsthree = "";
        $selectsthree.="<OPTION VALUE=\"choose\"> Valitse </option>";
        // Palautteiden lapikaynti
        while ($row = pg_fetch_row($result)) {
            $nimi = $row[0];
            $tunnus = $row[1];
            $selects.="<OPTION VALUE=\"$tunnus\">" . $nimi . '</option>';
        }
        // Kyselyn muodostamienn ja toteuttaminen
        $query = "SELECT * FROM vaalirengas";
        $result = pg_exec($db_handle, $query);
        // Palautteiden lapikaynti
        while ($row = pg_fetch_row($result)) {
            $nimi = $row[0];
            $tunnus = $row[1];
            $selectstwo.="<OPTION VALUE=\"$tunnus\">" . $nimi . '</option>';
        }
        // Liittojen kasittely
        if ($type == "liitto") {
             // Validointi ja sanitointi
            $tunnus = filter_var($_POST["vaaliliitto"], FILTER_SANITIZE_STRING);
            if (!empty($tunnus)) {
                // Kyselyn muodostaminen ja kasittely
                $query = "select id,edustaja from viralliset_tulokset where vaaliliitto = '$tunnus'";
                $result = pg_exec($db_handle, $query);
                // Tuloksien lapikaynti
                if ($result) {
                    echo "<p><h2>Liiton $tunnus<br>";
                    echo "Sijoitukset</h2></p> <br><br>\n";
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "Sijoitus\n";
                    echo "</td>\n";
                    echo "<td>\n";
                    echo "Edustaja\n";
                    echo "</td>\n";
                    echo "</tr>\n";                
                    while ($row = pg_fetch_row($result)) {
                         echo "<tr>\n";
                        $sarakkeita = count($row);
                        for ($i = 0; $i < $sarakkeita; $i++) {
                            echo "<td>\n";
                            echo "$row[$i]";
                            echo "</td>\n";
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n<br><br>";
                } else {
                    ;
                }
            } else {
                ;
            }
            // Renkaiden lapikaynti
        } else if ($type == "rengas") {
             // Validointi ja sanitointi
            $tunnus = filter_var($_POST["vaalirengas"], FILTER_SANITIZE_STRING);
            if (!empty($tunnus)) {
                // Kyselyn muodostaminen ja suorittaminen
                $query = "select id,edustaja from viralliset_tulokset where vaalirengas= '$tunnus'";
                $result = pg_exec($db_handle, $query);
                // Tuloksien lapikaynti
                if ($result) {
                    echo "<p><h2>Renkaan $tunnus<br>";
                    echo "Sijoitukset</h2></p> <br><br>\n";
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "Sijoitus\n";
                    echo "</td>\n";
                    echo "<td>\n";
                    echo "Edustaja\n";
                    echo "</td>\n";
                    echo "</tr>\n";                
                    while ($row = pg_fetch_row($result)) {
                         echo "<tr>\n";
                        $sarakkeita = count($row);
                        for ($i = 0; $i < $sarakkeita; $i++) {
                            echo "<td>\n";
                            echo "$row[$i]";
                            echo "</td>\n";
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n<br><br>";
                } else {
                    ;
                }
            } else {
                ;
            }
         }
         // Html koodi formien esittamiselle
        ?>
        
        <p> Vaaliliitottain </p>
        <form name="liitos" action="Aanijakaumat.php" method="post">
            <input type="hidden" name="type" value="liitto" />          
            <SELECT NAME="vaaliliitto">
                <?php echo $selects;
                ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
        <p> Vaalirenkaittain </p>
        <form name="liitos" action="Aanijakaumat.php" method="post">
            <input type="hidden" name="type" value="rengas" />
            <SELECT NAME="vaalirengas">
                <?php echo $selectstwo;
                ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
        <br>
        <a href="index.php"> back </a>
    </body>
</html>