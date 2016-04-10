<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$userID = $_SESSION["userID"];

$_SESSION["userIsDoctor"] = $isDoctor = $userID[0] == 'M' || $userID[0] == 'm';
$_SESSION["userIsSecretary"] = $isSecretary = $userID[0] == 'S' || $userID[0] == 's';

$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$consultation = pg_fetch_row($ret);

/* Permet de naviguer à une consultation en cliquant sa rangée. */
function viewConsultation($patient,$med,$date) {
	echo "document.location = 'ViewConsultation.php?con=$patient$med$date';";
}
?>
<div class="col-md-6 col-md-offset-3">
<h2><span>Toutes consultations ajourd'hui</span></h2>
<div class="panel panel-default">
<table class="table table-striped table-hover">
	<thead>
		<tr>
<?php
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.cdate = current_date ORDER BY c.cdate, c.heure;";
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
        	    <tr>
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
<h2><span>Toutes consultations futures</span></h2>
<div class="panel panel-default">
<table class="table table-striped table-hover">
	<thead>
		<tr>
<?php
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.cdate > current_date ORDER BY c.cdate, c.heure;";
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
     	    <tr>
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
