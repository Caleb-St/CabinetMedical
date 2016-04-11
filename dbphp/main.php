<?php 
/* Point of entry for the web app (login page) */
include("Header.php"); //contains HTML head data
session_start();
?>
<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8" />
<style>	
.error {color: #FF0000;}
</style>
</head>
<body>
<div class="col-md-6 col-md-offset-3" style="text-align:center;">
<form class="form-signin" method="post" action="/CabinetMedical/dbphp/LoginManager.php">
	 	<h2>Connexion</h2>
		<div class="form-group">
			<input class ="form-control" type="text" style="max-width:20em; margin:0 auto; text-align:center" placeholder="SVP entrez votre ID" name="userID">
		</div>
	    <button type="submit" class="btn btn-primary" name="submit">Soumettre</button>
	    <div class="clearfix"></div>
		<span class="error">
		<?php if(isset($_SESSION["loginerror"])) { echo $_SESSION["loginerror"]; $_SESSION["loginerror"] = null; } //throw away error once it's displayed ?>
		</span>
</form>
</div>
</body>
</html>