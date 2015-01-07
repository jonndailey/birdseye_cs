<div id="nav" align="center">
<div id="collectedLinks" align="center">
<a href="/checkout.php" onmouseout="document.tan1.src='images/logo/coffeedcb3a3_small.png'" onmouseover="document.tan1.src='images/logo/coffee59000_small.png'"><img name="tan1" src="images/logo/coffeedcb3a3_small.png"></a>
<div class="checklinks"><a href="/checkout.php">Checkout</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/checkin.php">Checkin</a></div>
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