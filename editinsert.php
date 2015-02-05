<?php

include('db.php');

$customername = mysqli_real_escape_string($connection, $_REQUEST['customer_name']);
$customeremail = mysqli_real_escape_string($connection, $_REQUEST['customer_email']);
$routingquery = mysqli_real_escape_string($connection, $_REQUEST['cid']);
$identification = mysqli_real_escape_string($connection, $_REQUEST['tid']);
$myticket = mysqli_real_escape_string($connection, $_REQUEST['ticket']);
$inTrack = mysqli_real_escape_string($connection, $_REQUEST['incoming']);
$outTrack = mysqli_real_escape_string($connection, $_REQUEST['outgoing']);
$firstNote = mysqli_real_escape_string($connection, $_REQUEST['note1']);
$secondNote = mysqli_real_escape_string($connection, $_REQUEST['note2']);
$myproducts = mysqli_real_escape_string($connection, $_REQUEST['myproduct']);
$mywarranty = mysqli_real_escape_string($connection, $_REQUEST['mywarranty']);
$mydestination = mysqli_real_escape_string($connection, $_REQUEST['mydestination']);
$quantity = mysqli_real_escape_string($connection, $_REQUEST['myquantity']);
$mypackage = mysqli_real_escape_string($connection, $_REQUEST['mypackage']);


//for removing a checked in item.

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

		if ($myproducts != 50) {
			mysqli_query($connection, "UPDATE logged_info SET selected_product = $myproducts WHERE tid = $identification");
		}
		
		if ($mydestination != 50) {
			mysqli_query($connection, "UPDATE logged_info SET location = $mydestination WHERE tid = $identification");
		}
	
		
		if ($quantity != 20) {
			mysqli_query($connection, "UPDATE logged_info SET quantity = $quantity WHERE tid = $identification");
		}


		if ($mywarranty != 3) {
			mysqli_query($connection, "UPDATE logged_info SET warranty = $mywarranty WHERE tid = $identification");
		}

		if ($mypackage != 6) {
			mysqli_query($connection, "UPDATE logged_info SET weight = $mypackage WHERE tid = $identification");
		}

	//Update or insert the changed information
	mysqli_query($connection, "UPDATE logged_info SET ticket_number = '$myticket' WHERE tid = $identification");
	mysqli_query($connection, "INSERT INTO logged_info (ticket_number) VALUES ('$myticket') WHERE tid =  $identification");

	//Update or insert the changed information
	mysqli_query($connection, "UPDATE logged_info SET incoming_barcode = '$inTrack' WHERE tid = $identification");
	mysqli_query($connection, "INSERT INTO logged_info (incoming_barcode) VALUES ('$inTrack') WHERE tid =  $identification");

	//Update or insert the changed information
	mysqli_query($connection, "INSERT INTO logged_info (outgoing_barcode) VALUES ('$outTrack') WHERE tid =  $identification");
	mysqli_query($connection, "UPDATE logged_info SET outgoing_barcode = '$outTrack' WHERE tid = $identification");
		
	//Update or insert the changed information
	mysqli_query($connection, "INSERT INTO logged_info (note) VALUES ('$firstNote') WHERE tid =  $identification;");
	mysqli_query($connection, "INSERT INTO logged_info (note2) VALUES ('$secondNote') WHERE tid =  $identification;");

	//Update or insert the changed information
	mysqli_query($connection, "UPDATE logged_info SET note = '$firstNote' WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET note2 = '$secondNote' WHERE tid = $identification");


	//update customer name
	if ($customername == '') {
	}else mysqli_query($connection, "UPDATE customers SET name = '$customername' WHERE cid = $routingquery");

	if ($customeremail == '') {
	}else mysqli_query($connection, "UPDATE customers SET email = '$customeremail' WHERE cid = $routingquery");
	

}else mysqli_error($connection);



echo "<META http-equiv='refresh' content='.1;customers.php?cid=" . $routingquery . "'>";
?>