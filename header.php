<?php include('db.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Coffee</title>

<script language="Javascript" type="text/javascript">
var counter = 1;
var limit = 3;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Add" + (counter + 1) + " <br><select name='mydestination' type='text'><option>Hello</option> </select>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}

</script>

<meta name="description" content="Coffee - Tracking System">
<meta name="keywords" content="tracking,inventory,logging">
<meta name="author" content="Jonny Dailey">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="styles/global.css">
<link rel="stylesheet" type="text/css" href="styles/nav.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>


<script type="text/javascript">
	var name = document.getElementById(1650);

</script>

</head>
