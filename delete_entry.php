<META http-equiv="refresh" content=".01;http://localhost/checkout.php">
<link rel="stylesheet" type="text/css" href="styles/glance.css">
<?php

include('db.php');

$lastID = mysqli_insert_id($connection);


echo "<p>Good to go</p>";
$identification = $_REQUEST['id'];


if (isset($_GET['id'])) {
mysqli_query($connection, "DELETE FROM customers WHERE cid = $identification");
};


?>


