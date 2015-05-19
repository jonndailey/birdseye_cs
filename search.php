<?php
include('header.php');
include('nav.php');

?>
<body class="resultspage">

<?php
require_once 'db.php';
$currDate = Date("Y-m-d H:i:s");

$starttime = microtime(true);

$query = $_GET['search'];


if (isset($_GET['search'])) {

	$query = mysqli_real_escape_string($connection,$_GET['search']);

	$raw_results = mysqli_query($connection,
		"SELECT tid,customers.cid,ticket_number,customers.name,date_sent,date_returned,outgoing_barcode,incoming_barcode,note,note2,quantity,logged_info.weight,status,area.mypath 
		 FROM logged_info INNER JOIN customers ON logged_info.cid=customers.cid 
		 JOIN p_size ON logged_info.weight=p_size.id 
		 JOIN warranty ON logged_info.warranty=warranty.id 
		 JOIN area ON logged_info.location=area.id 
		 WHERE note COLLATE utf8_general_ci LIKE '%{$query}%' OR
		 note2 COLLATE utf8_general_ci LIKE '%{$query}%' OR 
		 date_sent LIKE '%{$query}%' OR 
		 outgoing_barcode LIKE '%{$query}%' OR 
		 incoming_barcode LIKE '%{$query}%' OR 
		 note LIKE '%{$query}%' OR 
		 name COLLATE utf8_general_ci LIKE '%{$query}%' OR
		 ticket_number LIKE '%{$query}%' OR mypath LIKE '%{$query}%'
		");

	$num_results = mysqli_num_rows($raw_results);

	$endtime = microtime(true);	

	$duration = $endtime - $starttime;

	$log_query = mysqli_query($connection, "INSERT INTO search (query, time, num_results, query_time) VALUES ('$query','$currDate','$num_results','$duration')");

}

?>
<div class="result_count">
	<div id="found_results">Found <?php echo $num_results ?> results for <?php echo "<em>" . $query . ".</em>" ?></div>

</div>
<?php
echo "<table id=\"resultsData\">" . "<tr><th>Ticket Number</th>" . "<th>Name</th>" . "<th>Date sent</th>" . "<th>Date Received</th>" . "<th>Outgoing Tracking</th>" . "<th>Incoming Tracking</th>" . "</tr>";


if (mysqli_num_rows($raw_results) > found0) {
	while ($row = mysqli_fetch_array($raw_results)) {
	echo "<table>";
	echo "<tr>";
	echo "<td id=" . $row['tid'] . "  name=\"jticket\" >&raquo; <a href='https://idevices.zendesk.com/agent/tickets/" . $row['ticket_number'] . "' target=\"_blank\" >" . $row['ticket_number'] ."</a> </td>";
	echo "<td><a href=\"customers.php?cid=" . $row['cid'] . "\">" . $row['name'] . "</a></td>";
	echo "<td>" . $row['date_sent'] . "</td>";
	echo "<td>" . $row['date_returned'] ;
	

if ($row['date_returned'] == '') {
	echo "<a href=\"checkin.php\">Not checked in</a></td>";
};

	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "' target=\"_blank\">" . $row['outgoing_barcode'] ."</a></td>";
	echo "<td> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "' target=\"_blank\">" . $row['incoming_barcode'] ."</a></td>";

	echo "<tr  class='resultdata'>";

	echo "<td class='outerinfo'>";
	echo "<img alt=\"flag\" src=\"images/flags/" . $row['mypath'] . "\">";
	echo "<div class='detailedinfo'>";
	echo "Qty: " . $row['quantity'] . " &#183; ";
	echo $row['weight'] . " oz &#183; ";
	echo $row['status'];
	echo "</div>";
	echo "</td></table>";
	echo "<table><td class='mynote'>";
	echo $row['note'];
	echo "</td>";
	echo "</tr>";
	echo "<br /><td class='mynote'>";
	echo $row['note2'];
	echo "</td></table>";

	echo "</tr><br /><br />";
}

echo "</tr>";
echo "</table>";
}


?>

