<?php

session_start();

$host = "host=localhost";
$port = "port=5432";
$dbname = "dbname=projet";
$credentials = "user=postgres password=postgres";

$_SESSION["host"] = $host;
$_SESSION["port"] = $port;
$_SESSION["db"] = $dbname;
$_SESSION["credentials"] = $credentials;

function connectDB($host, $port, $dbname, $credentials) {
	
	$db = pg_connect ( "$host $port $dbname $credentials" );
	if (! $db) {
		echo "Error : Unable to open database\n";
	} else {
		$_SESSION["userID"] = $_POST["userID"];
		header('Location: /CabinetMedical/dbphp/MedecinDashboard.php');
	}
}

connectDB ($host, $port, $dbname, $credentials);

?>