<META http-equiv="refresh" content=".02;http://localhost/checkin.php">
<link rel="stylesheet" type="text/css" href="styles/glance.css">

<style type="text/css">
	* {
		background-color:#00E676;
	}
</style>
<?php




include('db.php');

$myDate = date("m-d-Y");

$identification = $_REQUEST['id'];

if (isset($_GET['id'])){

	mysqli_query($connection, "UPDATE logged_info SET date_returned = CURDATE() WHERE id =  $identification");

}


?>
