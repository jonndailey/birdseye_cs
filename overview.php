<?php include('header.php');?>
<body class="overviewpage">
<?php include('nav.php');?>
<?php 

/*---------------------------------------------------*/
// Domestic sent and returned numbers and percentages //
/*---------------------------------------------------*/


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
$pl_ktmini_return_rate = $pl_count_ktmini_returned_array[0] / $pl_count_ktmini[0];
$result_ktmini = round($pl_ktmini_return_rate * 100);

/*-------------------------------------------------------*/
// End domestic sent and returned numbers and percentages //
/*-------------------------------------------------------*/




/*--------------------------------------------------------*/
// International sent and returned numbers and percentages //
/*--------------------------------------------------------*/

$ipl = mysqli_query($connection, "SELECT id,name FROM products WHERE products.protected = 'yes' AND logged_info.location != 1");

//International iGrill mini
$ipl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 3 AND logged_info.location != 1"); 
$ipl_count_igrillmini = mysqli_fetch_array($ipl_count);
$ipl_count_igrillmini_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 3   AND logged_info.location != 1"); 
$ipl_count_igrillmini_returned_array = mysqli_fetch_array($ipl_count_igrillmini_returned);
$ipl_igrill_mini_return_rate = $ipl_count_igrillmini_returned_array[0] / $ipl_count_igrillmini[0];
$iresult_igmini = round($ipl_igrill_mini_return_rate * 100);



//International iGrill2
$ipl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 7 AND logged_info.location != 1"); 
$ipl_count_igrill2 = mysqli_fetch_array($ipl_count);
$ipl_count_igrill2_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 7  AND logged_info.location != 1"); 
$ipl_count_igrill2_returned_array = mysqli_fetch_array($ipl_count_igrill2_returned);

$ipl_igrill2_return_rate = $ipl_count_igrill2_returned_array[0] / $ipl_count_igrill2[0];
$iresult_ig2 = round($ipl_igrill2_return_rate * 100);


//International iGrill mini QA
$ipl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 14 AND logged_info.location != 1"); 
$ipl_count_igrillmini_qa= mysqli_fetch_array($ipl_count);
$ipl_count_igrillmini_qa_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 14  AND logged_info.location != 1"); 
$ipl_count_grillmini_qa_returned_array = mysqli_fetch_array($ipl_count_igrillmini_qa_returned);

$ipl_grillmini_qa_return_rate = $ipl_count_grillmini_qa_returned_array[0] / $ipl_count_igrillmini_qa[0];
$iresult_igmqa = round($ipl_grillmini_qa_return_rate * 100);


//International KT
$ipl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 25 AND logged_info.location != 1"); 
$ipl_count_kt= mysqli_fetch_array($ipl_count);
$ipl_count_kt_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 25  AND logged_info.location != 1"); 
$ipl_count_kt_returned_array = mysqli_fetch_array($ipl_count_kt_returned);

$ipl_kt_return_rate = $ipl_count_kt_returned_array[0] / $ipl_count_kt[0];
$iresult_kt = round($ipl_kt_return_rate * 100);


//International KT mini 
$ipl_count = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 23 AND logged_info.location != 1"); 
$ipl_count_ktmini= mysqli_fetch_array($ipl_count);
$ipl_count_ktmini_returned = mysqli_query($connection, "SELECT COUNT(*) FROM logged_info  RIGHT JOIN products ON products.id=logged_info.selected_product WHERE products.protected = 'yes' AND selected_product = 23 AND logged_info.location != 1"); 
$ipl_count_ktmini_returned_array = mysqli_fetch_array($ipl_count_ktmini_returned);

$ipl_ktmini_return_rate = $ipl_count_ktmini_returned_array[0] / $ipl_count_ktmini[0];
$iresult_ktmini = round($ipl_ktmini_return_rate * 100);

/*-------------------------------------------------------------*/
// End international sent and returned numbers and percentages //
/*-------------------------------------------------------------*/


//Starting re-use percentages



//All items returned more than 14 days ago.

$call_me_maybe = mysqli_query($connection, "SELECT follow_up,tid,date_sent,follow_up,ticket_number,customers.name AS cus_name,products.name FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id INNER JOIN customers ON logged_info.cid=customers.cid WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -14 DAY) AND (now() - INTERVAL 14 DAY) AND date_returned = '' AND products.protected = 'yes' AND logged_info.location != 1 AND logged_info.follow_up = '' ORDER BY date_sent DESC");


