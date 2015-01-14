<?php include('header.php');?>
<body class="nameedit">
<?php include('nav.php');?>

<?php 

$customer = $_REQUEST['cid'];

$customerqueryarray = mysqli_fetch_array($customer_info);

$customer_info = mysqli_query($connection, "SELECT cid,name,email FROM customers WHERE cid = $customer");


?>

<div class="groupedData" align="center">

<p>Change customers name and/or email.</p>

<?php while ($row = mysqli_fetch_array($customer_info)) { ?>
	<form action="editinsert.php?">
	<input type="text" name="customer_name" placeholder="Customer Name" value="<?php echo $row['name']; ?>"></input>
	<input type="text" name="customer_email" placeholder="Customer Email" value="<?php echo $row['email']; ?>"></input><br />
	<input type="hidden" name="cid" value="<?php echo $customer ?>"></input>
	<input type="submit" value="Change info"></input>
</form>

<?php } ?>
</div>