<DOCTYPE html>
<html>
<head>
<title>Check in</title>
<link rel="stylesheet" type="text/css" href="styles/results.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="styles/checkin.css">
<script src="scripts/jquery-1.10.2.min.js"></script>
<script src="scripts/main-script.js"></script>
</head>
<body>
<?php


//Lets me know the connection to the server was successful
$dataset = "*";

//Including the DB connection
include('db.php');


//My Dev navigation. Not final.
echo "<br /><br />";
echo "<a href=\"checkout.php\">Checkout Page</a><br />";
echo "<a href=\"checkin.php\">Checkin Page</a><br />";

//Checkin note for the transaction.
$theNewNote =  mysqli_real_escape_string($connection, $_POST['secondNote']);


//Start of table
echo "<table>";

//Show me what product is selected in the database for the row
$chosen_product = mysqli_query($connection, "SELECT products.id, products.name,products.color_code FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.tid DESC");

//Show me everything in the databse that does not have a return stamp
$checkin = mysqli_query($connection,"SELECT customers.name, customers.cid, logged_info.ticket_number, logged_info.date_sent,logged_info.tid from logged_info INNER JOIN customers ON customers.cid=logged_info.cid WHERE date_returned = '' ORDER BY logged_info.tid DESC ");

//Show me the notes associated with returned row
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY logged_info.tid DESC");

$checkinNotes = mysqli_query($connection,"SELECT note,note2,logged_info.tid FROM logged_info WHERE date_returned = '' ORDER BY logged_info.tid DESC");

//Count how many items are not checked in.
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE  date_returned=''"); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);

echo "<div align='center'>There are "  . $number_of_items_displayed[0] . " items to be checked in.</div>";

echo "<th>Checkout Date</th>" ;
?>

<?php while ($row = mysqli_fetch_array($checkin)) { ?>

		<table align="center">
		  <tr>
			<td><?php echo $row['date_sent']; ?></td>
			<td><?php echo $row['name']; ?></td>	
			<?php /* echo "<td id ='checkin'><a id=\"message\" href=\"checkin.php?id=" . $row['tid'] . "\ */">Check me in</a></td>"; ?>
			<td class="product"><?php if ($row = mysqli_fetch_array($chosen_product)) { echo "<div class='" . $row['color_code'] . "'><a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a></div> "; }; ?></td>
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
		  </tr>
		</table>
</form>
	<?php echo "<br />" ?>
  <?php }; ?>
<?php }; ?>
</table>
</body>
</html>