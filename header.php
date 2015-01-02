<link rel="stylesheet" type="text/css" href="styles/nav.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="scripts/jquery-1.10.2.min.js"></script>
<script src="scripts/main-script.js"></script>
</head>
<body>

<div id="nav" align="center">

<div id="collectedLinks" align="center">
<br /><a href="/checkout.php" onmouseout="document.tan1.src='images/logo/coffeedcb3a3_small.png'" onmouseover="document.tan1.src='images/logo/coffee59000_small.png'"><img name="tan1" src="images/logo/coffeedcb3a3_small.png"></a>
 <br /><br />

<?php

include('db.php');

$pl = mysqli_query($connection, "SELECT id,name FROM products");



while($list = mysqli_fetch_array($pl)){
	//Write the line of HTML for each item
	echo "&#183; <a href=\"results.php?id=" . $list['id']  ."\">". $list['name'] . "</a> ";

}

?>

</div>

</div>