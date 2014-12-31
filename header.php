<link rel="stylesheet" type="text/css" href="styles/nav.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="scripts/jquery-1.10.2.min.js"></script>
<script src="scripts/main-script.js"></script>
<script>

		function popup() {
			var element = document.getElementById("collectedLinks").style.display = "block";
		}

		function popdown() {
			var element = document.getElementById("collectedLinks").style.display = "none";
			var element = document.getElementById("collectedLinks").style.height = "100%";

		}
	</script>

</head>
<body>

<div id="nav" align="center">

<div id="collectedLinks" align="center">

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