// Percentage of product that comes back and is reusable.

$reusable_inventory = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned != '' AND reuse = 1");
$reusable_inventory_array = mysqli_fetch_array($reusable_inventory);

$unuseable_inventory = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned != '' AND reuse = 2");
$unuseable_inventory_array = mysqli_fetch_array($unuseable_inventory);

$reusable_percentage = $unuseable_inventory_array[0] / $reusable_inventory_array[0];
$reusable_result = round($reusable_percentage * 100);

//Percentage of iGrill2 that comes back useable

$igrill2_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 7 AND reuse = 1");
$igrill2_useable_array = mysqli_fetch_array($igrill2_useable);
$igrill2_non_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 7 AND reuse = 2");
$igrill2_non_useable_array = mysqli_fetch_array($igrill2_non_useable);
$total = $igrill2_useable_array[0] + $igrill2_non_useable_array[0];
$igrill2_useable_result =  $igrill2_useable_array[0] / $total;
$igrill2_useable_result_output = round($igrill2_useable_result * 100);

//Percentage of iGrillmini that comes back useable

$igrillmini_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 3 AND reuse = 1");
$igrillmini_useable_array = mysqli_fetch_array($igrillmini_useable);
$igrillmini_non_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 3 AND reuse = 2");
$igrillmini_non_useable_array = mysqli_fetch_array($igrillmini_non_useable);
$total = $igrillmini_useable_array[0] + $igrillmini_non_useable_array[0];
$igrillmini_useable_result =  $igrillmini_useable_array[0] / $total;
$igrillmini_useable_result_output = round($igrillmini_useable_result * 100);

//Percentage of Kitchen Thermometer that comes back useable


$kitchen_thermometer_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 25 AND reuse = 1");
$kitchen_thermometer_useable_array = mysqli_fetch_array($kitchen_thermometer_useable);
$kitchen_thermometer_non_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 25 AND reuse = 2");
$kitchen_thermometer_non_useable_array = mysqli_fetch_array($kitchen_thermometer_non_useable);
$total = $kitchen_thermometer_useable_array[0] + $kitchen_thermometer_non_useable_array[0];
$kitchen_thermometer_useable_result =  $kitchen_thermometer_useable_array[0] / $total;
$kitchen_thermometer_useable_result_output = round($kitchen_thermometer_useable_result * 100);


//Percentage of Kitchen Thermometer mini that comes back useable

$kitchen_thermometer_mini_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 23 AND reuse = 1");
$kitchen_thermometer_mini_useable_array = mysqli_fetch_array($kitchen_thermometer_mini_useable);
$kitchen_thermometer_mini_non_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 23 AND reuse = 2");
$kitchen_thermometer_mini_non_useable_array = mysqli_fetch_array($kitchen_thermometer_mini_non_useable);
$total = $kitchen_thermometer_mini_useable_array[0] + $kitchen_thermometer_mini_non_useable_array[0];
$kitchen_thermometer_mini_useable_result =  $kitchen_thermometer_mini_useable_array[0] / $total;
$kitchen_thermometer_mini_useable_result_output = round($kitchen_thermometer_mini_useable_result * 100);

//iGrill mini QA

$igrill_mini_qa_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 14 AND reuse = 1");
$igrill_mini_qa_useable_array = mysqli_fetch_array($igrill_mini_qa_useable);
$igrill_mini_qa_non_useable = mysqli_query($connection, "SELECT count(*) FROM logged_info WHERE date_returned !='' AND selected_product = 14 AND reuse = 2");
$igrill_mini_qa_non_useable_array = mysqli_fetch_array($igrill_mini_qa_non_useable);
$total = $igrill_mini_qa_useable_array[0] + $igrill_mini_qa_non_useable_array[0];
$igrill_mini_qa_useable_result =  $igrill_mini_qa_useable_array[0] / $total;
$igrill_mini_qa_useable_result_output = round($igrill_mini_qa_useable_result * 100);


//Which items were sent in the last 6 days

$pro_meat_probe_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 6");
$pro_meat_probe_sent_this_week_array = mysqli_fetch_array($pro_meat_probe_sent_this_week);

$standard_meat_probe_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 2");
$standard_probe_sent_this_week_array = mysqli_fetch_array($standard_meat_probe_sent_this_week);

