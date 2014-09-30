<html>
<head>

	<title>Check out</title>
<link rel="stylesheet" type="text/css" href="styles/glance.css">

</head>
<body>

<?php

$dataset = "You are connected to the check-in system.";

include('db.php');



$ticket = mysqli_real_escape_string($connection, $_POST['ticket']);
$name = mysqli_real_escape_string($connection, $_POST['name']);
$currDate = Date("m-d-Y");
$inTrack = mysqli_real_escape_string($connection, $_POST['inTrack']);
$outTrack = mysqli_real_escape_string($connection, $_POST['outTrack']);
$minibase = mysqli_real_escape_string($connection, $_POST['minibase']);
$dropdown = mysqli_real_escape_string($connection, $_POST['dropdown']);
$selected = mysqli_real_escape_string($connection, $_POST['selected_product']);

$outTrack = str_replace("42006001029", "", $outTrack);
$inTrack = str_replace("42006001029", "", $inTrack);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$sql = "INSERT INTO minis (ticket_number, customer_name, date_sent, incoming_barcode, outgoing_barcode, selected_product) 
VALUES ('$ticket','$name', '$currDate', '$inTrack','$outTrack', '$dropdown' '$selected')";

} else "Error " . mysqli_error($connection);
   

if (mysqli_query($connection,$sql)) {
  	echo ('1 Record has been added');
}else echo 'Please submit your query: ' . mysqli_error($connection);

?>


<?php

echo "<div id=\"checkin\"><form action=\"checkout.php\" method=\"POST\">";
//Queries Database for product names and ids
$pl = mysqli_query($connection, "SELECT id,name FROM products");

//Begin dropdown list
echo "<br><select name=\"dropdown\">";

//Go through query and create dropdown option for each item
//'name' is the description and 'id' is the value
while($list = mysqli_fetch_array($pl))
	{
		//Write the actual line of HTML for each item
  		echo "<option value=\"". $list["id"] ."\">". $list["name"] . "</option>";
	}

//End the dropdown
echo "</select>";


?>
	<input type="text" name="ticket" placeholder="Ticket #"><!--test-->
	<input type="text" name="name" placeholder="First/Last Name">
	<input type="text" name="outTrack" placeholder="Outgoing tracking">
	<input type="text" name="inTrack" placeholder="Incoming tracking">
	<input type="submit">
</form>

</div>

<?php


//Adding the MYSQl query into the $result variable

$result = mysqli_query($connection, "SELECT * FROM minis ORDER BY id DESC LIMIT 20");

echo "<table>" . "<th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>";
echo "<h2>Last 20 items checked out.</h2>";


while($row = mysqli_fetch_array($result)) {
	echo "<div id=\"glance-results\"><tr><td><a href=\"delete_entry.php?id=" . $row['id'] . "\">[X]&nbsp;</a>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td class='outgoing'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
	echo "<td class='incoming'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td>";
	echo "<td>";
	if ($row[selected_product]) {
		echo "<--- " . $row["selected_product"];
	}
	echo "</td>";
	echo "</div>";


};





?>
</body>
</html>