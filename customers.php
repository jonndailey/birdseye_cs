<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/customer.css">
	<?php include('header.php');?>
</head>
<?php

$dataset = "<img src=\"images/logo/coffee.png\">";

include('db.php');


$customerID = $_REQUEST['cid'];


//Pulling the product the customer was sent. 
$chosen_product = mysqli_query($connection, "SELECT id,name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id WHERE cid = $customerID ORDER BY logged_info.tid DESC");


//Pulling the customer information.
$customer_data = mysqli_query($connection, "SELECT logged_info.warranty,logged_info.incoming_barcode, logged_info.outgoing_barcode, customers.name, logged_info.ticket_number,logged_info.date_sent,logged_info.selected_product,logged_info.date_returned,logged_info.tid FROM logged_info INNER JOIN customers ON customers.cid=logged_info.cid WHERE logged_info.cid = $customerID ORDER BY logged_info.tid DESC");

//Pulling the customers name to display at the top of the page.
$customer_name = mysqli_query($connection, "SELECT cid,name,email FROM customers WHERE cid = $customerID");


//Pull warranty information
$warranty = mysqli_query($connection, "SELECT id,status FROM warranty INNER JOIN logged_info ON warranty.id=logged_info.warranty WHERE cid = $customerID ORDER BY logged_info.tid DESC");

$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Pull the first note from the DB
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Pull the second note from the DB
$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Displaying the customers name and email.
while ($row = mysqli_fetch_array($customer_name)) {
	echo "<div id='infoContainer'>";
	echo "<div id='customerName'>". $row['name'] . "<br />";
	echo $row['email'] . "</div>";
	echo "</div>";
};



?>
<table id="customers">
		<th>Edit</th><th>Ticket</th><th>Sent</th><th>Returned</th><th>Outgoing</th><th>Incoming</th><th>Warranty</th><th>Product</th><th>Qty</th>

<?php while ($row = mysqli_fetch_array($customer_data)) { ?>
	<tr>
		<?php echo "<td><a href=\"transactionedit.php?tid=" . $row['tid'] . "\">Edit</a></td>";?>
		<td><?php echo $row['ticket_number'];?></td>
		<td><?php echo $row['date_sent'];?></td>
		<td><?php echo $row['date_returned'];?></td>
		<td class='outgoingTracking'><?php echo $row['outgoing_barcode'];?></td>
		<td class='incomingTracking'><?php echo $row['incoming_barcode'];?></td>

	<?php if ($row = mysqli_fetch_array($warranty)) { ?>
		<td><?php echo $row['status'];?></td>
	<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($chosen_product)) { ?>
		<td><?php echo $row['name'];?></td>
	<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($chosen_quantity)) { ?>
		<td><?php echo $row['quantity'];?></td>

	<?php }; ?>	
	
	<?php if ($row = mysqli_fetch_array($notes)) { ?>
		<?php echo "<table class='lastnote'><tr>" ?>
		<td><?php echo $row['note'];?></td>
		<?php echo "</tr><table>" ?>
	<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($notes2)) { ?>
		<?php echo "<tr class=\"sep\">" ?>
		<td><?php echo $row['note2'];?></td>
		<?php echo "</tr><table><br /><br />" ?>
	<?php }; ?>	

	</tr>
<?php }; ?>
</table>



</table>
</html>
