<?php

include('db.php');
$dataset = "<img src=\"images/logo/coffee.png\">";

$identification = $_REQUEST['id'];

if ($identification) {
	echo $identification;
}else echo "Not working.";



?>

