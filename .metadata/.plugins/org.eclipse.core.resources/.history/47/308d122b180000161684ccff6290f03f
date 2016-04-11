<table class="table table-striped">
<tr>
<?php
for($i=0; $i<count($tableHeaders); $i++)
		echo "<th>" . $tableHeaders[$i] . "</th>\n";
?>
</tr>
<?php
while($consultation = pg_fetch_row($tableData)){
	echo "<tr> \n";
	for($i=0; $i<pg_num_fields($tableData); $i++) {
		echo "<td>" . $consultation[$i] . "</td>";
	}
	echo "</tr> \n";
}
?>
</table>
