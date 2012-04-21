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
        $edellinen = -1;

        // Tehdaan array johon laitetaan kaikki liitot
        $liitot = array();

        // Tehdaan array johon laitetaan yksi kerrallaan liiton edustajat
        $edustajat = array();

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

                // Suoritetaan uusi query jossa aanet liiton edustajille
                $query = "select ehdokas_id,vaaliliitto,sum(lkm) from edustaja,paikka_aanet where edustaja.vaalinumero=paikka_aanet.ehdokas_id AND vaaliliitto='$liitto' group by ehdokas_id,vaaliliitto order by sum desc";
                $resultone = pg_exec($db_handle, $query);
                $riveja = pg_num_rows($resultone);
                if ($resultone) {

                    // Loopataan lapi ehdokkaat
                    while ($rivi = pg_fetch_row($resultone)) {

                         // Ensimmainen tapaus, kyseessa on liiton ensimmainen edustaja
                        // Paivitetaan ainoastaan tiedot
                        if ($arvontaluku == -1) {
                            $arvontaluku = $rivi[2];
                            $edellinen = $rivi[0];
                            // Seuraava tapaus, rivilla on yhtapaljon aania kuin edellisella
                            // Lisataan arvottavien arrayhyn nykyinen ja edellinen
                        } else if ($rivi[2] == $arvontaluku) {
                            $arvonta[] = $rivi[0];
                            $arvonta[] = $edellinen;
                            // Seuraava tapaus, rivilla on erimaara aania kuin edellisella
                            // Suoritetaan edellisten arvonta mikali voidaan
                            // Ja paivitetaan arvontaluku seka edellinen
                         } else if ($rivi[2] != $arvontaluku) {
                            $arraynkoko = count($arvonta);
                            if ($arraynkoko > 1) {
                                shuffle($arvonta);
                                while ($edustaja = array_pop($arvonta)) {
                                    $query = "insert into $nimi (edustaja) values ('$edustaja')";
                                    $poppaus = pg_exec($db_handle, $query);
                                }
                            } else {
                                $query = "insert into $nimi (edustaja) values ('$edellinen')";
                                $insertti = pg_exec($db_handle, $query);
                            }
                            $arvontaluku = $rivi[2];
                            $edellinen = $rivi[0];
                        }
                    }
                    // Katsotaan vielä ettei arvontatauluun jäänyt arvoja
                    $arraynkoko = count($arvonta);
                    if ($arraynkoko > 1) {
                        shuffle($arvonta);
                        while ($edustaja = array_pop($arvonta)) {
                            $query = "insert into $nimi (edustaja) values ('$edustaja')";
                            $poppaus = pg_exec($db_handle, $query);
                            
                        }
                    } else {
                        $query = "insert into $nimi (edustaja) values ('$edellinen')";
                        $insertti = pg_exec($db_handle, $query);
                    }
                } else {
                    echo "Error!\n<br>";
                    die('Error: ' . print pg_last_error($db_handle));
                }
                echo "<br>Liiton $liitto arvontatulos:<br>";
                // Piirrellaan tulokset
                echo "<table>\n";
                echo "<tr>\n";
                echo "<td> Sijanumero </td>\n";
                echo "<td> Edustaja </td>\n";
                echo "</tr>\n";
                $query = "select * from $nimi";
                $tuloskysely = pg_exec($db_handle, $query);
                if ($tuloskysely) {
                    
                    while ($row = pg_fetch_row($tuloskysely)) {
                        echo "<tr>\n";
                        echo "<td>$row[0]</td>\n";
                        echo "<td>$row[1]</td>\n";
                        echo "</tr>\n";
                    }
                echo "</table>\n<br><br>";
                } else {
                    echo "Error!\n<br>";
                    die('Error: ' . print pg_last_error($db_handle));
                }
                // Resetoidaan muuttujat
                $edellinen = -1;
                $arvontaluku = -1;
                $arraynkoko = -1;
            }
        } else {
            echo "Error!\n<br>";
            die('Error: ' . print pg_last_error($db_handle));
        }
        ?>
    </body>
</html>