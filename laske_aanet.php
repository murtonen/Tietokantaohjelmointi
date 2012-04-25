<!DOCTYPE HTML PUBLIC
                 "-//W3C//DTD HTML 4.01 Transitional//EN"
                 "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Doing stuff...</title>
</head>
<body>
<table>
    <tr>
        <td> Edustaja</td>
        <td> Etunimi</td>
        <td> Sukunimi</td>
        <td> Liitto</td>
        <td> Rengas</td>
        <td> Aanet</td>
    </tr>
    
<?php
    include('yhteys.php');
    //$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='salabug1' dbname='vm92179' ";
    $db_handle = dbconnect();
    
    // Muodostetaan query
    $query = "SELECT * FROM opiskelija, edustaja, paikka_aanet WHERE opiskelija.opiskelijanumero=edustaja.vaalinumero ". 
        "AND paikka_aanet.ehdokas_id=edustaja.vaalinumero ORDER BY vaaliliitto,lkm desc";
    $result = pg_exec($db_handle, $query);
    while ($row = pg_fetch_row($result)) {
        echo "<tr>";
            echo "<td>";
            echo $row[0];
            echo "</td>\n";
            
            echo "<td>";
            echo $row[1];
            echo "</td>\n";
            
            echo "<td>";
            echo $row[2];
            echo "</td>\n";
            
            echo "<td>";
            echo $row[4];
            echo "</td>\n";
            
            echo "<td>";
            echo $row[5];
            echo "</td>\n";
            
            echo "<td>";
            echo $row[11];
            echo "</td>\n";
        echo "</tr>";
    }
?>
    </body>
</html>
