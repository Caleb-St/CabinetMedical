
<!DOCTYPE HTML>
<?php
session_start ();
$host = $_SESSION ["host"];
$port = $_SESSION ["port"];
$dbname = $_SESSION ["db"];
$credentials = $_SESSION ["credentials"];
$hn = 'HTest';

$db = pg_connect ( "$host $port $dbname $credentials" );

?>
<html>
<head>
<style>
.error {
	color: #FF0000;
}
</style>
</head>
<body>

	<h2>New booking</h2>

	<form action="newReservation.php" method="post">
		Hotel number: <br>
		<!--   <input type="text" name="hotelno"><br> -->
<?php
// session_start ();
// $host = $_SESSION ["host"];
// $port = $_SESSION ["port"];
// $dbname = $_SESSION ["db"];
// $credentials = $_SESSION ["credentials"];

// $db = pg_connect ( "$host $port $dbname $credentials" );
$hNo = 'H0';
function viewHotel($db) {
	$sql = <<<EOF
      SELECT * from HOTELDB.HOTEL;
EOF;
	
	$ret = pg_query ( $db, $sql );
	if (! $ret) {
		echo pg_last_error ( $db );
		exit ();
	}
	
	echo "<select id = 'hotelno' name='hotelno'>";
	while($row = pg_fetch_row($ret)){	
		echo '<option value="' .  $row[0] . '">' .  $row[0] . '</option>';
	}
	
	$hNo = $_POST['hotelno'];
	
	echo "</select>";
}
viewHotel($db);


 ?>
<br> Guest number: <br> 
<!-- <input type="text" name="guestno"><br>  -->

<?php

function viewGuests($db) {
	$sqlg = <<<EOF
      SELECT * from HOTELDB.Guest;
EOF;
	
	$retg = pg_query ( $db, $sqlg );
	if (! $retg) {
		echo pg_last_error ( $db );
		exit ();
	}
	
	echo "<select name='guestno'>";
	while($rowg = pg_fetch_row($retg)){	
		echo '<option value="' .  $rowg[0] . '">' .  $rowg[0] . '</option>';
	}
	echo "</select>";
}
viewGuests($db);
?>

<br> Room number: <br>
<input 	type="text" name="roomno"><br> 
<br>
Start date: <br> <input type="text" name="start"><br> 
<br> End date: <br><input type="text" name="end"><br> 
<br> <input type="submit"
			name="submit" value="submit">
</form>
</body>
</html>