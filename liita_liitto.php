<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Liita vaaliliitto vaalirenkaaseen</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <?php
    include('yhteys.php');
    
    //$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = dbconnect();
    $query="SELECT * FROM vaaliliitto";
    $result = pg_exec($db_handle, $query);
    $selects="";
    $selects.="<OPTION VALUE=\"choose\"> Valitse </option>";
    $selectstwo="";
    $selectstwo.="<OPTION VALUE=\"choose\"> Valitse </option>";
    $selectsthree="";
    $selectsthree.="<OPTION VALUE=\"choose\"> Valitse </option>";
    while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[1];
        $selects.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    $query="SELECT * FROM vaalirengas";
    $result = pg_exec($db_handle, $query);
    while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[1];
        $selectstwo.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    $query="SELECT * FROM edustaja";
    $result = pg_exec($db_handle, $query);
        while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[0];
        $selectsthree.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    ?>
        <p> Liita vaaliliitto vaalirenkaaseen. </p>
        <form name="liitos" action="script.php" method="post">
            <input type="hidden" name="type" value="liitaliitto" />
            Vaaliliitto:
            <SELECT NAME="vaaliliitto">
            <?php echo $selects;
            ?>
            </SELECT>
            Vaalirengas:
            <SELECT NAME="vaalirengas">
            <?php echo $selectstwo;
            ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
    </body>
</html>
