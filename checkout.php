<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Check out</title>
	<link rel="stylesheet" type="text/css" href="styles/glance.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

<?php

$dataset = "*";

include('db.php');

$ticket = mysqli_real_escape_string($connection, $_POST['ticket']);
$name = mysqli_real_escape_string($connection, $_POST['name']);
$currDate = Date("m-d-Y");
$inTrack = mysqli_real_escape_string($connection, $_POST['inTrack']);
$outTrack = mysqli_real_escape_string($connection, $_POST['outTrack']);
$minibase = mysqli_real_escape_string($connection, $_POST['minibase']);
$dropdown0 = mysqli_real_escape_string($connection, $_POST['dropdown0']);
$dropdown1 = mysqli_real_escape_string($connection, $_POST['dropdown1']);
$dropdown2 = mysqli_real_escape_string($connection, $_POST['dropdown2']);
$dropdown3 = mysqli_real_escape_string($connection, $_POST['dropdown3']);
$dropdown4 = mysqli_real_escape_string($connection, $_POST['dropdown4']);
$selected = mysqli_real_escape_string($connection, $_POST['selected_product']);
$note = mysqli_real_escape_string($connection, $_POST['note']); 
$destination = mysqli_real_escape_string($connection, $_POST['destination']); //create column in DB
$weight = mysqli_real_escape_string($connection, $_POST['weight']); //create column in DB

//$outTrack = str_replace("42006001029", "", $outTrack);
//$inTrack = str_replace("42006001029", "", $inTrack);
//Need to figure out a way to make scanner not submit after scanning

// Don't submit information unless it is POSTed.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$sql = "INSERT INTO logged_info (ticket_number, customer_name, date_sent, incoming_barcode, outgoing_barcode, selected_product, note) 
VALUES ('$ticket','$name', '$currDate', '$inTrack','$outTrack', '$dropdown1' '$selected', '$note')";

} else "Error " . mysqli_error($connection);
   


if (mysqli_query($connection,$sql)) {
  	echo ('1 Record has been added');
}else echo '** ' . mysqli_error($connection);

?>


<?php

echo "<div id=\"checkin\">";

echo "<form action=\"checkout.php\" method=\"POST\">";

?>

<input type="text" name="ticket" placeholder="Ticket #">
<input type="text" name="name" placeholder="First/Last Name">
<input type="text" name="outTrack" placeholder="Outgoing tracking">
<input type="text" name="inTrack" placeholder="Incoming tracking"><br />
<textarea rows="4" cols="84" placeholder="Optional note" name="note"></textarea>

<br />



<?php

echo "Quantity: &nbsp; ";
$quantity = mysqli_query($connection, "SELECT id,quantity FROM amount");

echo "<select name=\"dropdown0\">";

while($productamount = mysqli_fetch_array($quantity)){
	echo "<option value=\"".$productamount["id"] . "\">". $productamount["quantity"] . "</option>";

}
	echo "</select>";
	echo "|";
?>



<?php

$pl = mysqli_query($connection, "SELECT id,name FROM products");

//Begin dropdown list for all of the products in the database.

echo "Product: ";
echo "<select name=\"dropdown1\">";

//Go through query and create dropdown option for each item
	
while($list = mysqli_fetch_array($pl)){
	//Write the line of HTML for each item
	echo "<option value=\"". $list["id"] ."\">". $list["name"] . "</option>";
}

//End the dropdown for the products
echo "</select>";

echo "|";

?>	



<?php

//start of location dropdown

//queries database for international or domestic location

$loc = mysqli_query($connection, "SELECT id,location FROM area");

echo "Destination: ";

//drop down written in HTML

echo "<select name=\"dropdown2\">";

while ($origin = mysqli_fetch_array($loc)) {
	echo "<option value=\"" . $origin["id"] . "\">" . $origin["location"] . "</option>";
}

echo "</select>";
echo "|";
//queries database for cost
$size = mysqli_query($connection, "SELECT id,package FROM p_size");
echo "&nbsp;Weight: ";

echo "<select name=\"dropdown3\">";

while ($weighted = mysqli_fetch_array($size)) {
	echo "<option value=\"" . $weighted["id"] . "\">" . $weighted["package"] . "</option>";

}
echo "</select>";

echo "&nbsp;OZ&nbsp;|";
?>

<select>
	<option value='#'>Free</option>
	<option>Pay</option>
</select>

<div id="button">
	<input type="submit">
</form>

</div>
</div>

<?php

//Adding the MYSQl query into the $result variable to grab the last 20 results entered into the Database

$result = mysqli_query($connection, "SELECT * FROM logged_info ORDER BY id DESC LIMIT 20");

//Adding the MySql query to to join the products and logged_info table so I can display the product the customer received

$chosen_product = mysqli_query($connection, "SELECT products.id, products.name, products.color_code FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.id DESC");
echo "<div id=\"glance-results\">";

echo "<div id='lastItems'>Last 20 items checked out.</div>";
echo "<table>" . "<tr><th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>" . "<th>Product Sent</th></tr> ";


//Display the info grabbed from the tables displayed in HTML
while($row = mysqli_fetch_array($result)) {
	echo "<tr class='rows'><td><a href=\"delete_entry.php?id=" . $row['id'] . "\">[X]&nbsp;</a>" . $row['ticket_number'] . "</td>";
	echo "<td>" . $row['customer_name'] . "</td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td class='outgoing'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
	echo "<td class='incoming'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td>";
	echo "<td>";

//Displays the type of product selected for the selected row
if ($row = mysqli_fetch_array($chosen_product)) {
	echo "<div class='" . $row['color_code'] . "'>";
	echo "<a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a>"; 
	echo "</div> ";
		};

echo "</td>";
echo "</tr>";
	};

echo "</table>";
echo "</div>";
?>

</body>
</html>
