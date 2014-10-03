
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$sql = "INSERT INTO logged_info (ticket_number, customer_name, incoming_barcode, outgoing_barcode, selected_product) 
	VALUES ('$ticket','$name','$inTrack','$outTrack', '$dropdown')";
}




if (!mysqli_query($connection,$sql)) {
  die('Connection succsseful ' . mysqli_error($connection));
}

header("Location:checkout.php");

?>