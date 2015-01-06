<META http-equiv="refresh" content=".01;http://localhost/checkout.php">
<link rel="stylesheet" type="text/css" href="styles/glance.css">
<?php

include('db.php');

echo "<p>Good to go</p>";
$identification = $_REQUEST['tid'];


if (isset($_GET['tid'])) {
mysqli_query($connection, "UPDATE logged_info SET date_returned = '' WHERE tid = $identification");
};

echo "<META http-equiv='refresh' content='.01;http://localhost/transactionedit.php?tid=" . $identification . "'>";
?>

