<title>Check out</title>
<link rel="stylesheet" type="text/css" href="styles/glance.css">



<?php

$product = $_REQUEST['id'];

$dataset = "You are connected to the results page.";

include('db.php');

echo "<h2>You are looking at " . $product;


//Adding the MYSQl query into the $result variable to grab the last 20 results entered into the Database


$result = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product =" . $product );
//In the result variable I need to grab the selected_product number so it displays on the page
$chosen_product = mysqli_query($connection, "SELECT products.name, products.color_code FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.id DESC");


echo "<table>" . "<th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>" . "<th>Product Sent</th>";
echo "<h2>Last 20 items checked out.</h2>";

//Display the info grabbed from the tables displayed in HTML
while($row = mysqli_fetch_array($result)) {
	echo "<div id=\"glance-results\"><tr><td><a href=\"delete_entry.php?id=" . $row['id'] . "\">[X]&nbsp;</a>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td class='outgoing'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
	echo "<td class='incoming'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td>";
	echo "<td>";
				

//Displays the type of product selected for the selected row
if ($row = mysqli_fetch_array($chosen_product)) {
	echo "<div id='" . $row['color_code'] . "'><a href=\"results.php?id=" . $row['name']  ."\">". $row['name']   . "</div> ";
	echo "</div>";
}				


echo "</td>";
echo "</div>";

}


?>
