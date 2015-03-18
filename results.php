<?php include('header.php');?>
<body class="resultspage">
<?php include('nav.php');?>
	
<?php

$product = $_GET['id'];

/*
***************

Information banner

***************
*/

//Grabbing and counting the amount of products sent in the table that match this product 
$number_of_items = mysqli_query($connection, "SELECT SUM(quantity) FROM logged_info WHERE selected_product = $product ORDER BY logged_info.tid DESC"); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);


//How many items sent that were in warranty
$how_many_in_warranty = mysqli_query($connection, "SELECT SUM(warranty) FROM logged_info WHERE warranty = 1 AND selected_product =  $product ORDER BY logged_info.tid DESC");
$how_many_in_warranty_displayed = mysqli_fetch_array($how_many_in_warranty) ;


//How many items sent that were out of warranty
$how_many_out_warranty = mysqli_query($connection, "SELECT SUM(warranty) FROM logged_info WHERE warranty = 2 AND selected_product=  $product ORDER BY logged_info.tid DESC");
$how_many_out_warranty_displayed = mysqli_fetch_array($how_many_out_warranty);

//Accurately show in and out of warranty numbers in the nav stattion
$inwarranty = $how_many_in_warranty_displayed[0];
$outofwarranty = $how_many_out_warranty_displayed[0];

echo $outofwarranty;

//How many items are sent domestically
$how_many_domestic = mysqli_query($connection, "SELECT SUM(*) FROM logged_info WHERE location = 1 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_domestic_displayed = mysqli_fetch_array($how_many_domestic);

//How many items are sent to Europe
$how_many_europe = mysqli_query($connection, "SELECT SUM(*) FROM logged_info WHERE location = 2 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_europe_displayed = mysqli_fetch_array($how_many_europe);

//How many items are sent to Canada
$how_many_canada = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 3 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_canada_displayed = mysqli_fetch_array($how_many_canada);

//How many went to Australia
$how_many_australia = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 4 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_australia_displayed = mysqli_fetch_array($how_many_australia);


//How many went to New Zealand
$how_many_new_zealand = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 5 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_new_zealand_displayed = mysqli_fetch_array($how_many_new_zealand);

//How many went to Australia
$how_many_south_africa = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE location = 6 AND selected_product= $product ORDER BY logged_info.tid DESC");
$how_many_south_africa_displayed = mysqli_fetch_array($how_many_south_africa);


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
$chosen_location = mysqli_query($connection, "SELECT area.mypath,logged_info.location,logged_info.tid,area.secondary_name FROM logged_info INNER JOIN area ON logged_info.location=area.id WHERE selected_product = $product ORDER BY logged_info.tid DESC");

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity WHERE selected_product = $product ORDER BY logged_info.tid DESC");

//Package weight
$chosen_size = mysqli_query($connection, "SELECT p_size.package,logged_info.weight FROM p_size INNER JOIN logged_info ON p_size.id=logged_info.weight WHERE selected_product = $product ORDER BY logged_info.tid DESC");


include('switch.php');

?>
<br /><br />
<div id="navcontainer">
	<table class="navstation">	
		<tr>
			<td class="titleName"><?php echo $product ?></td>
			<td class="title"><span class="number"><?php echo $number_of_items_displayed[0] ?></span><br/>Sent</td>
			<td class="title"><span class="number"><?php echo $how_many_domestic_displayed[0] ?></span><br/>United States</td>
			<td class="title"><span class="number"><?php echo $how_many_europe_displayed[0] ?></span><br/>Europe</td>
			<td class="title"><span class="number"><?php echo $how_many_canada_displayed[0] ?></span><br/>Canada</td>
			<td class="title"><span class="number"><?php echo $how_many_australia_displayed[0] ?></span><br/>Australia</td>
			<td class="title"><span class="number"><?php echo $how_many_new_zealand_displayed[0] ?></span><br/>New Zealand</td>
			<td class="title"><span class="number"><?php echo $how_many_south_africa_displayed[0] ?></span><br/>South Africa</td>
			<td class="title"><span class="number"><?php echo $inwarranty ?></span><br/>In warranty</td>
			<td class="title"><span class="number"><?php echo $outofwarranty ?></span><br/>Out warranty</td>
		</tr>
	</table>
</div>

<?php

echo "<br>";

echo "<table id=\"resultsData\">" . "<tr><th>Ticket Number</th>" . "<th>Name</th>" . "<th>Date sent</th>" . "<th>Date Received</th>" . "<th>Outgoing Tracking</th>" . "<th>Incoming Tracking</th>" . "</tr>";
//Display the info grabbed from the tables displayed in HTML

while($row = mysqli_fetch_array($result)) {
	echo "<table>";
	echo "<tr>";
	echo "<td id=" . $row['tid'] . "  name=\"jticket\" >&raquo; <a href='https://idevices.zendesk.com/agent/tickets/" . $row['ticket_number'] . "' target=\"_blank\" >" . $row['ticket_number'] ."</a> </td>";
	echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td>" . $row['date_returned'] ;
	

if ($row['date_returned'] == '') {
	echo "<a href=\"checkin.php\">Not checked in</a></td>";
};

	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "' target=\"_blank\">" . $row['outgoing_barcode'] ."</a></td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "' target=\"_blank\">" . $row['incoming_barcode'] ."</a></td>";

echo "<tr  class='resultdata'>";
if ($row = mysqli_fetch_array($chosen_location)) {
	echo "<td class='outerinfo'>";
	echo "<img alt=\"flag\" src=\"images/flags/" . $row['mypath'] . "\">";

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
	echo "</tr>";

if ($row = mysqli_fetch_array($notes2)){
	echo "<br /><td class='mynote'>";
	echo $row['note2'];
	echo "</td></table>";
	}else echo "";
	echo "</tr><br /><br />";
}

echo "</tr>";
?>
</body>
</html>
