<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Tables from MySQL Database</title>
 
<style type="text/css">
table.db-table          { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
table.db-table th       { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td       { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
</style>
 
</head>
<body>
<?php
session_start();



//print_r($_SESSION["host"] );

$host = $_SESSION["host"]; 
$port = $_SESSION["port"];
$dbname = $_SESSION["db"];
$credentials = $_SESSION["credentials"];

$db = pg_connect( "$host $port $dbname $credentials"  );

function viewHotel($db){
	$sql = <<<EOF
      SELECT hotelName from HOTELDB.HOTEL;
EOF;
	
	$ret = pg_query ( $db, $sql );
	if (! $ret) {
		echo pg_last_error ( $db );
		exit ();
	}
	
	while($row = pg_fetch_row($ret)){
		echo $row[0] . '<br>';
	}
}

viewHotel($db);
pg_close($db);
?>