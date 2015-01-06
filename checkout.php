<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Check out</title>
<head>
<!--<link rel="stylesheet" type="text/css" href="styles/glance.css">-->
</head>
<?php include('header.php');?>



<?php



$ticket = mysqli_real_escape_string($connection, $_POST['ticket']);
$name = mysqli_real_escape_string($connection, $_POST['name']);
$currDate = Date("Y-m-d");
$inTrack = mysqli_real_escape_string($connection, $_POST['inTrack']);
$outTrack = mysqli_real_escape_string($connection, $_POST['outTrack']);
$minibase = mysqli_real_escape_string($connection, $_POST['minibase']);
$myquantity = mysqli_real_escape_string($connection, $_POST['myquantity']);
$myproducts = mysqli_real_escape_string($connection, $_POST['myproducts']);
$mydestination = mysqli_real_escape_string($connection, $_POST['mydestination']);
$myweight = mysqli_real_escape_string($connection, $_POST['myweight']);
$mywarranty = mysqli_real_escape_string($connection, $_POST['mywarranty']);
$myemail = mysqli_real_escape_string($connection, strtolower($_POST['myemail']));
$weight = mysqli_real_escape_string($connection, $_POST['weight']); 
$note = mysqli_real_escape_string($connection, $_POST['note']); 


if (strlen($outTrack) >= 18) {
	$outTrack = substr($outTrack, 11);
}

if (strlen($inTrack) >= 18) {
	$inTrack = substr($inTrack, 11);

}


// Don't submit information unless it is POSTed.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//Search the database for the email that was just typed in
$sql1 = mysqli_query($connection, "SELECT * FROM customers WHERE email = '$_POST[myemail]' ");

//Store the result as an array. This allows me to pull data from the returned value.
$sql1Result = mysqli_fetch_array($sql1);

//Assigning the CID from the customers table to a variable.
$existingCID = $sql1Result['cid'];

//If the result does exist in the database, take the cid from the customers table and insert the form data into the logged_info DB.
if ($sql1Result[0] > 1) {
	$justlogged = mysqli_query($connection, "INSERT INTO logged_info (cid,ticket_number, date_sent, incoming_barcode, outgoing_barcode, selected_product, location, weight, warranty, quantity, note) 
	VALUES ('$existingCID','$ticket','$currDate','$inTrack','$outTrack','$myproducts','$mydestination','$myweight','$mywarranty','$myquantity','$note');");
} else {
	
	//Insert customer data into customers table
	$customer_insert = "INSERT INTO customers (name,email) VALUES ('$name','$myemail');";

	//Verifying that the query went through
	if (mysqli_query($connection,$customer_insert)) {
  		echo ('The name record has been added <br />');

	}else echo '** ' . mysqli_error($connection);

	//Grab the ID from the last customer table insert
	$lastID = mysqli_insert_id($connection);

	//Insert the form data into the logged_info table with the 'cid' from the customer table insert
	$logged_insert = "INSERT INTO logged_info (cid,ticket_number, date_sent, incoming_barcode, outgoing_barcode, selected_product, location, weight, warranty, quantity, note) 
	VALUES ('$lastID','$ticket','$currDate','$inTrack','$outTrack','$myproducts','$mydestination','$myweight','$mywarranty','$myquantity','$note');";

	//Verifying that the query went through
	if (mysqli_query($connection,$logged_insert)) {
  		echo ('The logged into data has been added ');
	}else echo '** ' . mysqli_error($connection);

}




}


?>

<?php

echo "<div id=\"checkin\">";

echo "<form action=\"checkout.php\" method=\"POST\">";

?>

<input type="text" name="ticket" placeholder="Ticket #">
<input type="text" name="name" placeholder="First/Last Name">
<input type="text" name="myemail" placeholder="Email Address"><br />
<textarea id="styled" rows="2" cols="20" type="text" name="outTrack" placeholder="Outgoing tracking"></textarea>
<textarea id="styled" rows="2" cols="20" type="textarea" name="inTrack" placeholder="Incoming tracking"></textarea><br />
<textarea rows="4" cols="108" placeholder="Optional note" name="note"></textarea>

<?php

echo "Quantity: &nbsp; ";
$quantity = mysqli_query($connection, "SELECT id,quantity FROM amount");

echo "<select name=\"myquantity\">";

while($productamount = mysqli_fetch_array($quantity)){
	echo "<option value=\"". $productamount["id"] . "\">". $productamount["quantity"] . "</option>";

}
	echo "</select>";
	echo "|";
?>



<?php

$pl = mysqli_query($connection, "SELECT id,name FROM products");

//Begin dropdown list for all of the products in the database.

echo "Product: ";
echo "<select name=\"myproducts\">";

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

echo "<select name=\"mydestination\">";

while ($origin = mysqli_fetch_array($loc)) {
	echo "<option value=\"" . $origin["id"] . "\">" . $origin["location"] . "</option>";
}

echo "</select>";
echo "|";
//queries database for cost
$size = mysqli_query($connection, "SELECT id,package FROM p_size");
echo "&nbsp;Weight: ";

echo "<select name=\"myweight\">";

while ($weighted = mysqli_fetch_array($size)) {
	echo "<option value=\"" . $weighted["id"] . "\">" . $weighted["package"] . "</option>";

}
echo "</select>";

echo "&nbsp;OZ&nbsp;|";
?>

<?php

$warranty = mysqli_query($connection, "SELECT id,status FROM warranty");
echo "&nbsp;Warranty: ";

echo "<select name=\"mywarranty\">";

while ($warrantyStatus = mysqli_fetch_array($warranty)) {
	echo "<option value=\"" . $warrantyStatus["id"] . "\">" . $warrantyStatus["status"] . "</option>";

}
echo "</select>";

?>


<div id="button">
	<input type="submit">
</form>

</div>
</div>

<?php

//Adding the MYSQl query into the $result variable to grab the last 20 results entered into the Database

$result = mysqli_query($connection, "SELECT logged_info.tid, customers.cid, ticket_number, customers.name, date_sent, outgoing_barcode, incoming_barcode, selected_product FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid  ORDER BY logged_info.tid DESC LIMIT 20");

//Adding the MySql query to to join the products and logged_info table so I can display the product the customer received

$chosen_product = mysqli_query($connection, "SELECT products.id, products.name,products.color_code FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.tid DESC");

echo "<div id='lastItems'>Last 20 items checked out.</div>";
echo "<table id=\"viewtable\">" . "<tr><th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>" . "<th>Product Sent</th></tr> ";


//Display the info grabbed from the tables displayed in HTML
while($row = mysqli_fetch_array($result)) {
	echo "<tr class='rows'><td><a href=\"delete_entry.php?id=" . $row['tid'] . "\"><img src=\"images/buttons/close.png\">&nbsp;</a>" . $row['ticket_number'] . "</td>";
	echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td class='outgoing'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
	echo "<td class='incoming'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td>";
	echo "<td class='product_sent'>";

//Displays the type of product selected for the selected row
if ($row = mysqli_fetch_array($chosen_product)) {
	echo "<div class=\"product\">";
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
