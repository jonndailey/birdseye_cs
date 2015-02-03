<?php include('header.php');?>
<body class="checkinpage">
<?php include('nav.php');?>


<?php
//grabs the first note and ties the customer and transactions ID together
$lastquery = mysqli_query($connection,"SELECT logged_info.tid,logged_info.date_sent,logged_info.cid,products.name,customers.name,products.protected,logged_info.note,logged_info.location FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id JOIN customers ON customers.cid=logged_info.cid WHERE date_returned = '' AND products.protected = 'yes' AND logged_info.location = 1 ORDER BY logged_info.tid DESC"); 

//Checkin note for the transaction.
$theNewNote =  mysqli_real_escape_string($connection, $_POST['secondNote']);
//Show me what product is selected in the database for the row
$chosen_product = mysqli_query($connection, "SELECT logged_info.note,logged_info.selected_product,logged_info.tid,products.id,products.name FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id WHERE date_returned = '' AND products.protected = 'yes' AND logged_info.location = 1 ORDER BY tid DESC");
											
//Show me everything in the database that does not have a return stamp
$checkin = mysqli_query($connection,"SELECT logged_info.date_sent,logged_info.cid,products.name,customers.name,products.protected,logged_info.note,logged_info.location FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id JOIN customers ON customers.cid=logged_info.cid WHERE date_returned = '' AND products.protected = 'yes' AND logged_info.location = 1 ORDER BY tid DESC");

//Show me the notes associated with returned row
$checkinNotes = mysqli_query($connection,"SELECT logged_info.tid,logged_info.note,logged_info.note2 FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid JOIN products ON logged_info.selected_product=products.id WHERE date_returned = '' AND products.protected = 'yes' ORDER BY logged_info.tid DESC");

//Count how many items are not checked in.
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id WHERE date_returned='' AND products.protected = 'yes' AND logged_info.location = 1 "); 

$number_of_items_displayed = mysqli_fetch_array($number_of_items);

$last3 = mysqli_query($connection, "SELECT logged_info.date_returned,customers.name,logged_info.cid FROM logged_info INNER JOIN customers ON customers.cid=logged_info.cid WHERE date_returned != ''  AND logged_info.location = 1  ORDER BY date_returned DESC LIMIT 3");

$chosen_product_for_3 = mysqli_query($connection, "SELECT logged_info.selected_product,products.name,products.id FROM logged_info INNER JOIN products ON products.id=logged_info.selected_product WHERE date_returned != '' AND logged_info.location = 1 AND products.protected = 'yes' ORDER BY date_returned DESC LIMIT 3");


echo "<div class='last3'>Last 3 items checked in";
echo "<table>";
while ($row = mysqli_fetch_array($last3)) {
	echo "<tr><td>" . $row['date_returned'] . "</td>";
	echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>"; ?>

<?php
	if ($row = mysqli_fetch_array($chosen_product_for_3)) {
		echo "<td class='product'>" . $row['name'] . "</td>";
	}
};
echo "</table></div>";
?>

<?php
echo "<br /><br /><div class='last3'>There are "  . $number_of_items_displayed[0] . " items to be checked in.</div>";
?>

<?php while ($row = mysqli_fetch_array($checkin)) { ?>
<div class="container">
<div>
<table>
	<tr>
		<td class="current"><?php echo $row['date_sent']; ?></td>
		<td class="current"><?php echo "<a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>"; ?>
		<td class="product"><?php  if ($row = mysqli_fetch_array($chosen_product)) { echo "<a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a>"; }; ?></td>
	</tr>
</table>
</div>
<?php if ($row = mysqli_fetch_array($lastquery)) { ?>
<table>
	<tr>
		<td><?php echo $row['note']; ?></td>
	</tr>
</table>

<form action="checkindate.php?" method="GET">

<textarea placeholder="Checkin Note..." name="secondNote"></textarea>
	Re-usable?
		<input type="radio" name="reuse" value="1" />Yes
		<input type="radio" name="reuse" value="2" />No
		<input type="hidden" name="id" value="<?php echo $row['tid'] ?>">
		<span class="movesubmit"><input type="submit"></span>
</form>
<?php }; ?>
</div>

<?php }; ?>

</body>
</html>