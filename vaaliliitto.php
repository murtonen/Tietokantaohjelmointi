<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Lisaa uusi vaaliliitto</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <?php
    $options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = pg_connect($options);
    $query="SELECT * FROM vaaliliitto";
    $result = pg_exec($db_handle, $query);
    $selects="";
    $selects.="<OPTION VALUE=\"new\"> Lisaa uusi </option>";
    while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[1];
        $selects.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    ?>
        <p> Lisaa uusi vaaliliitto. </p>
        <form name="vaaliliitto" action="http://www.cs.uta.fi/~vm92179/script.php" method="post">
            <input type="hidden" name="type" value="vaaliliitto" />
            Opiskelijan opiskelijanumero: <input type="text" name="numero" /><br /> <br />
            <SELECT NAME="vaaliliitto">
            <?php echo $selects;
            ?>
            </SELECT>
            Vaaliliiton nimi: <input type="text" name="nimi" />
            Vaaliliiton tunnus: <input type="text" name="tunnus" /><br /> <br />
            <input type="submit" value="submit">
        </form>
    </body>
</html>
