
<div id="search_form">
	<img src="images/easter/faces.png" id="header_image"/>

<form method="GET" action="search.php" >
	<input type="text" id="search" name="search" target="_blank" autocomplete="off" placeholder="Type and press 'Enter'...">
	<input type="hidden" value="Search!" id="search_button" />
</form>
</div>

<div id="notification"><img src="images/easter/krissays_small.png" /><br /><span class="notification_message">Don't forget the <strong>date code</strong>!</span></div>


<div id="nav">
<div id="collectedLinks">
<!--<img id="tan1" src="images/logo/papercup_starbuckscolorsdarkerwithshadow_first.png" alt="Coffee Logo">-->
<div class="checklinks"><a href="checkout.php">Checkout</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="checkin.php">Checkin</a></div>
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