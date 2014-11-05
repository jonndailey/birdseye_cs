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

echo "<br /><br />";
echo "<a href=\"checkout.php\">Checkout Page</a><br />";
echo "<a href=\"checkin.php\">Checkin Page</a><br />";



$currDate = Date("m-d-Y");
$seven_days_ago = Date($currDate-7);


//Grabbing the amount of products sent in the table. 
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product =" .  $product); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);


//How many items have been sent in the last 7 days
$last_7_days = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE selected_product =" .  $product . ""); 
$last_7_days_displayed = mysqli_fetch_array($last_7_days);


$result = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");

//Same query as result to display notes
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");

$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");


//Pulling the current product we're viewing from the database.
//$productSwitch = mysqli_query($connection, "SELECT logged_info.selected_product,products.name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.id DESC");
//$productSwitchResults = mysqli_fetch_array($productSwitch);

include('switch.php');

echo "<h2><div id='head_name'>" . $product . "</div></h2>";
echo "<div id='human_syntax'>";
echo "A total of " . $number_of_items_displayed[0] . " have been sent." ;
echo "<br />";
echo "<h2><br /></h2>";
echo "</div>";

//For the display of the flag
$chosen_location = mysqli_query($connection, "SELECT area.mypath,logged_info.location FROM area INNER JOIN logged_info ON area.id=logged_info.location ORDER BY logged_info.id DESC");

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT logged_info.customer_name,amount.id,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity ORDER BY logged_info.id DESC");

//Warranty status
$chosen_warranty = mysqli_query($connection, "SELECT logged_info.customer_name,warranty.status FROM logged_info INNER JOIN warranty ON warranty.id=logged_info.warranty ORDER BY logged_info.id DESC");

//Package weight
$chosen_size = mysqli_query($connection, "SELECT logged_info.customer_name,p_size.package,logged_info.weight FROM p_size INNER JOIN logged_info ON p_size.id=logged_info.weight ORDER BY logged_info.id DESC");


echo "<table>" . "<tr><th>Ticket Number</th>" . "<th>Name</th>" . "<th>Date sent</th>" . "<th>Date Received</th>" . "<th>Outgoing Tracking</th>" . "<th>Incoming Tracking</th>" . "</tr>";
//Display the info grabbed from the tables displayed in HTML

while($row = mysqli_fetch_array($result)) {
	echo "<table class='resultdata'>";
	echo "<tr class='rows'>";
	echo "<td>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
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
	echo "&nbsp; " . $row['note'];
	echo "</td>";
	}else echo "No note checked in:";
	echo "</tr><br />";

if ($row = mysqli_fetch_array($notes2)){
	echo "<td class='mynote'>";
	echo "&nbsp; " . $row['note2'];
	echo "</td></table>";
	}else echo "No note";
	echo "</tr><br /><br />";
}
echo "</tr>";
echo "</table>";


?>

</body>
</html>
