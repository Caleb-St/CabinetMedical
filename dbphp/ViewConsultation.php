<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$pid = $_GET['con'][0]. $_GET['con'][1]. $_GET['con'][2]. $_GET['con'][3];
$mid = $_GET['con'][4]. $_GET['con'][5]. $_GET['con'][6]. $_GET['con'][7];
$dt = $_GET['con'][8]. $_GET['con'][9]. $_GET['con'][10]. $_GET['con'][11]. $_GET['con'][12]. $_GET['con'][13]. $_GET['con'][14]. $_GET['con'][15]. $_GET['con'][16]. $_GET['con'][17];

if(isset($_GET['con']))
{
 $query_GetConsult="SELECT objet FROM consultation WHERE patid='$pid' AND medid='$mid' AND cdate='$dt'";
 $appointments = runQuery($query_GetConsult);
 $row = pg_fetch_row($appointments);
}
if(isset($_POST['btn-update']))
{
 // variables for input data
 $first_name = $_POST['first_name'];
 $last_name = $_POST['last_name'];
 $city_name = $_POST['city_name'];
 // variables for input data
 
 // sql query for update data into database
 //$sql_query = "UPDATE users SET first_name='$first_name',last_name='$last_name',user_city='$city_name' WHERE user_id=".$_GET['edit_id'];
 //       mysql_query($sql_query));
 // sql query for update data into database 
}
?>

<div class="col-md-6">
<h2><span>Modififer la consulation</span></h2>
<div class="panel panel-default">
<center>
<div id="body">
 <div id="content">
    <form method="post"><
    <table align="center">
    <tr>
    <td><input type="text" class="form-control" name="first_name" placeholder="First Name" value="test" required /></td>
    </tr>
    <tr>
    <td><input type="text" name="last_name" placeholder="Last Name" value="test" required /></td>
    </tr>
    <tr>
    <td><input type="text" name="city_name" placeholder="City" value="test" required /></td>
    </tr>
    <tr>
    <td>
    <button type="submit" name="btn-update"><strong>UPDATE</strong></button>
    </td>
    </tr>
    </table>
    </form>
    </div>
</div>

</center>
</body>
</html>