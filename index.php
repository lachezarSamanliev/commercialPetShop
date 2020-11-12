<?php
session_start();

//This is the main page of the file
//it calles the nav file which represents the menu for the user, admin, and potential customer
//checks if the sessions are set, if not it creates them and makes them null.
		if( !isset($_SESSION["logged_user"]) )
		$_SESSION["logged_user"] = null;

	if( !isset($_SESSION["admin_rights"]) )
		$_SESSION["admin_rights"] = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Pet Shop</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php

	require_once('model/nav.php');
	require_once('model/two_catalogues.php');


	?>
	
</body>

</html>