$pro_ambient_probe_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 24 ");
$pro_ambient_probe_sent_this_week_array = mysqli_fetch_array($pro_ambient_probe_sent_this_week);

$igrill_mini_qa_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 14 ");
$igrill_mini_qa_sent_this_week_array = mysqli_fetch_array($igrill_mini_qa_sent_this_week);

$igrill_mini_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 3 ");
$igrill_mini_sent_this_week_array = mysqli_fetch_array($igrill_mini_sent_this_week);

$igrill_2_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 7 ");
$igrill_2_sent_this_week_array = mysqli_fetch_array($igrill_2_sent_this_week);

$kitchen_thermometer_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 7 ");
$kitchen_thermometer_sent_this_week_array = mysqli_fetch_array($kitchen_thermometer_sent_this_week);

$kitchen_thermometer_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 25 ");
$kitchen_thermometer_sent_this_week_array = mysqli_fetch_array($kitchen_thermometer_sent_this_week);

$kitchen_thermometer_mini_sent_this_week = mysqli_query($connection, "SELECT sum(quantity) FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) AND products.id = 23 ");
$kitchen_thermometer_mini_sent_this_week_array = mysqli_fetch_array($kitchen_thermometer_mini_sent_this_week);


$followed_up = mysqli_query($connection, "SELECT tid,ticket_number,name,date_sent FROM logged_info JOIN customers ON logged_info.cid=customers.cid WHERE follow_up = 1");
$followed_up_array = mysqli_fetch_array($followed_up);



$hello = date("Y-m-d");
echo "<br />";
echo $followed_up_array[2];
echo "<br />";
echo  $followed_up_array[2] - $hello[0] ;

$prod = mysqli_query($connection, "SELECT date_sent,customers.name AS customers_name,products.name FROM logged_info INNER JOIN products ON logged_info.selected_product=products.id  WHERE date_sent <= ADDDATE(CURDATE(), INTERVAL -0 DAY) AND date_sent >= ADDDATE(CURDATE(), INTERVAL -6 DAY) ");
$prod_array = mysqli_fetch_array($prod);




?>


<div id="overview">

<table id="domestic_percentages">
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
	    echo "<td>". $pl_count_ktmini_returned_array[0]  ."</td>";
	    echo "<td>". $result_ktmini  ."%</td></tr>";
	 ?>
</table>

<table id="international_percentages">
	<caption>International</caption>
	<th>Product</th><th>Sent</th><th>Returned</th><th>Return rate</th>
	<?php 
		echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "iGrill mini" . "</a> </td>";
	    echo "<td>". $ipl_count_igrillmini[0]  ."</td>";
	    echo "<td>". $ipl_count_igrillmini_returned_array[0]  ."</td>";
	    echo "<td>". $iresult_igmini ."%</td></tr>";


		echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "iGrill2" . "</a> </td>";
	    echo "<td>". $ipl_count_igrill2[0]  ."</td>";
	    echo "<td>". $ipl_count_igrill2_returned_array[0]  ."</td>";
	    echo "<td>". $iresult_ig2."%</td></tr>";



	    echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "iGrill mini - QA" . "</a> </td>";
	    echo "<td>". $ipl_count_igrillmini_qa[0]  ."</td>";
	    echo "<td>". $ipl_count_grillmini_qa_returned_array[0]  ."</td>";
	    echo "<td>". $iresult_igmqa."%</td></tr>";


	    echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "Kitchen Thermometer" . "</a> </td>";
	    echo "<td>". $ipl_count_kt[0]  ."</td>";
	    echo "<td>". $ipl_count_kt_returned_array[0] ."</td>";
	    echo "<td>". $iresult_kt."%</td></tr>";


	    echo "<tr><td> &#183; <a href=\"results.php?id=" . $list['id']  ."\">". "Kitchen Thermometer Mini" . "</a> </td>";
	    echo "<td>". $ipl_count_ktmini[0]  ."</td>";
	    echo "<td>". $ipl_count_ktmini_returned_array[0]  ."</td>";
	    echo "<td>". $iresult_ktmini."%</td></tr>";
	 ?>
</table>

