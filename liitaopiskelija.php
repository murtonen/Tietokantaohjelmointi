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
        <p> Liita opiskelija vaaliliittoon. </p>
        <form name="liitos" action="script.php" method="post">
            <input type="hidden" name="type" value="liitto" />
            Edustajan opiskelijanumero:
            <SELECT NAME="numero">
            <?php echo $selectsthree;
            ?>
            </SELECT>
            <SELECT NAME="vaaliliitto">
            <?php echo $selects;
            ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
        <p> Liita opiskelija vaalirenkaaseen. </p>
        <form name="liitos" action="script.php" method="post">
            <input type="hidden" name="type" value="rengas" />
            Edustajan opiskelijanumero:
            <SELECT NAME="numero">
            <?php echo $selectsthree;
            ?>
            </SELECT>
            <SELECT NAME="vaalirengas">
            <?php echo $selectstwo;
            ?>
            </SELECT>
            <input type="submit" value="submit">
        </form>
    </body>
</html>
