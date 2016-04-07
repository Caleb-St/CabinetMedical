<?php
session_start ();

// print_r($_SESSION["host"] );

$host = $_SESSION ["host"];
$port = $_SESSION ["port"];
$dbname = $_SESSION ["db"];
$credentials = $_SESSION ["credentials"];

$db = pg_connect ( "$host $port $dbname $credentials" );

// INSERT INTO HOTELDB.Booking VALUES ('H111', 'G111', '2016-02-01', '2016-04-04', '1');
function insertBooking($db, $hotelno, $guestno, $start, $end, $roomno) {
	$sql = <<<EOF
		INSERT INTO HOTELDB.Booking(hotelno, guestno, datefrom, dateto, roomno) 
		VALUES ('$hotelno', '$guestno', '$start', '$end', '$roomno');
			
EOF;
	
	$ret = pg_query ( $db, $sql );
	if (! $ret) {
		echo "Insertion error " + pg_last_error ( $db );
	} else {
		echo "Records created successfully\n";
	}
}

insertBooking ($db, $_POST['hotelno'], $_POST['guestno'], 
		$_POST['start'], $_POST['end'], $_POST['roomno']);

pg_close ($db);
?>
