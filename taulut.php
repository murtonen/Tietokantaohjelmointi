<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Taulun sisalto.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        // Tyyppimuuttuja sisään
        $type = $_POST["type"];

        // Tietokannan alustus
        $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
        $db_handle = pg_connect($options);

        $query = "select c.relname FROM pg_catalog.pg_class c LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace WHERE c.relkind IN ('r','') AND n.nspname NOT IN ('pg_catalog', 'pg_toast') AND pg_catalog.pg_table_is_visible(c.oid)";
        $result = pg_exec($db_handle, $query);
        $selects = "";
        $selects.="<OPTION VALUE=\"choose\"> Valitse </option>";

        while ($row = pg_fetch_row($result)) {
            $nimi = $row[0];
            $selects.="<OPTION VALUE=\"$nimi\">" . $nimi . '</option>';
        }

        if ($type == taulut) {
            $taulu = $_POST["taulu"];
            $query = "select * from $taulu";
            $result = pg_exec($db_handle, $query);
            echo "$taulu<br><br>";
            echo "<table border=\"1\">\n";
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
        }
        ?>
        <p> Liita opiskelija vaaliliittoon. </p>
        <form name="taulut" action="http://www.cs.uta.fi/~vm92179/taulut.php" method="post">
            <input type="hidden" name="type" value="taulut" />
            Taulu jonka sisalto listataan:
            <SELECT NAME="taulu">
                <?php echo $selects;
                ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
    </body>
</html>