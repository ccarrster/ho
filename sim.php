<?php

/*
$user = 'webgdr';
$password = 'webgdr';
$db = 'webgdr';
*/

$user = 'root';
$password = 'Ods4wPHZ35';
$db = 'mysql';


$con = mysqli_connect('127.0.0.1', $user, $password, $db);

$seats = array();
$result = mysqli_query($con,"SELECT * FROM `seats`;");
while($row = mysqli_fetch_array($result)) {
	$seat = $row['seat'];
	$vote = $row['vote'];
	$seats[$seat] = $vote;
}
?>
<html>
<head>
<title>Be // From - Seating View</title>
<style>
.enabled {
	display: block;
	background-color: green;
}
.disabled {
	display: block;
	background-color: red;
}

.box {
	position: absolute;
	width: 20px;
	height: 30px;
}
</style>
</head>
<body>
<img src="seating.png">
<?php
for($i = 0; $i < 8; $i++){
	?>
	<div id="seat<?php echo $i + 1 ?>" class="<?php if($seats[$seat]){echo "enabled";} else {echo "disabled";} ?> box" style="top: <?php echo 191 - $i * 2 ?>px; left: <?php echo 278 + $i * 23 ?>px;"><?php echo $i + 1 ?></div>
	<?php	
}
for($i = 0; $i < 8; $i++){
	?>
	<div id="seat<?php echo $i + 9 ?>" class="<?php if($seats[$seat]){echo "enabled";} else {echo "disabled";} ?>  box" style="top: <?php echo 177 + $i * 2 ?>px; left: <?php echo 462 + $i * 23 ?>px;"><?php echo $i + 9 ?></div>
	<?php	
}
?>
</body>
</html>
