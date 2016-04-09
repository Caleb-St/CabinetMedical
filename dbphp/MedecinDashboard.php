<?php include("Header.php"); ?>
<body>
<?php
$tableHeaders;
$tableData;

require_once("DatabaseManager.php");
session_start ();
$userID = $_SESSION["userID"];

$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$row = pg_fetch_row($ret);
?>
<nav class="navbar navbar-default">
	<div class="container-fluid">
	<span> <?php echo "Bonjour Dr. " . $row[1] . " " . $row[0]; ?> </span>
	<a class='pull-right' href="/CabinetMedical/dbphp/main.php">Deconnexion</a>
</nav>
<h2>
  <span>Vos consultations ajourd'hui</span>
  <a class='btn btn-primary' href="/CabinetMedical/dbphp/main.php">Go</a>
</h2>
<p> Cliquer sur "Go" pour effecter votre prochaine consultation, ou bien cliquer sur une consultation ci-dessous pour y acceder directement. </p>
<?php 
$sql = "SELECT heure, concat(prenom, ' ', nom), duree FROM consultation NATURAL JOIN Patient WHERE medID='$userID' AND cdate =current_date;";
$appointmentsToday = runQuery($sql);

if(pg_num_rows($appointmentsToday) == 0) {
	echo "<b>Vous n'avez aucune consultation ajourd'hui.</b>";
}
else {
	$tableHeaders = array( "Heure", "Patient", "Duree");
	$tableData = $appointmentsToday;
	include("TableTemplate.php");
}
?>
<h2>Vos consultations prochaines</h2>
<?php
$sql = "SELECT cdate, heure, concat(' ', prenom, nom), duree FROM consultation NATURAL JOIN Patient WHERE medID='$userID' AND cdate > current_date ORDER BY cdate;";
$appointmentsNext = runQuery($sql);

if(pg_num_rows($appointmentsNext) == 0) {
	echo "<b>Vous n'avez aucunes consultations prochaines.</b>";
}
else {
	$tableHeaders = array("Date", "Heure", "Patient", "Duree");
	$tableData = $appointmentsNext;
	include("TableTemplate.php");
}
?>
</body>
</html>