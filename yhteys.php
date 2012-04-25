<?php

        function dbconnect() {
            $host = "";
            $port = "";
            $username = "";
            $password = "";
            $dbname = "";
            
            $options =  " host='$host' port='$port' user='$username' password='$password' dbname='$dbname' ";
            $dbcon = pg_connect($dbname);
            return $dbcon;
    
        } 
?>
