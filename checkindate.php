<META http-equiv="refresh" content=".1;http://localhost/checkin.php">
<link rel="stylesheet" type="text/css" href="styles/glance.css">

<style type="text/css">
	* {
		background-color:#00E676;
	}
</style>

<?php

include('db.php');
$dataset = "<img src=\"images/logo/coffee.png\">";

$identification = $_REQUEST['id'];
$theNewNote = $_REQUEST['secondNote'];
$reuse = $_REQUEST['reuse'];


mysqli_query($connection, "INSERT INTO logged_info (date_returned) VALUES ('$identification') = CURDATE() WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (note2) VALUES ('$theNewNote') WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (reuse) VALUES ('$reuse') WHERE tid =  $identification;");

mysqli_query($connection, "UPDATE logged_info SET date_returned = CURDATE() WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET note2 = '$theNewNote' WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET reuse = '$reuse' WHERE tid =  $identification;");

echo "All set!";


?>
