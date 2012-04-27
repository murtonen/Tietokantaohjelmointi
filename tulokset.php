<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Listaa lopulliset tulokset.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        include('yhteys.php');
        // Tietokannan alustus
        //$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
        $db_handle = dbconnect();

        // Alustetaan muuttujia
        $arvontaluku = -1;
        $edellinen = -1;

        // Tehdaan array johon laitetaan yksi kerrallaan liiton edustajat
        $edustajat = array();

        // Luodaan valiaikainen tulostaulu
        $query = "create temp table tulos (ID serial primary key, edustaja integer not null,vaaliliitto varchar(10), vaalirengas varchar(10), liittoluku float, rengasluku float, arvonnoissa varchar(10))";
        $luonti = pg_exec($db_handle, $query);
        if ($luonti) {
            ;
        } else {
            echo "Error!\n<br>";
            die('Error: ' . print pg_last_error($db_handle));
        }

        // Kysely
        $query = "SELECT vaalinumero,vaaliliitto,vaalirengas,vertailuluku,rengasvertailuluku,arvonnoissa FROM edustaja order by rengasvertailuluku desc";
        $result = pg_exec($db_handle, $query);

        if ($result) {

            // Tuloksien lapikaynti ja mahdolliset arvonnat
            while ($rivi = pg_fetch_row($result)) {

                // Otetaan ylos liitto, rengas ja arvontoihin osallistumine
                $liitto = $rivi[1];
                $rengas = $rivi[2];
                $liittoluku = $rivi[3];
                $rengasluku = $rivi[4];
                $arvonnoissa = $rivi[5];

                // Tehdaan array johon laitetaan arvonnan edustajat
                $arvonta = array();

                // Kaydaan listaa lapi
                // Ensimmainen tapaus, kyseessa on ensimmainen edustaja listalla
                // Paivitetaan ainoastaan muuttujat
                if ($arvontaluku == -1) {
                    $arvontaluku = $rivi[4];
                    $edellinen = $rivi[0];
                    $edellisenliitto = $rivi[1];
                    $edellisenrengas = $rivi[2];
                    $edellisenliittoluku = $rivi[3];
                    $edellisenrengasluku = $rivi[4];
                    $edellisenarvonnoissa = $rivi[5];
                    // Seuraava tapaus, rivilla on yhtapaljon aania kuin edellisella
                    // Lisataan arvottavien arrayhyn nykyinen ja edellinen
                } else if ($rivi[4] == $arvontaluku) {
                    $arvonta[] = $rivi[0];
                    $arvonta[] = $edellinen;
                    // Seuraava tapaus, rivilla on erimaara aania kuin edellisella
                    // Suoritetaan edellisten arvonta mikali voidaan
                    // Ja paivitetaan arvontaluku seka edellinen
                } else if ($rivi[4] != $arvontaluku) {
                    $arraynkoko = count($arvonta);
                    if ($arraynkoko > 1) {
                        shuffle($arvonta);
                        while ($edustaja = array_pop($arvonta)) {
                            $query = "insert into tulos (edustaja,vaaliliitto,vaalirengas,liittoluku,rengasluku,arvonnoissa) values ('$edustaja', '$liitto', '$rengas', '$liittoluku', '$rengasluku', $arvonnoissa')";
                            $poppaus = pg_exec($db_handle, $query);
                            $query = "update edustaja set arvonnoissa='FI' where vaalinumero='$edustaja'";
                            $update = pg_exec($db_handle, $query);
                            $query = "update tulos set arvonnoissa='FI' where edustaja='$edustaja'";
                            $update = pg_exec($db_handle, $query);
                        }
                    } else {
                        $query = "insert into tulos (edustaja,vaaliliitto,vaalirengas,liittoluku,rengasluku,arvonnoissa) values ('$edellinen','$edellisenliitto','$edellisenrengas','$edellisenliittoluku', '$edellisenrengasluku','$edellisenarvonnoissa')";
                        $insertti = pg_exec($db_handle, $query);
                    }
                    $arvontaluku = $rivi[3];
                    $edellinen = $rivi[0];
                    $edellisenliitto = $rivi[1];
                    $edellisenrengas = $rivi[2];
                    $edellisenliittoluku = $rivi[3];
                    $edellisenrengasluku = $rivi[4];
                    $edellisenarvonnoissa = $rivi[5];
                }
            }
            // Katsotaan vielä ettei arvontatauluun jäänyt arvoja
            $arraynkoko = count($arvonta);
            if ($arraynkoko > 1) {
                shuffle($arvonta);
                while ($edustaja = array_pop($arvonta)) {
                    $query = "insert into tulos (edustaja,vaaliliitto,vaalirengas,liittoluku,rengasluku,arvonnoissa) values ('$edustaja','$liitto','$rengas', '$liittoluku', '$rengasluku', $arvonnoissa')";
                    $poppaus = pg_exec($db_handle, $query);
                    $query = "update edustaja set arvonnoissa='FI' where vaalinumero='$edustaja'";
                    $update = pg_exec($db_handle, $query);
                    $query = "update tulos set arvonnoissa='FI' where edustaja='$edustaja'";
                    $update = pg_exec($db_handle, $query);
                }
            } else {
                $query = "insert into tulos (edustaja,vaaliliitto,vaalirengas,liittoluku,rengasluku,arvonnoissa) values ('$edellinen','$edellisenliitto','$edellisenrengas','$edellisenliittoluku', '$edellisenrengasluku','$edellisenarvonnoissa')";
                $insertti = pg_exec($db_handle, $query);
            }
        }
        // Tulostetaan tulokset
        echo "<br>Edustajistovaalien viralliset tulokset:<br>";
        // Piirrellaan tulokset
        echo "<table>\n";
        echo "<tr>\n";
        echo "<td> Sijanumero</td>\n";
        echo "<td> Edustaja </td>\n";
        echo "<td> Liitto</td>\n";
        echo "<td> Liittovertailuluku</td>\n";
        echo "<td> Rengas</td>\n";
        echo "<td> Rengasvertailuluku</td>\n";
        echo "<td> Arvonnoissa</td>\n";
        echo "</tr>\n";
        $query = "select * from tulos";
        $tuloskysely = pg_exec($db_handle, $query);
        if ($tuloskysely) {
            while ($row = pg_fetch_row($tuloskysely)) {
                echo "<tr>\n";
                echo "<td>$row[0]</td>\n";
                echo "<td>$row[1]</td>\n";
                echo "<td>$row[2]</td>\n";
                echo "<td>$row[5]</td>\n";
                echo "<td>$row[3]</td>\n";
                echo "<td>$row[4]</td>\n";
                echo "<td>$row[6]</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n<br><br>";
        } else {
            echo "Error!\n<br>";
            die('Error: ' . print pg_last_error($db_handle));
        }
        // Poistetaan vanha taulu mikäli sellainen on
        $query = "drop table viralliset_tulokset";
        $result = pg_exec($db_handle, $query);
        // Ja laitetaan temptaulu viralliseksi tulostauluksi
        $query = "select * into viralliset_tulokset from tulos";
        $result = pg_exec($db_handle, $query);
        echo "<br><a href=\"index.php\"> Back </a>";
        ?>
    </body>
</html>