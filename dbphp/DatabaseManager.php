<?php
 function db_connect() {
	require "Configuration.php";
	return pg_connect ( "$config_host $config_port $config_dbname $config_credentials" );
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
