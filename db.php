<?php

$connection = mysqli_connect("localhost", "root", "root", "customer_items");


//Successful or not?
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySql: " . mysqli_connect_error();
}else {
	echo "";
};

if ($dataset) {
	echo $dataset;
}

?>
