<link rel="stylesheet" type="text/css" href="styles/transaction.css">
	<?php include('header.php');?>

<?php

include('db.php');

$identification = $_REQUEST['tid'];
$ticket = mysqli_real_escape_string($connection, $_POST['ticket']);
$inTrack = mysqli_real_escape_string($connection, $_POST['inTrack']);
$outTrack = mysqli_real_escape_string($connection, $_POST['outTrack']);
$note = mysqli_real_escape_string($connection, $_POST['note']); 
$note2 = mysqli_real_escape_string($connection, $_POST['note2']); 
$myproduct = mysqli_real_escape_string($connection, $_POST['myproduct']); 
$mydestination = mysqli_real_escape_string($connection, $_POST['mydestination']); 
$mywarranty = mysqli_real_escape_string($connection, $_POST['mywarranty']); 
$mytid = mysqli_real_escape_string($connection, $_POST['tid']); 

if (strlen($outTrack) >= 18) {
	$outTrack = substr($outTrack, 11);
}

if (strlen($inTrack) >= 18) {
	$inTrack = substr($inTrack, 11);

}

//Select the items from the DB that match the transaction
$edit = mysqli_query($connection, "SELECT * FROM logged_info WHERE tid = $identification ORDER BY tid DESC");

//Choose the product you meant to choose. First choose the product that I selected, with the ability to change to a new product. 
$chosen_product = mysqli_query($connection, "SELECT name,id,color_code from products ORDER BY color_code ASC");


//Choose the product you meant to choose. First choose the product that I selected, with the ability to change to a new product. 
$remind_product = mysqli_query($connection, "SELECT id,name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id WHERE tid = $identification;");
$remind_warranty = mysqli_query($connection, "SELECT id,status FROM warranty INNER JOIN logged_info ON logged_info.warranty=warranty.id WHERE tid = $identification;");
$remind_quantity = mysqli_query($connection, "SELECT amount.id,amount.quantity FROM amount INNER JOIN logged_info ON logged_info.quantity=amount.quantity WHERE tid = $identification;");
$remind_destination = mysqli_query($connection, "SELECT area.id,area.location,area.secondary_name FROM area INNER JOIN logged_info ON area.id=logged_info.location WHERE tid = $identification ORDER BY tid DESC;");
$remind_package = mysqli_query($connection, "SELECT p_size.id,p_size.package FROM p_size INNER JOIN logged_info ON logged_info.weight=p_size.id WHERE tid = $identification;");
//waranty
$warranty = mysqli_query($connection, "SELECT id,status FROM warranty ORDER BY id DESC");

//SELECT name,id from products UNION SELECT products.id,products.name FROM products INNER JOIN logged_info ON products.id=logged_info.selected_product WHERE tid = $identification ORDER BY id DESC

//first note
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE tid =  $identification ");

//second note
$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE tid = $identification ");

//location
$loc = mysqli_query($connection, "SELECT id,location,sort_secret FROM area ORDER BY sort_secret DESC");

//quantity
$quantity = mysqli_query($connection, "SELECT id,quantity FROM amount ORDER BY id DESC");

//package size
$package = mysqli_query($connection, "SELECT p_size.id,p_size.package FROM p_size ORDER BY id DESC");

?>
<div class="groupedData">
<?php 
//Grab the customers location
$chosen_location = mysqli_query($connection, "SELECT area.id,area.location,area.secondary_name FROM area INNER JOIN logged_info ON area.id=logged_info.location WHERE tid = $identification");

