<?php
	session_start();
	$userName = $_SESSION['userName'];

	echo "Welcome $userName";
?>