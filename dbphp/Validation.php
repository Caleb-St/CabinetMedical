<?php
/* Provides validation of form data before querying the database to prevent vulnerability. */
function validateFormData($dataArray) {
	for ($i =0; $i < count($dataArray) ; $i++) {
		$dataArray[$i] = test_input($dataArray[$i]);
	}
}

/* Source: http://www.w3schools.com/php/php_form_validation.asp */
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}