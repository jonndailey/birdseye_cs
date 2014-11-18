<DOCTYPE html>
<html>
<head>
<title>Check in</title>
<link rel="stylesheet" type="text/css" href="styles/results.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="styles/checkin.css">
</head>
<body>
<?php

$dataset = "*";
include('db.php');

echo "<br /><br />";
echo "<a href=\"checkout.php\">Checkout Page</a><br />";
echo "<a href=\"checkin.php\">Checkin Page</a><br />";

echo "<table>";



//Show me what product is selected in the database for the row
$chosen_product = mysqli_query($connection, "SELECT products.id, products.name, products.color_code FROM products INNER JOIN logged_info ON logged_info.selected_product=products.id ORDER BY logged_info.id DESC");

//Show me everything in the databse that does not have a return stamp
$checkin = mysqli_query($connection,"SELECT * FROM logged_info WHERE date_returned = '' ORDER BY logged_info.cid DESC");

//Show me the notes associated with returned row
$notes = mysqli_query($connection, "SELECT * FROM logged_info WHERE selected_product = $product ORDER BY id DESC");


$checkinNotes = mysqli_query($connection,"SELECT customer_name,note,note2,id,date_sent FROM logged_info WHERE date_returned = '' ORDER BY logged_info.id DESC");

//Count how many items are not checked in.
$number_of_items = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info WHERE  date_returned=''"); 
$number_of_items_displayed = mysqli_fetch_array($number_of_items);

echo "<div align='center'>There are "  . $number_of_items_displayed[0] . " items to be checked in.</div>";

echo "<th>Checkout Date</th>" ;
?>
<form>



	<?php while ($row = mysqli_fetch_array($checkin)) { ?>


	
	<table align="center">
	  <tr>
		<td><?php echo $row['date_sent'];  ?></td>
		<td><?php echo $row['customer_name']; ?></td>	

		
		<?php 
		//Query that checks an item into the database
		echo "<td id ='checkin'><a href=\"checkindate.php?id=" . $row['id'] . "\">Check me in</a></td>"; 
		?>

	<td class="product">
		<?php 
			if ($row = mysqli_fetch_array($chosen_product)) {
	echo "<div class='" . $row['color_code'] . "'><a href=\"results.php?id=" . $row['id']  ."\">". $row['name'] . "</a></div> ";
		};


		?>


	
	</td>
			
	</table>

	<?php if ($row = mysqli_fetch_array($checkinNotes)) { ?>

		<table align="center" class="exclude">
			<tr>
				
					<?php echo "<td>" . $row['note'] . "</td>";?>
				
			</tr>
			<tr>
				<td><!--<input class='optionalNote' type='text' placeholder="Insert optional checkin note."></input><input type='submit'></input>--></td>
			</tr>
		</table>

		</form>
	<?php echo "<br />" ?>

<?php }; ?>

<?php }; ?>

</table>

