<?php include('header.php');?>
<body class="customerspage">
<?php include('nav.php');?>

<?php

$customerID = $_REQUEST['cid'];

//Pulling the product the customer was sent. 
$chosen_product = mysqli_query($connection, "SELECT id,name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Pulling the customer information.
$customer_data = mysqli_query($connection, "SELECT logged_info.warranty,logged_info.incoming_barcode, logged_info.outgoing_barcode, customers.name, logged_info.ticket_number,logged_info.date_sent,logged_info.selected_product,logged_info.date_returned,logged_info.tid FROM logged_info INNER JOIN customers ON customers.cid=logged_info.cid WHERE logged_info.cid = $customerID ORDER BY logged_info.tid DESC");

//Pulling the customers name to display at the top of the page.
$customer_name = mysqli_query($connection, "SELECT cid,name,email FROM customers WHERE cid = $customerID");

//Pull warranty information
$warranty = mysqli_query($connection, "SELECT id,status FROM warranty INNER JOIN logged_info ON warranty.id=logged_info.warranty WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Pull the quantity
$chosen_quantity = mysqli_query($connection, "SELECT amount.quantity,logged_info.quantity FROM amount INNER JOIN logged_info ON amount.id=logged_info.quantity WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Pull the first note from the DB
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Pull the second note from the DB
$notes2 = mysqli_query($connection, "SELECT * FROM logged_info WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Package weight
$chosen_size = mysqli_query($connection, "SELECT p_size.id,p_size.package,logged_info.weight FROM p_size INNER JOIN logged_info ON p_size.id=logged_info.weight WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//For the display of the flag
$chosen_location = mysqli_query($connection, "SELECT area.secondary_name,area.mypath,logged_info.location FROM area INNER JOIN logged_info ON area.id=logged_info.location WHERE cid = $customerID ORDER BY logged_info.tid DESC");

//Displaying the customers name and email.
while ($row = mysqli_fetch_array($customer_name)) {
	echo "<div id='infoContainer'>";
	echo "<div id='customerName'>". $row['name'] . "<br />";
	echo $row['email'] . "<span class=\"name_edit\">&nbsp;<a href=\"name_edit.php?cid=" . $row['cid'] . "\">Edit</a></span></div>";
	echo "</div>";
};



?>

<table id="customers">
		<tr><th>Edit</th><th>Ticket</th><th>Sent</th><th>Returned</th><th>Incoming</th><th>Outgoing</th><th>Warranty</th><th>Product</th><th>Qty</th><th>Weight</th><th>Country</th></tr>

<?php while ($row = mysqli_fetch_array($customer_data)) { ?>
	<tr class="customerTopLine">
		<?php echo "<td class=\"editbutton\"><a href=\"transactionedit.php?tid=" . $row['tid'] . "\"><img alt=\"edit\" src=\"images/buttons/edit.png\"></a></td>";?>
		<?php echo "<td id=\"" . $row['tid'] . "\"> <a href='https://idevices.zendesk.com/agent/tickets/" . $row['ticket_number'] . "' target=\"_blank\" >" . $row['ticket_number'] ."</a> </td>"; ?>
		<td><?php echo $row['date_sent'];?></td>
		<td><?php echo $row['date_returned'];?></td>
		<?php echo "<td class='incomingTracking'><a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "' target=\"_blank\">" . $row['incoming_barcode'] ." </a></td>" ?>
		<?php echo "<td class='outgoingTracking'><a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "' target=\"_blank\">" . $row['outgoing_barcode'] ." </a></td>" ?>
		

	<?php if ($row = mysqli_fetch_array($warranty)) { ?>
		<td><?php echo $row['status'];?></td>
	<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($chosen_product)) { ?>
		<td><?php echo "<a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a>";?> </td> 
	<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($chosen_quantity)) { ?>
		<td><?php echo $row['quantity'];?></td>


	<?php }; ?>	
	<?php if ($row = mysqli_fetch_array($chosen_size)) { ?>
		<td><?php echo $row['package'] . "oz";?></td>
			<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($chosen_location)) { ?>
		<td><?php echo $row['secondary_name'];?></td>
			<?php }; ?>		
	<?php if ($row = mysqli_fetch_array($notes)) { ?>
		<?php echo "<tr>" ?>
		<td><?php echo $row['note'];?></td>
		<?php echo "</tr></table><table>" ?>
	<?php }; ?>	

	<?php if ($row = mysqli_fetch_array($notes2)) { ?>
		<?php echo "<tr class=\"customerBottomLine\">" ?>

		<td><?php echo $row['note2'];?></td>

		<?php echo "</tr>" ?>
	<?php }; ?>	

	
<?php }; ?>

</table>
</html>
