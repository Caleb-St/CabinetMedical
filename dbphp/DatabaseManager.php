<?php
 function db_connect() {
	$host = "host=localhost";
	$port = "port=5432";
	$dbname = "dbname=projet";
	$credentials = "user=postgres password=postgres";
	return pg_connect ( "$host $port $dbname $credentials" );
}

 function runQuery($query) {
	$db = db_connect();
	if(! $db) {
		echo "Error : Unable to connect to the database\n";
		exit();
	}
	pg_exec($db, "SET search_path = 'cabinetmd';");
	$ret = pg_query ( $db, $query );
	if (! $ret) {
		echo pg_last_error ( $db );
		exit ();
	}
	return $ret;
}
?>
