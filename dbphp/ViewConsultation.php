<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$isNew = !isset($_GET['con']);
$isSecretary = $_SESSION["userIsSecretary"];

if(!$isNew)
{
	$pid = $_GET['con'][0]. $_GET['con'][1]. $_GET['con'][2]. $_GET['con'][3];
	$mid = $_GET['con'][4]. $_GET['con'][5]. $_GET['con'][6]. $_GET['con'][7];
	$dt = $_GET['con'][8]. $_GET['con'][9]. $_GET['con'][10]. $_GET['con'][11]. $_GET['con'][12]. $_GET['con'][13]. $_GET['con'][14]. $_GET['con'][15]. $_GET['con'][16]. $_GET['con'][17];
	$query_GetConsult="SELECT patid, medid, cdate, heure, duree, objet FROM consultation WHERE patid='$pid' AND medid='$mid' AND cdate='$dt'";
	$appointments = runQuery($query_GetConsult);
	$consultation = pg_fetch_row($appointments);
}
else
	$consultation = array("","","","","","","","");
?>
<div class="col-md-6 col-md-offset-3">
	<h2><span>Details de la consulation</span></h2>
	<div class="panel panel-default">
		<div class="panel-body">
		    <form class="form-horizontal">
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Patient:</label>
		    		<div class="col-md-3">
		    			<?php if($isNew) {	?>
			    			<select class="form-control" name="pat_id">
			    				<?php 
			    				$query_GetPatients = "SELECT patid, prenom, nom FROM patient ORDER BY nom;";
			    				$patients = runQuery($query_GetPatients);
			    				$pnames = pg_fetch_row($patients);
								do {
									echo "<option value='$pnames[0]'>$pnames[1] $pnames[2]</option>";
								} while ($pnames = pg_fetch_row($patients));  ?>
			    			</select>
		    			<?php } else { 
	    					$query_GetPatient = "SELECT prenom, nom FROM patient WHERE patid='$pid';";
	    					$patient = runQuery($query_GetPatient);
	    					$pname = pg_fetch_row($patient);	
	    				?>
		    			<input type="text" class="form-control" name="pat_id" value="<?php echo $pname[0]. ' ' . $pname[1];?>" disabled>
		    			<?php }?>
		    		</div>
		    		<label class="col-md-2 control-label">Medecin:</label>
		    		<div class="col-md-3">
		    			<?php if($isNew) {	?>
			    			<select class="form-control" name="med_id">
			    				<?php 
			    				$query_GetMedecins = "SELECT medid, prenom, nom FROM medecin ORDER BY nom;";
			    				$medecins = runQuery($query_GetMedecins);
			    				$mnames = pg_fetch_row($medecins);
								do {
									echo "<option value='$mnames[0]'> $mnames[1] $mnames[2]</option>";
			    				} while ($mnames = pg_fetch_row($medecins));  
			    				?>
			    			</select>
		    			<?php } else { 
		    				$query_GetMedecin = "SELECT prenom, nom FROM medecin WHERE medID='$mid';";
		    				$medecin = runQuery($query_GetMedecin);
		    				$mname = pg_fetch_row($medecin);
	    				?>
	    					<input type="text" class="form-control" name="pat_id" value="<?php echo $mname[0]. ' ' . $mname[1];?>" disabled>
		    			<?php }?>
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Date:</label>
		    		<div class="col-md-3">
		    			<input type="date" class="form-control" name="first_name" value="<?php echo $consultation[2];?>" <?php if(!$isSecretary) echo "disabled"?> />
		    		</div>
		    		<label class="col-md-2 control-label">Heure:</label>
		    		<div class="col-md-3">
		    			<input type="time" class="form-control" name="first_name" value="<?php echo $consultation[3];?>" <?php if(!$isSecretary) echo "disabled"?> />
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Duree:</label>
		    		<div class="col-md-3">
		    			<input type="text" class="form-control" name="first_name" value="<?php echo $consultation[4];?>"  />
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Objet:</label>
		    		<div class="col-md-8">
		    			<input type="text" class="form-control" name="first_name" value="<?php echo $consultation[5];?>" <?php if($isSecretary) echo "disabled"?>/>
		    		</div>
		    	</div>
		    </form>
		</div>
	    <div class="panel-footer" align="center">
	    	<button class="btn btn-success">Sauvegarder</button>
	    	<?php if($isSecretary) { ?><button class="btn btn-danger">Supprimer</button> <?php } ?>
	    	<a class="btn btn-default" href="Dashboard.php">Retour</a>
	    </div>
	</div>
</div>
</body>
</html>