<?php include('header.php');?>
<body class="zuckerburg">
<?php include('nav.php');?>

<?php $zuckit = mysqli_query($connection, "SELECT * FROM search ORDER BY id DESC"); ?>

<table align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><th>Query</th><th>Date & Time</th><th>Numer of results</th><th>Query Time (Microseconds)</tr>
	<?php while ($row = mysqli_fetch_array($zuckit)) { ?>
	<tr><td><?php echo $row['query'] ?></td><td><?php echo $row['time'] ?></td><td><?php echo $row['num_results'] ?></td><td><?php echo $row['query_time'] ?></td>
	<?php }; ?>
</table>