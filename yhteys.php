<?php

        function dbconnect() {
            $host = "dbstud.sis.uta.fi";
            $port = "5432";
            $username = "vm92179";
            $password = "salabug1";
            $dbname = "vm92179";
            
            $options =  " host='$host' port='$port' user='$username' password='$password' dbname='$dbname' ";
            $dbcon = pg_connect($options);
            return $dbcon;
    
        } 
?>
