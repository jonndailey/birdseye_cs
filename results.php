<DOCTYPE html>

<title>Check out</title>
<link rel="stylesheet" type="text/css" href="styles/glance.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<body>
<?php

$product = $_GET['id'];

$dataset = "*";

include('db.php');


//Grabbing the amount of products sent in the table. 
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product =" .  $product); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);


$result = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");

include('switch.php');
echo "<h2><div id='head_name'>You are looking at " . $product . "</div></h2>";

echo "<div id='human_syntax'>";
echo "You have sent a total of " . $number_of_items_displayed[0] . " " . $product . "" ;
echo "<br />";
echo "<h2>In the last week:<br /></h2>";
echo "</div>";

$chosen_location = mysqli_query($connection, "SELECT area.mypath,logged_info.location FROM area INNER JOIN logged_info ON area.id=logged_info.location ORDER BY logged_info.id DESC");


echo "<table>" . "<th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>";
echo "<div id=\"product_results\">";
//Display the info grabbed from the tables displayed in HTML
echo "<div class=\"container\">";

while($row = mysqli_fetch_array($result)) {
	
	echo "<tr><td>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td> ";


if ($row["note"]){
	echo "<tr><td>";
	echo "<div class=\"thenotes\">";
	echo "<strong>Note:&nbsp;</strong>" . $row['note'];
	echo "</td></tr>";

	echo "</div>";

}
echo "<td>";



echo "Sent 5";
echo "</td>";
echo "<td>";

echo "In Warranty";

echo "</td>";

echo "<td>";

echo "$0";

echo "</td>";

if ($row = mysqli_fetch_array($chosen_location)) {
	echo "<td class='flags'>";
	echo "<img src=\"images/flags/" . $row['mypath'] . "\">";

	echo "</td>";
}

}
echo "<hr>";
echo "</div>";


echo "</table>";

echo "</div>";

?>
<img src="">
</body>
</html>
