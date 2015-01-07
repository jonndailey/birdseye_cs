<?php

include('db.php');

$routingquery = $_REQUEST['cid'];
$identification = $_REQUEST['tid'];
$myticket = $_REQUEST['ticket'];
$inTrack = $_REQUEST['incoming'];
$outTrack = $_REQUEST['outgoing'];
$firstNote = $_REQUEST['note1'];
$secondNote = $_REQUEST['note2'];
$myproducts = $_REQUEST['myproduct'];
$mywarranty = $_REQUEST['mywarranty'];
$mydestination = $_REQUEST['mydestination'];
$quantity = $_REQUEST['myquantity'];
$mypackage = $_REQUEST['mypackage'];



//for removing a checked in item.

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	mysqli_query($connection, "UPDATE logged_info SET ticket_number = $myticket WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET incoming_barcode = $inTrack WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET outgoing_barcode = $outTrack WHERE tid = $identification");
		
		if ($myproducts != 25) {
			mysqli_query($connection, "UPDATE logged_info SET selected_product = $myproducts WHERE tid = $identification");
		}
		
		if ($mydestination != 4) {
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

	mysqli_query($connection, "UPDATE logged_info SET note = '$firstNote' WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET note2 = '$secondNote' WHERE tid = $identification");

}else mysqli_error($connection);


echo "<META http-equiv='refresh' content='.1;http://localhost/customers.php?cid=" . $routingquery . "'>";
?>