<?php
$dataset = "<img src=\"images/logo/coffee.png\">";

include('db.php');
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





echo $ticket;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	mysqli_query($connection, "UPDATE logged_info SET ticket_number = $myticket WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET incoming_barcode = $inTrack WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET outgoing_barcode = $outTrack WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET selected_product = $myproducts WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET location = $mydestination WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET quantity = $quantity WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET note = '$firstNote' WHERE tid = $identification");
	mysqli_query($connection, "UPDATE logged_info SET note2 = '$secondNote' WHERE tid = $identification");
	//mysqli_query($connection, "INSERT INTO logged_info (ticket_number,outgoing_barcode,incoming_barcode,selected_product,note,note2,location) VALUES('$myticket','$outTrack', '$inTrack','$myproduct','$firstNote','$secondNote','$mydestination') WHERE tid = $identification");
	echo "<br />*******"  . "<br />**********";
	echo $firstNote . "<br>";
	echo $secondNote . "<br>";
	echo $myticket . "<br />";
	echo "It worked";
	echo "<br /><br />";
	echo "<a href=\"checkout.php\">Checkout Page</a><br />";
	echo "<a href=\"checkin.php\">Checkin Page</a><br />";

}else mysqli_error($connection);


?>