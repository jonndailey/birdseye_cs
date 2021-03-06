<?php include('header.php');?>
<body class="checkoutpage">
<?php include('nav.php');?>

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
if (strlen($outTrack) >= 24) {
	$outTrack = substr($outTrack, 11);
}
if (strlen($inTrack) >= 24) {
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
  		//note if the connection is successful
  		echo ('');
	}else echo '' . mysqli_error($connection);
	//Grab the ID from the last customer table insert
	$lastID = mysqli_insert_id($connection);
	//Insert the form data into the logged_info table with the 'cid' from the customer table insert
	$logged_insert = "INSERT INTO logged_info (cid,ticket_number, date_sent, incoming_barcode, outgoing_barcode, selected_product, location, weight, warranty, quantity, note)
	VALUES ('$lastID','$ticket','$currDate','$inTrack','$outTrack','$myproducts','$mydestination','$myweight','$mywarranty','$myquantity','$note');";
	//Verifying that the query went through
	if (mysqli_query($connection,$logged_insert)) {
  		echo ('');
	}else echo '' . mysqli_error($connection);
	}
}
?>

<?php
echo "<div id=\"checkin\">\n\n";
echo "<form action=\"checkout.php\" method=\"POST\" name=\"checkoutform\" onsubmit=\"return validateForm()\">";
?>

	<input type="text" name="ticket" placeholder="Ticket #">
	<input type="text" name="name" placeholder="First/Last Name">
	<input type="text" name="myemail" placeholder="Email Address"><br />
	<textarea class="styled" rows="2" cols="20"  name="outTrack" placeholder="Outgoing tracking"></textarea>
	<textarea class="styled" rows="2" cols="20" name="inTrack" placeholder="Incoming tracking"></textarea><br />
	<textarea rows="4" cols="108" placeholder="Optional note" name="note"></textarea>

<?php
echo "Quantity:";
$quantity = mysqli_query($connection, "SELECT id,quantity,sort_secret FROM amount ORDER BY sort_secret DESC, id ASC");
echo "\n<select name=\"myquantity\">\n";
while($row = mysqli_fetch_array($quantity)){
	echo "\t<option label=\"" . $row["label"] . "\" value=\"". $row["id"] . "\" >". $row["quantity"] . "</option>\n";
}
	echo "</select>|\n";
?>

<?php
$pl = mysqli_query($connection, "SELECT id,name,color_code FROM products ORDER BY color_code DESC, id DESC");
//Begin dropdown list for all of the products in the database.
echo "Product: ";
echo "\n<select name=\"myproducts\">";
//Go through query and create dropdown option for each item

while($list = mysqli_fetch_array($pl)){
	//Write the line of HTML for each item
	echo "\n\t<option label=\"" . $list["label"] . "\" value=\"". $list["id"] . "\">". $list["name"] . "</option>\n";
}
//End the dropdown for the products
echo "</select>";
echo "|";
?>



<?php
//start of location dropdown
//queries database for international or domestic location
$loc = mysqli_query($connection, "SELECT id,location FROM area");
echo "Destination: \n";
//drop down written in HTML
echo "<select name=\"mydestination\">";
while ($origin = mysqli_fetch_array($loc)) {
	echo "\t<option label=\"" . $origin["label"] . "\" value=\"" . $origin["id"] . "\">" . $origin["location"] . "</option>\n";
}
echo "</select>|";
//queries database for cost
$size = mysqli_query($connection, "SELECT id,package FROM p_size");
echo "\n\nWeight: \n";
echo "<select name=\"myweight\">";
while ($weighted = mysqli_fetch_array($size)) {
	echo "\t<option label=\"" . $weighted["label"] . "\" value=\"" . $weighted["id"] . "\">" . $weighted["package"] . "</option>\n";
}
echo "</select>&nbsp;OZ&nbsp;|\n";
?>

<?php
$warranty = mysqli_query($connection, "SELECT id,status FROM warranty");
echo "Warranty: ";
echo "\n<select name=\"mywarranty\">";
while ($warrantyStatus = mysqli_fetch_array($warranty)) {
	echo "\t<option label=\"" . $warrantyStatus["label"] . "\" value=\"" . $warrantyStatus["id"] . "\">" . $warrantyStatus["status"] . "</option>\n";
}
echo "</select>";
?>


<?php
/*
$issues = mysqli_query($connection, "SELECT id,issue FROM problems");
echo "&nbsp;Issues: ";
echo "<select name=\"myissues\">";
while ($myissue = mysqli_fetch_array($issues)) {
	echo "<option value=\"" . $myissue["id"] . "\">" . $myissue["issue"] . "</option>";
}
echo "</select>";
*/
?>
<div id="button"></div>
<input type="submit">
</form>
</div>

<?php
//Grab the last 20 checked out items
$result = mysqli_query($connection, "SELECT logged_info.tid, customers.cid, ticket_number, customers.name, date_sent, outgoing_barcode, incoming_barcode, selected_product,quantity FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid  ORDER BY logged_info.tid DESC LIMIT 20");
//Adding the MySql query to to join the products and logged_info table so I can display the product the customer received
$chosen_product = mysqli_query($connection, "SELECT products.id, products.name,products.color_code FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.tid DESC");
echo "<div id='lastItems'>Last 20 items checked out.</div>";
echo "\n<table id=\"viewtable\">\n" . "\n<tr><th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>" . "<th>Product Sent</th></tr> \n";
//Display the info grabbed from the tables displayed in HTML
while($row = mysqli_fetch_array($result)) {
	echo "\n\n\n<tr class='rows'>\n\t<td class=" . $row['tid'] . ">&raquo; <a href='https://idevices.zendesk.com/agent/tickets/" . $row['ticket_number'] . "' target=\"_blank\" >" . $row['ticket_number'] ."</a></td>\n";
	echo "\t<td class=" . $row['tid'] . "><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>";
	echo "\t<td class=" . $row['tid'] . " >" . $row['date_sent'] . "</td>";
	echo "\t<td class=" . $row['tid'] . " > <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "' target=\"_blank\">" . $row['outgoing_barcode'] ." </a></td>\n";
	echo "\t<td class=" . $row['tid'] . " > <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "' target=\"_blank\">" . $row['incoming_barcode'] ." </a></td>\n";
	echo "\t<td class='product_sent'>" . "<div class=\"homequant\">" . $row['quantity'] . "</div>";

//Displays the type of product selected for the selected row
if ($row = mysqli_fetch_array($chosen_product)) {
	echo "<div class=\"product\">";
	echo "<a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a>";
	echo "</div>";
		};
echo "\n\t</td>";
echo "\n</tr>";
	};
echo "\n</table>";
?>

</body>
</html>
