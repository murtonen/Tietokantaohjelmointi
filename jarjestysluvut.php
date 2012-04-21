<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Laske jarjestysluku</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        // Alustetaan muuttujia
        $arvontaluku = -1;

        // Tehdaan array johon laitetaan kaikki liitot
        $liitot = array();

        // Tehdaan array johon laitetaan yksi kerrallaan liiton edustajat
        $edustajat = array();

        // Rivilaskuri
        $i = 1;
        // Tietokannan alustus
        $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
        $db_handle = pg_connect($options);

        // Kysely
        $query = "SELECT tunnus FROM vaaliliitto";
        $result = pg_exec($db_handle, $query);

        if ($result) {

            // Tuloksen kasittely
            while ($row = pg_fetch_row($result)) {
                $liitot[] = $row[0];
            }

            // Käydään liitot läpi yksi kerrallaan
            foreach ($liitot as $liitto) {
                // Tehdaan array johon laitetaan arvonnan edustajat
                $arvonta = array();

                // Luodaan tilapaisen tulostaulun nimi
                $nimi = $liitto . "_jarjestys";

                // Luodaan liitolle valiaikainen tulostaulu
                $query = "create temp table $nimi (ID serial primary key, edustaja integer not null)";
                $luonti = pg_exec($db_handle, $query);
                if ($luonti) {
                    
                } else {
                    echo "Error!\n<br>";
                    die('Error: ' . print pg_last_error($db_handle));
                }

                // Suoritetaan uusi query jossa aanet liiton edustajalle
                $query = "select ehdokas_id,vaaliliitto,sum(lkm) from edustaja,paikka_aanet where edustaja.vaalinumero=paikka_aanet.ehdokas_id AND vaaliliitto='$liitto' group by ehdokas_id,vaaliliitto order by sum desc";
                $resultone = pg_exec($db_handle, $query);
                if ($resultone) {

                    // Otetaan ko. liiton edustajat arrayhun
                    $riveja = pg_num_rows($resultone);
                    while ($rivi = pg_fetch_row($resultone)) {

                        // Luetaan saatuja tietoja

                        // Jos rivillä on sama luku kuin minkä arvontoja suoritetaan
                        // Niin lisataan edustaja arvontoihin
                        
                        if ($rivi[2] == $arvontaluku) {
                            $arvonta[] = $rivi[0];
                            $arvonta[] = $edellinen;
                        }

                        // Suoritetaan arvonta jos arvottavia on
                        $arraynkoko = count($arvonta);
                        if ($arraynkoko > 0) {
                            shuffle($arvonta);

                            // Heitetaan onnekkaat tulostauluun
                            while ($edustaja = array_pop($arvonta)) {
                                $query = "insert into $nimi (edustaja) values ('$edustaja')";
                                $poppaus = pg_exec($db_handle, $query);
                                if ($poppaus) {
                                    
                                } else {
                                    echo "Error!\n<br>";
                                    die('Error: ' . print pg_last_error($db_handle));
                                }
                            }
                        }

                        if ($rivikaks = pg_fetch_row($resultone)) {
                            $i++;
                            if ($rivi[2] == $rivikaks[2]) {
                                $arvontaluku = $rivikaks[2];
                                $arvonta[] = $rivi[0];
                                $arvonta[] = $rivikaks[0];
                                $arraynkoko = count($arvonta);
                            } else {
                                $arvontaluku = $rivikaks[2];
                                $edellinen = $rivikaks[0];
                                $query = "insert into $nimi (edustaja) values ('$rivi[0]')";
                                $resulttwo = pg_exec($db_handle, $query);
                                if ($resulttwo) {
                                    
                                } else {
                                    echo "Error!\n<br>";
                                    die('Error: ' . print pg_last_error($db_handle));
                                }
                            }
                        }
                    $i++;
                }
            } else {
                echo "Error!\n<br>";
                die('Error: ' . print pg_last_error($db_handle));
            }
            echo "<table>\n";
            echo "<tr>\n";
            echo "<td> Sijanumero </td>\n";
            echo "<td> Edustaja </td>\n";
            echo "</tr>\n";
            $query = "select * from $nimi";
            $tuloskysely = pg_exec($db_handle, $query);
            if ($tuloskysely) {
                echo "<br>Liiton $liitto arvontatulos:<br>";
                while ($row = pg_fetch_row($tuloskysely)) {
                    echo "<tr>\n";
                    echo "<td>$row[0]</td>\n";
                    echo "<td>$row[1]</td>\n";
                    echo "</tr>\n";
                }
            } else {
                echo "Error!\n<br>";
                die('Error: ' . print pg_last_error($db_handle));
            }
            
            unset($arvonta);
            }
        } else {
            echo "Error!\n<br>";
            die('Error: ' . print pg_last_error($db_handle));
        }
        ?>
    </body>
</html>