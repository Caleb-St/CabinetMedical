<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$tableHeaders;
$tableData;


$userID = $_SESSION["userID"];

$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$row = pg_fetch_row($ret);
?>
<h2><span>Vos consultations ajourd'hui</span></h2>
<div class="panel panel-default">
<?php	
$query_GetConsultList = "SELECT heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID='$userID' AND c.cdate = current_date ORDER BY c.cdate;";
$appointmentsToday = runQuery($query_GetConsultList);
$row = pg_fetch_row($appointmentsToday);
if (pg_num_rows($appointmentsToday) > 0){
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Heure</th>
			<th>Patient</th>
			<th>Duree</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		    <?php do { ?>
        	    <tr>
        			<td><?php echo $row[0];?></td>
        			<td><?php echo $row[1] . ' ' . $row[2];?></td>
        			<td><?php echo $row[3];?></td>
        			<td>Details | Modifier | Supprimer</td>
        		</tr>
        	<?php } while ($row = pg_fetch_row($appointmentsToday));  ?>
	</tbody>
</table>
<?php } else { ?>	
<table class="table table-striped">
	<thead>
		<tr>
			<th>Auncun rendez-vous aujourd'hui</th>
		</tr>
	</thead>
</table>
<?php }?>
</div>


<h2><span>Vos consultations futures</span></h2>
<div class="panel panel-default">
<?php	
$query_GetConsultList = "SELECT heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID='$userID' AND c.cdate > current_date ORDER BY c.cdate;";
$appointmentsToday = runQuery($query_GetConsultList);
$row = pg_fetch_row($appointmentsToday);
if (pg_num_rows($appointmentsToday) > 0){
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Heure</th>
			<th>Patient</th>
			<th>Duree</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	    <?php do { ?>
     	    <tr>
       			<td><?php echo $row[0];?></td>
       			<td><?php echo $row[1] . ' ' . $row[2];?></td>
       			<td><?php echo $row[3];?></td>
       			<td>Details | Modifier | Supprimer</td>
       		</tr>
   		<?php } while ($row = pg_fetch_row($appointmentsToday));  ?>
	</tbody>
</table>	
<?php } else { ?>		
<table class="table table-striped">
	<thead>
		<tr>
			<th>Auncun futur rendez-vous</th>
		</tr>
	</thead>
</table>
<?php }?>
</div>
</body>
</html>