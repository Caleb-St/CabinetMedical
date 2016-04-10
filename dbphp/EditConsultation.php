<?php
$isNew = !isset($_GET['con']);
if(!$isNew)
{
$pid = $_GET['con'][0]. $_GET['con'][1]. $_GET['con'][2]. $_GET['con'][3];
$mid = $_GET['con'][4]. $_GET['con'][5]. $_GET['con'][6]. $_GET['con'][7];
$dt = $_GET['con'][8]. $_GET['con'][9]. $_GET['con'][10]. $_GET['con'][11]. $_GET['con'][12]. $_GET['con'][13]. $_GET['con'][14]. $_GET['con'][15]. $_GET['con'][16]. $_GET['con'][17];

$query_GetConsult="SELECT patid, medid, cdate, heure, duree, objet FROM consultation WHERE patid='$pid' AND medid='$mid' AND cdate='$dt'";
$appointments = runQuery($query_GetConsult);
$consultation = pg_fetch_row($appointments);
}
?>
<body>