<DOCTYPE html>

<title>Check out</title>
<link rel="stylesheet" type="text/css" href="styles/results.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<?php include('header.php'); ?>
<body>
	
<?php


$product = $_GET['id'];

if ($product == 14) {
	echo "<META http-equiv='refresh' content='.01;http://localhost/qa.php'>";
}else "Nope";




include('db.php');

//echo "<a href=\"checkout.php\">Checkout Page</a><br />";
//echo "<a href=\"checkin.php\">Checkin Page</a><br />";


/*
***************

Information banner

***************
*/

//Grabbing the date from 7 days ago, always dynamic 
//$seven_days_ago = date('m-d-Y', strtotime("-7 day"));

//Grabbing and counting the amount of products sent in the table that match this product 
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product = $product ORDER BY logged_info.tid DESC"); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);


//How many items have been sent in the last 7 days
$last_7_days = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product = $product AND date_sent >= (DATE_SUB(CURDATE(), INTERVAL -7 DAY))  ORDER BY logged_info.tid DESC" ); 
$last_7_days_displayed = mysqli_fetch_array($last_7_days);

//How many items sent that were in warranty
$how_many_in_warranty = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE warranty = 1 AND selected_product=  $product ORDER BY logged_info.tid DESC");
$how_many_in_warranty_displayed = mysqli_fetch_array($how_many_in_warranty);

//How many items sent that were out of warranty
$how_many_out_warranty = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE warranty = 2 AND selected_product=  $product ORDER BY logged_info.tid DESC");
$how_many_out_warranty_displayed = mysqli_fetch_array($how_many_out_warranty);

//How many items are sent domestically
$how_many_domestic = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 1 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_domestic_displayed = mysqli_fetch_array($how_many_domestic);

//How many items are sent to Europe
$how_many_europe = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 2 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_europe_displayed = mysqli_fetch_array($how_many_europe);

//How many items are sent to Canada
$how_many_canada = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 3 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_canada_displayed = mysqli_fetch_array($how_many_canada);

/*
***************

End of information banner 

***************
*/


//Grabbing every item in the database that has the correct ID
$result = mysqli_query($connection, "SELECT customers.cid,ticket_number,customers.name,date_sent,date_returned,outgoing_barcode,incoming_barcode FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid WHERE selected_product = $product ORDER BY logged_info.tid DESC");

//Pull the first note from the DB
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product =  $product ORDER BY logged_info.tid DESC");

//Pull the second note from the DB
$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY logged_info.tid DESC");

//Warranty status
$chosen_warranty = mysqli_query($connection, "SELECT logged_info.warranty,warranty.status,logged_info.selected_product FROM logged_info INNER JOIN warranty ON logged_info.warranty=warranty.id WHERE logged_info.selected_product = $product ORDER BY logged_info.tid DESC");

//For the display of the flag
$chosen_location = mysqli_query($connection, "SELECT area.mypath,logged_info.location FROM area INNER JOIN logged_info ON area.id=logged_info.location WHERE selected_product = $product ORDER BY logged_info.tid DESC");

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity WHERE selected_product = $product ORDER BY logged_info.tid DESC");

//Package weight
$chosen_size = mysqli_query($connection, "SELECT p_size.package,logged_info.weight FROM p_size INNER JOIN logged_info ON p_size.id=logged_info.weight WHERE selected_product = $product ORDER BY logged_info.tid DESC");


include('switch.php');

?>
<br /><br />
<div id="navcontainer">
		<table align="center" class="navstation">	
			<tr>
				<td align="center" class="titleName"><?php echo $product ?></td>
				<td align="center" class="title"><span class="number"><?php echo $number_of_items_displayed[0] ?></span><br/>Sent</td>
				<!--<td align="center" class="title"><span class="number"><?php/* echo $last_7_days_displayed[0]*/ ?></span><br/>In the past seven days</td>-->
				<td align="center" class="title"><span class="number"><?php echo $how_many_in_warranty_displayed[0] ?></span><br/>In warranty</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_out_warranty_displayed[0] ?></span><br/>Out of Warranty</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_domestic_displayed[0] ?></span><br/>United States</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_europe_displayed[0] ?></span><br/>Europe</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_canada_displayed[0] ?></span><br/>Canada</td>
			</tr>
		</table>
	</div>


<?php


echo "<br>";

echo "<table>" . "<tr><th>Ticket Number</th>" . "<th>Name</th>" . "<th>Date sent</th>" . "<th>Date Received</th>" . "<th>Outgoing Tracking</th>" . "<th>Incoming Tracking</th>" . "</tr>";
//Display the info grabbed from the tables displayed in HTML

while($row = mysqli_fetch_array($result)) {
	echo "<table class='resultdata'>";
	echo "<tr class='rows'>";
	echo "<td>" . $row['ticket_number'] . "</td>";
	echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td>" . $row['date_returned'] ;
	

	if ($row['date_returned'] == '') {
		echo "<a href=\"checkin.php\">Not checked in</a></td>";
	};

	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ."</a></td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ."</a></td>";

echo "<tr>";
if ($row = mysqli_fetch_array($chosen_location)) {
	echo "<td class='outerinfo'>";
	echo "<img src=\"images/flags/" . $row['mypath'] . "\">";

	}


if ($row = mysqli_fetch_array($chosen_quantity)) {
	echo "<div class='detailedinfo'>";
	echo "Qty: " . $row['quantity'] . " &#183; ";
	

	}


if ($row = mysqli_fetch_array($chosen_size)) {
	echo $row['package'] . " oz &#183; ";
	

	}	


if ($row = mysqli_fetch_array($chosen_warranty)) {
	echo $row['status'];
	echo "</div>";
	echo "</td></table>";

	}	


if ($row = mysqli_fetch_array($notes)){
	echo "<table><td class='mynote'>";
	echo $row['note'];
	echo "</td>";
	}else echo "No note checked in:";
	echo "</tr><br />";

if ($row = mysqli_fetch_array($notes2)){
	echo "<td class='mynote'>";
	echo $row['note2'];
	echo "</td></table>";
	}else echo "";
	echo "</tr><br /><br />";

}
echo "</tr>";
echo "</table>";


?>

</body>
</html>
