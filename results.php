<DOCTYPE html>

<title>Check out</title>
<link rel="stylesheet" type="text/css" href="styles/results.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<body>
	
<?php


$product = $_GET['id'];

if ($product == 14) {
	echo "<META http-equiv='refresh' content='.01;http://localhost/qa.php'>";
}else "Nope";


$dataset = "*";


include('db.php');

//echo "<a href=\"checkout.php\">Checkout Page</a><br />";
//echo "<a href=\"checkin.php\">Checkin Page</a><br />";


/*
***************

Start of human syntax . 

***************
*/

//Grabbing the date from 7 days ago, always dynamic 
$seven_days_ago = date('m-d-Y', strtotime("-7 day"));

//Grabbing and counting the amount of products sent in the table that match this product 
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product =" .  $product); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);


//How many items have been sent in the last 7 days
$last_7_days = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product = $product AND date_returned >= " . $seven_days_ago ); 
$last_7_days_displayed = mysqli_fetch_array($last_7_days);

//How many items sent that were in warranty
$how_many_in_warranty = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE warranty = 1 AND selected_product=". $product);
$how_many_in_warranty_displayed = mysqli_fetch_array($how_many_in_warranty);

//How many items sent that were out of warranty
$how_many_out_warranty = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE warranty = 2 AND selected_product=". $product);
$how_many_out_warranty_displayed = mysqli_fetch_array($how_many_out_warranty);

/*
***************

End of human syntax. 

***************
*/


//Grabbing every item in the database that has the correct ID
$result = mysqli_query($connection, "SELECT ticket_number,customers.name,date_sent,date_returned,outgoing_barcode,incoming_barcode FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid WHERE selected_product =  $product ORDER BY logged_info.tid DESC");



//Same query as result to display notes
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product =  $product ORDER BY tid DESC");

$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY tid DESC ");

include('switch.php');

?>

<div id="navcontainer">
		<table align="center" class="navstation">	
			<tr>
				<td align="center" class="titleName"><?php echo $product ?></td>
				<td align="center" class="title"><span class="number"><?php echo $number_of_items_displayed[0] ?></span><br/>Sent</td>
				<td align="center" class="title"><span class="number"><?php echo $last_7_days_displayed[0] ?></span><br/>In the past seven days</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_in_warranty_displayed[0] ?></span><br/>In warranty</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_out_warranty_displayed[0] ?></span><br/>Out of Warranty</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_out_warranty_displayed[0] ?></span><br/>Domestic</td>
				<td align="center" class="title"><span class="number"><?php echo $how_many_out_warranty_displayed[0] ?></span><br/>International</td>
			</tr>
		</table>
	</div>


<?php


//For the display of the flag
$chosen_location = mysqli_query($connection, "SELECT area.mypath,logged_info.location FROM area INNER JOIN logged_info ON area.id=logged_info.location ORDER BY logged_info.cid DESC");

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity ORDER BY logged_info.cid DESC");

//Warranty status
$chosen_warranty = mysqli_query($connection, "SELECT logged_info.warranty,warranty.status FROM logged_info INNER JOIN warranty ON warranty.id=logged_info.warranty ORDER BY logged_info.cid DESC");

//Package weight
$chosen_size = mysqli_query($connection, "SELECT p_size.package,logged_info.weight FROM p_size INNER JOIN logged_info ON p_size.id=logged_info.weight ORDER BY logged_info.cid DESC");
echo "<br>";

echo "<table>" . "<tr><th>Ticket Number</th>" . "<th>Name</th>" . "<th>Date sent</th>" . "<th>Date Received</th>" . "<th>Outgoing Tracking</th>" . "<th>Incoming Tracking</th>" . "</tr>";
//Display the info grabbed from the tables displayed in HTML

while($row = mysqli_fetch_array($result)) {
	echo "<table class='resultdata'>";
	echo "<tr class='rows'>";
	echo "<td>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td>" . $row['date_returned'] ;

	if ($row['date_returned'] == '') {
		echo "Not checked in </td>";
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
