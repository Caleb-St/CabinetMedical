<?php
$tableHeaders;
$tableData;

require_once("DatabaseManager.php");
session_start ();
$userID = $_SESSION["userID"];

if ($userID[0] == 'M') {
	$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
	$consultation = pg_fetch_row($ret);
} else {
	$ret = runQuery("SELECT nom,prenom from Secretaire WHERE secID='$userID';");
	$consultation = pg_fetch_row($ret);
}
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">CabMD</a>
    </div>
    <ul class="nav navbar-nav navbar-left">
      <li><a href="main.php">Home</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultations
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="ViewConsultation.php">Ajout</a></li>
          <li><a href="Dashboard.php">Mes consultations</a></li>
          <li><a href="ViewAll.php">Toutes consultations</a></li> 
        </ul>
      </li> 
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php if ($userID[0] == 'M') {?>
    	<li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> Dr. <?php echo $consultation[1] . " " . $consultation[0];?></a></li>
    	<?php } else {?>
    	<li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $consultation[1] . " " . $consultation[0];?></a></li>
    	<?php }?>
    	<li><a href="/CabinetMedical/dbphp/main.php">Deconnexion</a></li>
    </ul>
  </div>
</nav>