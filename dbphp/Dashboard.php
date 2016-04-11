<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$userID = $_SESSION["userID"];

$_SESSION["userIsDoctor"] = $isDoctor = $userID[0] == 'M' || $userID[0] == 'm';
$_SESSION["userIsSecretary"] = $isSecretary = $userID[0] == 'S' || $userID[0] == 's';

$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$consultation = pg_fetch_row($ret);

if(isset($_GET['delete_id'])) //si on supprime une consultation
{
	$pid = $_GET['delete_id'][0]. $_GET['delete_id'][1]. $_GET['delete_id'][2]. $_GET['delete_id'][3];
	$mid = $_GET['delete_id'][4]. $_GET['delete_id'][5]. $_GET['delete_id'][6]. $_GET['delete_id'][7];
	$dt = $_GET['delete_id'][8]. $_GET['delete_id'][9]. $_GET['delete_id'][10]. $_GET['delete_id'][11]. $_GET['delete_id'][12]. $_GET['delete_id'][13]. $_GET['delete_id'][14]. $_GET['delete_id'][15]. $_GET['delete_id'][16]. $_GET['delete_id'][17];
	echo "DELETE FROM Consultation WHERE patid='$pid' AND medid='$mid' AND cdate='$dt';";
	$query_DelConsult="DELETE FROM Consultation WHERE patid='$pid' AND medid='$mid' AND cdate='$dt';";
	$delete = runQuery($query_DelConsult);
	header("Location: $_SERVER[PHP_SELF]");
}

/* Permet de naviguer à une consultation en cliquant sa rangée. */
function viewConsultation($patient,$med,$date) {
	echo "document.location = 'ViewConsultation.php?con=$patient$med$date';";
}
?>
<div class="col-md-6 col-md-offset-3">
<h2><span>Vos consultations ajourd'hui</span></h2>
<div class="panel panel-default">
<table class="table table-striped table-hover">
	<thead>
		<tr>
<?php
//retourner la liste des consultations pour l'usager
if ($isDoctor) {	
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID='$userID' AND c.cdate = current_date ORDER BY heure;";
} else {
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID IN (SELECT m.medid FROM medecin as m WHERE m.secid ='$userID') AND c.cdate = current_date ORDER BY heure;";
}
$appointmentsToday = runQuery($query_GetConsultList);
$consultation = pg_fetch_row($appointmentsToday);
if (pg_num_rows($appointmentsToday) > 0){
?>
			<th>Heure</th>
			<th>Patient</th>
			<th>Duree</th>
		</tr>
	</thead>
	<tbody>
		    <?php do { ?>
        	    <tr onclick="<?php viewConsultation($consultation[0], $consultation[1], $consultation[2])?>" style="cursor:pointer;" >
        			<td><?php echo $consultation[3];?></td>
        			<td><?php echo $consultation[4] . ' ' . $consultation[5];?></td>
        			<td><?php echo $consultation[6];?></td>
        		</tr>
        	<?php } while ($consultation = pg_fetch_row($appointmentsToday));  ?>
	</tbody>
<?php } else { ?>	
			<th>Auncun rendez-vous aujourd'hui</th>
		</tr>
	</thead>
<?php }?>
</table>
</div>
<br>
<h2><span>Vos consultations futures</span></h2>
<div class="panel panel-default">
<table class="table table-striped table-hover">
	<thead>
		<tr>
<?php
//retrouner la liste des consultations futures pour l'usager
if ($isDoctor) {
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID='$userID' AND c.cdate > current_date ORDER BY heure;";
} else {
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID IN (SELECT m.medid FROM medecin as m WHERE m.secid ='$userID') AND c.cdate > current_date ORDER BY heure;";
}
$appointmentsToday = runQuery($query_GetConsultList);
$consultation = pg_fetch_row($appointmentsToday);
if (pg_num_rows($appointmentsToday) > 0){
?>
			<th>Heure</th>
			<th>Patient</th>
			<th>Duree</th>
		</tr>
	</thead>
	<tbody>
	    <?php do { ?>
     	    <tr onclick="<?php viewConsultation($consultation[0], $consultation[1], $consultation[2])?>" style="cursor:pointer;">
       			<td><?php echo $consultation[3];?></td>
       			<td><?php echo $consultation[4] . ' ' . $consultation[5];?></td>
       			<td><?php echo $consultation[6];?></td>
       		</tr>
   		<?php } while ($consultation = pg_fetch_row($appointmentsToday));  ?>
	</tbody>
<?php } else { ?>		
			<th>Auncun futur rendez-vous</th>
		</tr>
	</thead>
<?php }?>
</table>
</div>
<?php if ($isSecretary) {?><a class="btn btn-default" href="ViewConsultation.php"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>  Nouveau</a><?php } ?>
</div>
</body>
</html>