<DOCTYPE html>

<title>Check out</title>
<link rel="stylesheet" type="text/css" href="styles/results.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<body>
<?php


$product = 14;

$dataset = "*";

include('db.php');



//Grabbing the amount of products sent in the table. 
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product =" .  $product); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);


//How many items have been sent in the last 7 days
$last_7_days = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product =" .  $product . ""); 
$last_7_days_displayed = mysqli_fetch_array($last_7_days);




$result = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");

//Same query as result to display notes
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");



include('switch.php');

echo "<h2><div id='head_name'>You are looking at " . $product . "</div></h2>";
echo "<div id='human_syntax'>";
echo "You have sent a total of " . $number_of_items_displayed[0] . " " . $product . "'s through the QA program." ;
echo "<br />";
echo "<h2>In the last week:<br /></h2>";
echo "</div>";

//For the display of the flag
$chosen_location = mysqli_query($connection, "SELECT area.mypath,logged_info.location FROM area INNER JOIN logged_info ON area.id=logged_info.location ORDER BY logged_info.id DESC");

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT logged_info.customer_name,amount.id,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity ORDER BY logged_info.id DESC");

//Warranty status
$chosen_warranty = mysqli_query($connection, "SELECT logged_info.customer_name,warranty.id,logged_info.warranty FROM warranty INNER JOIN logged_info ON warranty.status=logged_info.warranty ORDER BY logged_info.id DESC");



echo "<table>" . "<tr><th>Ticket Number</th>" . "<th>Name</th>" . "<th>Date sent</th>" . "<th>Outgoing Tracking</th>" . "<th>Incoming Tracking</th>";
//Display the info grabbed from the tables displayed in HTML

while($row = mysqli_fetch_array($result)) {
	echo "<table class='resultdata'>";
	echo "<tr class='rows'>";
	echo "<td>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ."</a></td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ."</a></td>";
}

echo "</table>";


?>

</body>
</html>
