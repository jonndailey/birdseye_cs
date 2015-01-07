<?php include('header.php');?>
<body class="checkinpage">
<?php include('nav.php');?>

<?php

//Checkin note for the transaction.
$theNewNote =  mysqli_real_escape_string($connection, $_POST['secondNote']);

//Start of table
echo "<table class=\"productcheckin\">";

//Show me what product is selected in the database for the row
$chosen_product = mysqli_query($connection, "SELECT logged_info.selected_product,logged_info.tid,products.id,products.name FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id WHERE date_returned = '' AND products.protected = 'yes' ORDER BY tid DESC");
											
//Show me everything in the database that does not have a return stamp
$checkin = mysqli_query($connection,"SELECT logged_info.date_sent,logged_info.cid,products.name,customers.name,products.protected,logged_info.note,logged_info.note2 FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id JOIN customers ON customers.cid=logged_info.cid WHERE date_returned = '' AND products.protected = 'yes' ORDER BY tid DESC");

//Show me the notes associated with returned row
$checkinNotes = mysqli_query($connection,"SELECT logged_info.note,logged_info.note2,logged_info.tid FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid JOIN products ON logged_info.selected_product=products.id WHERE date_returned = '' AND products.protected = 'yes' ORDER BY logged_info.tid DESC");

//Count how many items are not checked in.
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id WHERE date_returned='' AND products.protected = 'yes' "); 

$number_of_items_displayed = mysqli_fetch_array($number_of_items);

$last3 = mysqli_query($connection, "SELECT logged_info.date_returned,customers.name,logged_info.cid FROM logged_info INNER JOIN customers ON customers.cid=logged_info.cid WHERE date_returned != '' ORDER BY date_returned DESC LIMIT 3");

$chosen_product_for_3 = mysqli_query($connection, "SELECT logged_info.selected_product,products.name,products.id FROM logged_info INNER JOIN products ON products.id=logged_info.selected_product WHERE date_returned != '' ORDER BY date_returned DESC LIMIT 3");

echo "<div align='center'>Last 3 items checked in</div>";
while ($row = mysqli_fetch_array($last3)) { ?>
	<table align="center" class="checkinBox">
		  <tr>
			<td><?php echo $row['date_returned']; ?></td>
			<?php echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>"; ?>
			<td class="product"><?php  if ($row = mysqli_fetch_array($chosen_product_for_3)) { echo "<a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a>"; }; ?></td>
	  	  </tr><br />
		</table>
<?php }; ?>



<?php
echo "<br /><br /><br /><br /><br /><div align='center'>There are "  . $number_of_items_displayed[0] . " items to be checked in.</div>";

?>

<?php while ($row = mysqli_fetch_array($checkin)) { ?>
		<table>
		  <tr>
			<td><?php echo $row['date_sent']; ?></td>
			<?php echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>"; ?>
			<td class="product"><?php  if ($row = mysqli_fetch_array($chosen_product)) { echo "<a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a>"; }; ?></td>
	  	  </tr><br />
		</table>

	<?php if ($row = mysqli_fetch_array($checkinNotes)) { ?>
		<table align="center" class="exclude">
		  <tr>
			 <td><?php echo $row['note'] ;?></td>
		  </tr>
		  <tr>
			 <td><?php
			 	if (!$row['note2']) {
			 		//passing the transaction ID to the checkindate page. 
			 		echo "<form action=\"checkindate.php?id=$row[tid]\" method=\"POST\">";
			 		echo "<div id=\"newNote\"><textarea type=\"text\" placeholder=\"Check in note.\" name=\"secondNote\" id=\"secondNote\" ></textarea><br /><input type=\"submit\" value=\"Check me in\">";
			 		echo "</form>";
			 	}else {echo $row['note2'];}

			 ?></td>
			 <?php }; ?>
		  </tr>
		</table>
</form>
	<?php echo "<br />" ?>
  
<?php }; ?>
</table>
</body>
</html>