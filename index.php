

<link rel="stylesheet" type="text/css" href="styles/styles.css">



<?php

$dataset = "Welcome to the iGrill Mini QA data set";


include('db.php');



//Adding the MySql query into a variable
$result = mysqli_query($connection, "SELECT * FROM logged_info" );


//Break lines for readability


echo "<table>" . "<th>Ticket Number</th>" . "<th>Customer Name</th>" . "<th>Date Sent</th>" . "<th>Date Returned</th>" . "<th>Outgoing Barcode</th>" . "<th>Incoming Barcode</th>";

//Looping through and displaying all the information in the Database
while($row = mysqli_fetch_array($result)) {

if ($row[date_returned] == "") {
	$row[date_returned] = "<strong>Check In</strong>";
}elseif ($row['outgoing_barcode'] == "") {
	$row['outgoing_barcode'] = "Information not logged";
}

echo "<table>";
echo  "<tr><td class='ticket'>" . $row['ticket_number'] . "</td> ";

echo  "<td class='customer'>" . $row['customer_name'] . "</td> ";


echo "<td class='date'>" . $row['date_sent'] . "</td>";

echo "<td class='returned'>" . $row['date_returned'] . "</td>";

echo "<td class='outgoing'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['outgoing_barcode'] . "'>" . $row['outgoing_barcode'] ." </a> </td>";
echo "<td class='incoming'> <a href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row['incoming_barcode'] . "'>" . $row['incoming_barcode'] ." </a> </td>";


echo "</table>";
}



?>
