<?php include('header.php');?>
<body class="overviewpage">
<?php include('nav.php');?>
<?php 

$pl = mysqli_query($connection, "SELECT id,name FROM products WHERE products.protected = 'yes' AND logged_info.location = 1");

//iGrill mini
$pl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 3 AND logged_info.location = 1"); 
$pl_count_igrillmini = mysqli_fetch_array($pl_count);
$pl_count_igrillmini_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 3 AND date_returned = ''  AND logged_info.location = 1"); 
$pl_count_igrillmini_returned_array = mysqli_fetch_array($pl_count_igrillmini_returned);
$pl_igrill_mini_return_rate = $pl_count_igrillmini_returned_array[0] / $pl_count_igrillmini[0];
$result_igmini = round($pl_igrill_mini_return_rate * 100);



//iGrill2
$pl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 7 AND logged_info.location = 1"); 
$pl_count_igrill2 = mysqli_fetch_array($pl_count);
$pl_count_igrill2_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 7 AND date_returned != '' AND logged_info.location = 1"); 
$pl_count_igrill2_returned_array = mysqli_fetch_array($pl_count_igrill2_returned);

$pl_igrill2_return_rate = $pl_count_igrill2_returned_array[0] / $pl_count_igrill2[0];
$result_ig2 = round($pl_igrill2_return_rate * 100);


//iGrill mini QA
$pl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 14 AND logged_info.location = 1"); 
$pl_count_igrillmini_qa= mysqli_fetch_array($pl_count);
$pl_count_igrillmini_qa_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 14 AND date_returned != '' AND logged_info.location = 1"); 
$pl_count_grillmini_qa_returned_array = mysqli_fetch_array($pl_count_igrillmini_qa_returned);
$pl_grillmini_qa_return_rate = $pl_count_grillmini_qa_returned_array[0] / $pl_count_igrillmini_qa[0];
$result_igmqa = round($pl_grillmini_qa_return_rate * 100);


//KT
$pl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 25 AND logged_info.location = 1"); 
$pl_count_kt= mysqli_fetch_array($pl_count);
$pl_count_kt_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 25 AND date_returned != '' AND logged_info.location = 1"); 
$pl_count_kt_returned_array = mysqli_fetch_array($pl_count_kt_returned);
$pl_kt_return_rate = $pl_count_kt_returned_array[0] / $pl_count_kt[0];
$result_kt = round($pl_kt_return_rate * 100);


//KT mini 
$pl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 23 AND date_returned = '' AND logged_info.location = 1"); 
$pl_count_ktmini= mysqli_fetch_array($pl_count);
$pl_count_ktmini_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 23 AND date_returned != '' AND logged_info.location = 1"); 
$pl_count_ktmini_returned_array = mysqli_fetch_array($pl_count_ktmini_returned);

//All items returned more than 14 days ago.

$call_me_maybe = mysqli_query($connection, "SELECT date_sent,customers.name AS cus_name,products.name FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id INNER JOIN customers ON logged_info.cid=customers.cid WHERE date_sent <= ADDDATE(CURDATE() -14, INTERVAL -14 DAY) AND (now() - INTERVAL 14 DAY) AND date_returned = '' AND products.protected = 'yes' AND logged_info.location = 1 ORDER BY date_sent DESC");

?>

<div id="overview1">
<table id="over">
	<caption>Domestic</caption>
	<th>Product</th><th>Sent</th><th>Returned</th><th>Return rate</th>
	<?php 
		echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "iGrill mini" . "</a> </td>";
	    echo "<td>". $pl_count_igrillmini[0]  ."</td>";
	    echo "<td>". $pl_count_igrillmini_returned_array[0]  ."</td>";
	    echo "<td>". $result_igmini ."%</td></tr>";


		echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "iGrill2" . "</a> </td>";
	    echo "<td>". $pl_count_igrill2[0]  ."</td>";
	    echo "<td>". $pl_count_igrill2_returned_array[0]  ."</td>";
	    echo "<td>". $result_ig2."%</td></tr>";



	    echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "iGrill mini - QA" . "</a> </td>";
	    echo "<td>". $pl_count_igrillmini_qa[0]  ."</td>";
	    echo "<td>". $pl_count_grillmini_qa_returned_array[0]  ."</td>";
	    echo "<td>". $result_igmqa."%</td></tr>";


	    echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "Kitchen Thermometer" . "</a> </td>";
	    echo "<td>". $pl_count_kt[0]  ."</td>";
	    echo "<td>". $pl_count_kt_returned_array[0] ."</td>";
	    echo "<td>". $result_kt."%</td></tr>";


	    echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "Kitchen Thermometer Mini" . "</a> </td>";
	    echo "<td>". $pl_count_ktmini[0]  ."</td>";
	    echo "<td>". $pl_count_ktmini_returned_array[0]  ."</td></tr>";
	 ?>
</table>

<table id ="over2">
	<caption>Sent, but not returned. Follow up.</caption>
	<tr>
		<?php while($row = mysqli_fetch_array($call_me_maybe)) { ?>
		<td id="sent"><?php echo $row['date_sent'] ?></td>
		<td><?php echo $row['cus_name'] ?></td>
		<td><?php echo $row['name'] ?></td>
	</tr>
<?php }; ?>
</table>
</div>