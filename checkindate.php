<META http-equiv="refresh" content="3;http://localhost/checkin.php">
<link rel="stylesheet" type="text/css" href="styles/glance.css">

<style type="text/css">
	* {
		background-color:#00E676;
	}
</style>
<?php

include('db.php');



$identification = $_REQUEST['id'];
$theNewNote = $_REQUEST['secondNote'];

echo "<br />";
echo $theNewNote . "*************";


if ($identification && $theNewNote){

	mysqli_query($connection, "UPDATE logged_info SET date_returned = CURDATE() WHERE tid =  $identification;");
	mysqli_query($connection, "UPDATE logged_info SET note2 = '$theNewNote' WHERE tid =  $identification;");
	
	echo "Good, bro";

}


?>
