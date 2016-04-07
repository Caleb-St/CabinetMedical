<?php
session_start ();

// print_r($_SESSION["host"] );

$host = $_SESSION ["host"];
$port = $_SESSION ["port"];
$dbname = $_SESSION ["db"];
$credentials = $_SESSION ["credentials"];

$db = pg_connect ( "$host $port $dbname $credentials" );

function updateHotel($db, $hotelno, $hname, $city) {
	$sql = <<<EOF
      UPDATE HotelDB.hotel set hotelName = '$hname' where hotelNo='$hotelno';
EOF;
	$ret = pg_query ( $db, $sql );
	if (! $ret) {
		echo pg_last_error ( $db );
		exit ();
	} else {
		echo "Record updated successfully <br>";
	}
	
	$sql = <<<EOF
      SELECT * from HotelDB.Hotel where hotelNo = '$hotelno';
EOF;
	
	$ret = pg_query ( $db, $sql );
	if (! $ret) {
		echo pg_last_error ( $db );
		exit ();
	}
	while ( $row = pg_fetch_row ( $ret ) ) {
		echo "HotelNo = " . $row [0] . "<br>";
		echo "Name = " . $row [1] . "<br>";
		echo "city = " . $row [2] . "<br>";
	}
	echo "Operation done successfully\n";
}

updateHotel ( $db, 'H116', 'Novotel', 'Montreal' );

pg_close ( $db );
?>