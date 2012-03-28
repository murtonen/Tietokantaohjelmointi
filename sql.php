<head>

<title></title>

</head>
<body>

<p><H1> Hei! Tervetuloa valtavan hienoon tietokantaohjelmaan! </H1></p>

<?php
$options = " host='dbstud.sis.uta.fi' port='5432' user='vm92179' password='xxxxxxx' dbname='vm92179' ";
$db_handle = pg_connect($options);
$query = "select opnum from yk.opiskelija";
$result = pg_exec($db_handle, $query);
if ($result) {
    echo "The query executed successfully.<br>\n";
}
$summaone = 0;
$summatwo = 0;
while ($row = pg_fetch_row($result)) {
  $opiskelija = $row[0];
  $query = "select * from yk.suoritus,yk.kurssit where yk.suoritus.knro=yk.kurssit.kurssinro AND onro = '$opiskelija'";
  $resulttwo = pg_exec($db_handle, $query);
  while ($rowtwo = pg_fetch_row($resulttwo)) {
        $summaone = $summaone+($rowtwo[2]*$rowtwo[6]);
        $summatwo = $summatwo + $rowtwo[6];
  }
  $keskiarvo = $summaone / $summatwo;
  $query = "update yk.opiskelija set keskiarvo ='$keskiarvo' where opnum = '$opiskelija'";
  $resultthree = pg_exec($db_handle, $query);
}
pg_freeresult($result);
pg_freeresult($resulttwo);
pg_freeresult($resultthree);
pg_close($db_handle);

?>
</body>
</html>
