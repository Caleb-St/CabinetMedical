<?php
session_start();

//print_r($_SESSION["host"] );

$host = $_SESSION["host"]; 


$port = $_SESSION["port"];
$dbname = $_SESSION["db"];
$credentials = $_SESSION["credentials"];

$db = pg_connect( "$host $port $dbname $credentials"  );

function deleteHotel($db, $id){
$sql =<<<EOF
      DELETE from HotelDB.Hotel where hotelno='$id';
EOF;
$ret = pg_query($db, $sql);
if(!$ret){
	echo pg_last_error($db);
	exit;
} else {
	echo "Record deleted successfully\n";
}
}
 
deleteHotel($db, 'H116');
pg_close($db);
?>