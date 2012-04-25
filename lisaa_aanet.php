<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Lisaa aanet.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <?php
    include('yhteys.php');
    
    //$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = dbconnect();
    $query="SELECT * FROM aanestyspaikka";
    $result = pg_exec($db_handle, $query);
    $selects="";
    $selects.="<OPTION VALUE=\"choose\"> Valitse </option>";
    $selectstwo="";
    $selectstwo.="<OPTION VALUE=\"choose\"> Valitse </option>";
    while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[1];
        $selects.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    $query="SELECT * FROM edustaja";
    $result = pg_exec($db_handle, $query);
    while ($row = pg_fetch_row($result)) {
        $nimi=$row[0];
        $tunnus=$row[0];
        $selectstwo.="<OPTION VALUE=\"$tunnus\">".$nimi.'</option>';
    }
    ?>
        <p> Lisaa edustajan saamat aanet. </p>
        <form name="aanet" action="script.php" method="post">
        <input type="hidden" name="type" value="aanet" />
        <table border="0" >
	<tr>
		<td>Äänestyspaikka</td>
		<td>Edustaja</td>
		<td>Äänimäärä</td>
	</tr>
	<tr>
		<td><SELECT NAME="aanestyspaikka">
            <?php echo $selects;
            ?>
            </SELECT></td>
		<td><SELECT NAME="edustaja">
            <?php echo $selectstwo;
            ?>
            </SELECT></td>
		<td><input type="text" name="numero" /></td>
	</tr>
        <tr>
            <td><input type="submit" value="submit"></td>
        </tr>
</table>
        </form>
    </body>
</html>
