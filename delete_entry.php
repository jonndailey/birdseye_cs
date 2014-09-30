 <META http-equiv="refresh" content=".01;http://localhost/checkout.php">

<?php

include('db.php');

$identification = $_REQUEST['id'];


if (isset($_GET['id'])) {
mysqli_query($connection, "DELETE FROM minis WHERE id = $identification");
};







?>

