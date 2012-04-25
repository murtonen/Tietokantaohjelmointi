<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Lisaa edustaja</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <?php
    include("yhteys.php");
    
    //$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = dbconnect();
    $query="SELECT * FROM opiskelija";
    $result = pg_exec($db_handle, $query);
    $selects="";
    $selects.="<OPTION VALUE=\"choose\"> Valitse </option>";
    while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[0];
        $selects.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    ?>
    <p> Lisaa opiskelija edustajaksi </p>
    <form action="script.php" method="post">      
    <input type="hidden" name="type" value="edustaja" />
    Opiskelijanumero: 
    <SELECT NAME="numero">
    <?php echo $selects;
    ?>
    </SELECT>
    <input type="submit" value="submit">
    </form>
</html>
