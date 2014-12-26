	<link rel="stylesheet" type="text/css" href="styles/transaction.css">


<?php
$dataset = "<img src=\"images/logo/coffee.png\">";

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
//$chosen_product = mysqli_query($connection, "SELECT products.id,products.name FROM products WHERE tid = $identification");
$chosen_product = mysqli_query($connection, "SELECT products.id,products.name,logged_info.selected_product FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id");


//Choose the product you meant to choose. First choose the product that I selected, with the ability to change to a new product. 
$remind_product = mysqli_query($connection, "SELECT id,name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id WHERE tid = $identification ORDER BY logged_info.tid DESC");



//waranty
$mywarranty = mysqli_query($connection, "SELECT warranty.id,warranty.status FROM warranty");

//first note
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE tid =  $identification ");

//second note
$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE tid = $identification ");

//location
$loc = mysqli_query($connection, "SELECT id,location FROM area ");

//quantity
$quantity = mysqli_query($connection, "SELECT id,quantity FROM amount");


?>
<div class="groupedData">
<?php 
//Grab the customers location
$chosen_location = mysqli_query($connection, "SELECT area.id,area.location,area.secondary_name FROM area INNER JOIN logged_info ON area.id=logged_info.location WHERE tid = $identification");




while ($row = mysqli_fetch_array($edit)) { ?>

<a href="">Click me if I was mistakenly checked in.</a>
<br /><br />
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
echo "<h3>You must re-select these items.</h3>";
echo "Just so you remember, you sent this ";


while ($row = mysqli_fetch_array($chosen_location)) {
	echo "<div style='display:inline-block;color:steelblue'>" . $row['secondary_name'] . "</div>";
};

echo "<br /> customer ";

//For the quantity of products
$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity WHERE tid = $identification ORDER BY logged_info.tid DESC");


//The name of the product
while ($row = mysqli_fetch_array($remind_product)) {
	echo "a(n) <div style='display:inline-block;color:steelblue'>" . $row['name'] . "</div>";
}

//The amount sent
while ($row = mysqli_fetch_array($chosen_quantity)) {
	echo " (" . $row['quantity'] . "), ";
}

//Pull warranty information
$warranty = mysqli_query($connection, "SELECT warranty.id,warranty.status FROM warranty INNER JOIN logged_info ON warranty.id=logged_info.warranty WHERE tid = $identification ORDER BY logged_info.tid DESC");

while ($row = mysqli_fetch_array($warranty)) {
	echo "<div style='display:inline-block;color:steelblue'>" . $row['status'] . ".</div><br /><br />";
}

?>

<?php 

echo "<select name=\"myproduct\">";

while ($product = mysqli_fetch_array($chosen_product)) {

	echo "<option value=\"" . $product["id"] . "\">" . $product["name"] . "</option>";

}
echo "</select>";

?>

<?php

echo "<select name=\"mywarranty\">";

while ($warrantyStatus = mysqli_fetch_array($mywarranty)) {
	echo "<option value=\"" . $warrantyStatus["id"] . "\">" . $warrantyStatus["status"] . "</option>";

}
echo "</select>";


//drop down written in HTML

echo "<select name=\"mydestination\">";

while ($origin = mysqli_fetch_array($loc)) {
	echo "<option value=\"" . $origin["id"] . "\">" . $origin["location"] . "</option>";
}

echo "</select>";

echo "| Qty: ";
echo "<select name=\"myquantity\">";
while($productamount = mysqli_fetch_array($quantity)){

	echo "<option value=\"". $productamount["id"] . "\">". $productamount["quantity"] . "</option>";

}
	echo "</select>";

echo "<input name=\"tid\" type=\"hidden\" value=". $identification . "></input>";
?>



<br /><br />

<input type="submit" value="Submit Changes">

</form>
</div>
<?php }; ?>


