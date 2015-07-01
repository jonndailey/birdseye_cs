<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Coffee</title>
<script>

<link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/logo/favicon.ico" type="image/x-icon">

function validateForm() {
    var x = document.forms["checkoutform"]["name"].value;
    if (x == null || x == "") {
        document.getElementById("notification").style.visibility = "visible";
        return false; 	 
    }
}

var mytest = document.getElementsByClassName('name');

</script>

<meta name="description" content="Coffee - Tracking System">
<meta name="keywords" content="tracking,inventory,logging">
<meta name="author" content="Jonny Dailey">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="styles/global.css">
<link rel="stylesheet" type="text/css" href="styles/nav.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>




</head>

