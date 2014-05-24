<?php
	mysql_connect("localhost", "atRiseSolutions", "awrsql@51") or die ('I cant connect');
	$databaseQuery = 'use edify';
	$result = mysql_query($databaseQuery) or die('Query failed: ' . mysql_error());
	session_start();
?>