<table id="reuse">
		<caption>Re-use</caption>
		<th>Product</th><th>Percentage</th>
		<tr>
			<td>Total re-usable Inventory</td>
			<td><?php echo $reusable_result . "%"; ?></td></tr>
		<tr>
			<td><?php echo "iGrill <sup>2</sup>" ?></td>
			<td><?php echo $igrill2_useable_result_output . "%" ?></td>
		</tr>
		<tr>
			<td><?php echo "iGrill <sup>mini</sup>" ?></td>
			<td><?php echo $igrillmini_useable_result_output . "%" ?></td>
		</tr>
		<tr>
			<td><?php echo "Kitchen Thermometer" ?></td>
			<td><?php echo $kitchen_thermometer_useable_result_output . "%" ?></td>
		</tr>
		<tr>
			<td><?php echo "Kitchen Thermometer <sup>mini</sup>" ?></td>
			<td><?php echo $kitchen_thermometer_mini_useable_result_output . "%" ?></td>
		</tr>
		<tr>
			<td><?php echo "iGrill mini <sup>QA</sup>" ?></td>
			<td><?php echo $igrill_mini_qa_useable_result_output . "%" ?></td>
		</tr>
</table>


<table id="thesix">
	<caption>Top items sent this week</caption>
	<th>Product</th><th>Quantity</th>
	<tr>
		<td>Pro Meat Probe</td>
		<td><?php echo $pro_meat_probe_sent_this_week_array[0] ?></td>
	</tr>

	<tr>
		<td>Standard Meat Probe</td>
		<td><?php echo $standard_probe_sent_this_week_array[0]  ?></td>
	</tr>

	<tr>
		<td>Pro Ambient Temp Probe</td>
		<td><?php echo $pro_ambient_probe_sent_this_week_array[0] ?></td>
	</tr>

	<tr>
		<td>iGrill mini - QA</td>
		<td><?php echo $igrill_mini_qa_sent_this_week_array[0] ?></td>
	</tr>

	<tr>
		<td>iGrill mini</td>
		<td><?php echo $igrill_mini_sent_this_week_array[0] ?></td>
	</tr>

	<tr>
		<td>iGrill <sup>2</sup></td>
		<td><?php echo $igrill_2_sent_this_week_array[0] ?></td>
	</tr>

	<tr>
		<td>Kitchen Thermometer</td>
		<td><?php echo $kitchen_thermometer_sent_this_week_array[0] ?></td>
	</tr>

	<tr>
		<td>Kitchen Thermometer<sup>mini</sup></td>
		<td><?php echo $kitchen_thermometer_mini_sent_this_week_array[0]  ?></td>
	</tr>
		
	</table>
	<caption>Followed up</caption>
	<div id="not_returned">
<div id="nested_returned">	
<form>
	<input type="text" value="Ticket Number" />
	<input id="sent_title" type="text" value="Date Sent" />
	<input id="sent_title" type="text" value="Name" />
	<input id="overview_products_area" type="text" value="Product" />
	<input type="text" value="Lost" id="sent_title_checked"/>
</form>
</div>
<?php while($row = mysqli_fetch_array($followed_up)){ ?>
<form >
	<input type="text" value=" <?php echo $row['ticket_number']; ?>" />
	<input id="sent" type="text" value=" <?php echo $row['name']; ?>" />
	<input id="sent" type="text" value=" <?php echo $row['date_sent']; ?>" />
	<input id="overview_products_area" type="text" value="" />
	<input type="submit" value="&cross;" id="submitBtn"/>
</form>
<?php }; ?>




	<caption>Sent, but not returned. Follow up.</caption>
<div id="nested_returned">	
<form>
	<input type="text" value="Ticket Number" />
	<input id="sent_title" type="text" value="Date Sent" />
	<input id="sent_title" type="text" value="Name" />
	<input id="overview_products_area" type="text" value="Product" />
	<input type="text" value="Checked" id="sent_title_checked"/>
</form>
</div>

	<tr>
		<?php while($row = mysqli_fetch_array($call_me_maybe)) { ?>
<form method="GET" action="followup.php">
	<input type="text" value=" <?php echo $row['ticket_number']; ?>" />
	<input id="sent" type="text" value=" <?php echo $row['date_sent']; ?>" />
	<input id="sent" type="text" value=" <?php echo $row['cus_name']; ?>" />
	<input id="overview_products_area" type="text" value=" <?php echo $row['name']; ?>" />
	<input id="sent" type="hidden" value="<?php echo $row['tid']; ?>" name="transaction"/>
	<input id="sent" type="hidden" value="1" name="answer"/>
	<input type="submit" value="&check;" id="submitBtn"/>
</form>
		<?php }; ?>
	</div>
</div>



</div>



	


