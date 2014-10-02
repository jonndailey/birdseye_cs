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

//$outTrack = str_replace("42006001029", "", $outTrack);
//$inTrack = str_replace("42006001029", "", $inTrack);
//Need to figure out a way to make scanner not submit after scanning


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
echo "<select name=\"dropdown\">";

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
	<input type="text" name="ticket" placeholder="Ticket #">
	<input type="text" name="name" placeholder="First/Last Name"><br />
	<?php

		//start of location dropdown
		$loc = mysqli_query($connection, "SELECT id,location FROM area");
		echo "<select name=\"dropdown2\">";
		while ($origin = mysqli_fetch_array($loc)) {
			echo "<option value\"" . $origin["id"] . "\">" . $origin["location"] . "</option>";
		}
		echo "</select>";


		//Start of finance dropdown query
		$funds = mysqli_query($connection, "SELECT id,cost FROM finance");
		echo "<select name=\"dropdown3\">";
		while ($price = mysqli_fetch_array($funds)) {
			echo "<option value\"" . $price["id"] . "\">" . $price["cost"] . "</option>";
		}
		echo "</select>"
	?>
	<input type="text" name="outTrack" placeholder="Outgoing tracking">
	<input type="text" name="inTrack" placeholder="Incoming tracking">

	<input type="submit">
</div>
</form>

</div>

<?php


//Adding the MYSQl query into the $result variable

$result = mysqli_query($connection, "SELECT * FROM minis ORDER BY id ASC LIMIT 20");
$chosen_product = mysqli_query($connection, "SELECT products.name FROM products INNER JOIN minis ON minis.selected_product=products.id");

echo "<table>" . "<th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>";
echo "<h2>Last 20 items checked out.</h2>";


while($row = mysqli_fetch_array($result)) {
	echo "<div id=\"glance-results\"><tr><td><a href=\"delete_entry.php?id=" . $row['id'] . "\">[X]&nbsp;</a>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td class='outgoing'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
	echo "<td class='incoming'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td>";
	echo "<td>";

	if ($row = mysqli_fetch_array($chosen_product)) {

		echo "<--- " . $row['name']; 

	}

	echo "</td>";
	echo "</div>";


};





?>
</body>
</html>