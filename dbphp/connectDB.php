<?php

require_once("DatabaseManager.php");
session_start();

db_connect(); //try connecting to the DB just to make sure we have access before proceeding.

$_SESSION["userID"] = $_POST["userID"];

	header('Location: /CabinetMedical/dbphp/MedecinDashboard.php');

?>