<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Liita edustaja vaaliliittoon tai vaalirenkaaseen.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        include('yhteys.php');

        $db_handle = dbconnect();
        $query = " select distinct nimi,tunnus from aanestyspaikka,paikka_aanet where aanestyspaikka.tunnus = paikka_aanet.paikka_tunnus";
        $result = pg_exec($db_handle, $query);
        $selects = "";
        $selects.="<OPTION VALUE=\"choose\"> Valitse </option>";
        while ($row = pg_fetch_row($result)) {
            $nimi = $row[0];
            $tunnus = $row[1];
            $selects.="<OPTION VALUE=\"$tunnus\">" . $nimi . '</option>';
        }
        if ($type == $paikka) {

            // Validointi ja sanitointi
            $tunnus = filter_var($_POST["tunnus"], FILTER_SANITIZE_STRING);
            if (!empty($tunnus)) {
                // Kokonaisaanet ko. paikalle
                $query = "select sum(lkm) from paikka_aanet where paikka_tunnus='$tunnus'";
                $result = pg_exec($db_handle, $query);
                if ($result) {
                    while ($row = pg_fetch_row($result)) {
                        $kokonaisaania = $row[0];
                    }
                } else {
                    die('Error: ' . print pg_last_error($db_handle));
                    echo "<a href=\"index.php\"> Back </a>";
                }
                $query = "select ehdokas_id,sum(lkm) from paikka_aanet,aanestyspaikka where aanestyspaikka.tunnus = paikka_aanet.paikka_tunnus AND paikka_tunnus='$tunnus' group by ehdokas_id order by sum desc";
                $result = pg_exec($db_handle, $query);
                if ($result) {


                    echo "<p><h2>Aanestyspaikan $tunnus<br>";
                    echo "Aanijakaumat</h2></p> <br><br>";
                    echo "Kokonaisaanet: $kokonaisaania\n<br><br>";
                    echo "Edustajat\n<br>";
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "Edustaja\n";
                    echo "</td>\n";
                    echo "<td>\n";
                    echo "Aanet\n";
                    echo "</td>\n";
                    echo "<tr>\n";
                    while ($row = pg_fetch_row($result)) {
                        $sarakkeita = count($row);
                        for ($i = 0; $i < $sarakkeita; $i++) {
                            echo "<td>\n";
                            echo "$row[$i]";
                            echo "</td>\n";
                        }
                        echo "</tr>\n";
                    }

                    echo "</table>\n<br><br>";

                    // Liitot
                    $query = "select tunnus,sum(lkm) from paikka_aanet,vaaliliitto,edustaja where paikka_aanet.ehdokas_id=edustaja.vaalinumero AND edustaja.vaaliliitto=vaaliliitto.tunnus AND  paikka_tunnus='$tunnus' GROUP BY tunnus order by sum desc";
                    $result = pg_exec($db_handle, $query);
                    echo "Liitot<br><br>";
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "Liitto\n";
                    echo "</td>\n";
                    echo "<td>\n";
                    echo "Aanet\n";
                    echo "</td>\n";
                    echo "<tr>\n";
                    while ($row = pg_fetch_row($result)) {
                        $sarakkeita = count($row);
                        for ($i = 0; $i < $sarakkeita; $i++) {
                            echo "<td>\n";
                            echo "$row[$i]";
                            echo "</td>\n";
                        }
                        echo "</tr>\n";
                    }

                    echo "</table>\n<br><br>";

                    // Renkaat
                    $query = "select nimi,sum(lkm) from paikka_aanet,vaalirengas,edustaja where paikka_aanet.ehdokas_id=edustaja.vaalinumero AND edustaja.vaalirengas=vaalirengas.tunnus AND  paikka_tunnus='$tunnus' GROUP BY nimi order by sum desc";
                    $result = pg_exec($db_handle, $query);
                    echo "Renkaat<br><br>";
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "Rengas\n";
                    echo "</td>\n";
                    echo "<td>\n";
                    echo "Aanet\n";
                    echo "</td>\n";
                    echo "<tr>\n";
                    while ($row = pg_fetch_row($result)) {
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
                    echo "Error!\n<br>";
                }
            }
        } else {
            die('Error: ' . print pg_last_error($db_handle));
            echo "<a href=\"index.php\"> Back </a>";
        }
        ?>
        <p> Äänet paikoittain. </p>
        <form name="liitos" action="Raportti_jakaumat.php" method="post">
            <input type="hidden" name="type" value="paikka" />
            <SELECT NAME="tunnus">
                <?php echo $selects;
                ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
    </body>
</html>
