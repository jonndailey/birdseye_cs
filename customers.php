<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/checkin.css">
</head>
<?php

$dataset = "<img src=\"images/logo/coffee.png\">";

include('db.php');

$customerID = $_REQUEST['cid'];

$customer_data = mysqli_query($connection, "SELECT logged_info.incoming_barcode, logged_info.outgoing_barcode, customers.name, logged_info.ticket_number,logged_info.date_sent,logged_info.selected_product,logged_info.date_returned FROM logged_info INNER JOIN customers ON customers.cid=logged_info.cid  WHERE logged_info.cid = $customerID ORDER BY logged_info.tid DESC");
$customer_name = mysqli_query($connection, "SELECT cid,name,email FROM customers WHERE cid = $customerID");
$chosen_product = mysqli_query($connection, "SELECT name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id WHERE cid = $customerID ORDER BY logged_info.tid DESC");

while ($row = mysqli_fetch_array($customer_name)) {
	echo "<h1> ". $row['name'] . "</h1>";
	echo "<h1> ". $row['email'] . "</h1>";
};

?>
<table>
		<th>Ticket</th><th>Date Sent</th><th>Date Returned</th><th>Outgoing Barcode</th><th>Incoming Barcode</th><th>Product</th>

<?php while ($row = mysqli_fetch_array($customer_data)) { ?>
	<tr>
		<td><?php echo $row['ticket_number'];?></td>
		<td><?php echo $row['date_sent'];?></td>
		<td><?php echo $row['date_returned'];?></td>
		<td><?php echo $row['outgoing_barcode'];?></td>
		<td><?php echo $row['incoming_barcode'];?></td>
		<?php if ($row=mysqli_fetch_array($chosen_product)){ ?>
			<td><?php echo $row['name'];?></td>
		<?php }; ?>
	</tr>
<?php }; ?>
<?php ?>
</table>
</html>
