<?php
 function db_connect() {
	$host = "host=www.eecs.uottawa.ca";
	$port = "port=15432";
	$dbname = "dbname=mwatt023";
	$credentials = "user=mwatt023 password=52650@WAts";
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