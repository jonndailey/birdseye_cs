<META http-equiv="refresh" content="4;checkin.php">
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
$theNewNote = mysqli_real_escape_string($connection, $_REQUEST['secondNote']);
$reuse = mysqli_real_escape_string($connection, $_REQUEST['reuse']);
$datecode = mysqli_real_escape_string($connection, $_REQUEST['date_code']);
$firmware = mysqli_real_escape_string($connection, $_REQUEST['firmware']);
$issues = mysqli_real_escape_string($connection, $_REQUEST['issues']);

mysqli_query($connection, "INSERT INTO logged_info (date_returned) VALUES ('$identification') = CURDATE() WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (note2) VALUES ('$theNewNote') WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (reuse) VALUES ('$reuse') WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (date_code) VALUES ('$datecode') WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (firmware_version) VALUES ('$firmware') WHERE tid =  $identification;");
mysqli_query($connection, "INSERT INTO logged_info (issues) VALUES ('$issues') WHERE tid =  $identification;");



mysqli_query($connection, "UPDATE logged_info SET date_returned = CURDATE() WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET note2 = '$theNewNote' WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET reuse = '$reuse' WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET date_code = '$datecode' WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET firmware_version = '$firmware' WHERE tid =  $identification;");
mysqli_query($connection, "UPDATE logged_info SET issues = '$issues' WHERE tid =  $identification;");


echo "All set!";


?>