while ($row = mysqli_fetch_array($edit)) { ?>


<?php 

$checkdate = mysqli_query($connection, "SELECT date_returned FROM logged_info WHERE tid = $identification");
$checkdatearray = mysqli_fetch_array($checkdate);

if ($checkdatearray[0] > 1) {
	echo "<a href='http://localhost/date_returned.php?tid=" . $identification . "'>Click me if I was mistakenly checked in.</a><br />";
}else echo "This has not been checked in.<br /><br />";




?>

<form action="editinsert.php?">
	Ticket number:<br /><input type="text" name="ticket" placeholder="Ticket Number" value="<?php echo $row['ticket_number'];?>"></input><br /><br />
	Outgoing Tracking: <br /><input type="text" name="incoming" placeholder="Incoming Barcode" value="<?php echo $row['incoming_barcode'];?>"></input><br /><br />
	Incoming Tracking:<br /><input type="text" name="outgoing" placeholder="Outgoing Barcode" value="<?php echo $row['outgoing_barcode'];?>"></input><br /><br />

<?php

echo "Notes:<br />";
while ($customernote1 = mysqli_fetch_array($notes)) { ?>

<input type="text" name="note1" value="<?php echo $customernote1['note']; ?>"></input>

<?php }; ?>
<br /><br />
<?php

while ($customernote2 = mysqli_fetch_array($notes2)) { ?>

<input type="text" name="note2" value="<?php echo $customernote2['note2']; ?>"></input>
<?php }; ?>
<br /><br />
<?php
//echo "<h3>Change more info below:</h3>";
//echo "Just so you remember, you sent this ";


//echo "<br /> customer: ";

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity WHERE tid = $identification ORDER BY logged_info.tid DESC");

//The name of the product
//The amount sent
/*while ($row = mysqli_fetch_array($chosen_quantity)) {
	echo "<div style='display:inline-block;color:steelblue'><li>" . $row['quantity'] . "</li></div>";
}*/
echo "Change ";

while ($row = mysqli_fetch_array($remind_product)) {
	echo "<div style='display:inline-block;color:steelblue;'>" . $row['name'] . "</div>";
}

?>

<?php 
echo "to ";
echo "<select name=\"myproduct\">";

while ($producted = mysqli_fetch_array($chosen_product)) {

	echo "<option value=\"" . $producted["id"] . "\">" . $producted["name"] . "</option>";
}
echo "</select>";
?>

<?php

echo "<br />Change ";

while ($row = mysqli_fetch_array($remind_warranty)) {
	echo "<div style='display:inline-block;color:steelblue;'> " . $row['status'] . " </div>";

}
echo " to ";
echo "<select name=\"mywarranty\">";

while ($warrantyStatus = mysqli_fetch_array($warranty)) {
	echo "<option value=\"" . $warrantyStatus["id"] . "\">" . $warrantyStatus["status"] . "</option>";

}
echo "</select><br />";


//drop down written in HTML
echo "Change  ";

while ($row = mysqli_fetch_array($remind_destination)) {
	echo "<div style='display:inline-block;color:steelblue;'> " . $row['location'] . "</div>";
}

echo " to ";
echo "<select name=\"mydestination\">";


while ($origin = mysqli_fetch_array($loc)) {
	echo "<option value=\"" . $origin["id"] . "\">" . $origin["location"] . "</option>";
}

echo "</select><br />";

echo "Change from ";

while ($productamount = mysqli_fetch_array($remind_quantity)) {
	echo "<div style='display:inline-block;color:steelblue;'>" . $productamount['quantity'] . "</div>";
}

echo " items to ";
echo "<select name=\"myquantity\">";
while($productamount = mysqli_fetch_array($quantity)){

	echo "<option value=\"". $productamount["id"] . "\">". $productamount["quantity"] . "</option> ";

}
	echo "</select><br />";


echo "Change from ";

while ($package_size = mysqli_fetch_array($remind_package)) {
	echo "<div style='display:inline-block;color:steelblue;'>" . $package_size['package'] . "</div>";
}

echo "oz to ";
echo "<select name=\"mypackage\">";
while($row = mysqli_fetch_array($package)){

	echo "<option value=\"". $row["id"] . "\">". $row["package"] . "</option> ";

}
	echo "</select>";


echo "<input name=\"tid\" type=\"hidden\" value=". $identification . "></input>";
?>
<br /><br />

<input type="submit" value="Submit Changes">

</form>
</div>
<?php }; ?>