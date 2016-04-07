<?php

session_start();

//print_r($_SESSION["host"] );

$host = $_SESSION["host"]; 


$port = $_SESSION["port"];
$dbname = $_SESSION["db"];
$credentials = $_SESSION["credentials"];

$db = pg_connect( "$host $port $dbname $credentials"  );
$sql =<<<EOF
      CREATE TABLE TEST
      (ID INT PRIMARY KEY     NOT NULL,
      NAME           TEXT    NOT NULL,
      AGE            INT     NOT NULL,
      ADDRESS        CHAR(50),
      SALARY         REAL);
EOF;

$ret = pg_query($db, $sql);
if(!$ret){
	echo pg_last_error($db);
} else {
	echo "Table created successfully\n";
}
pg_close($db);
?>