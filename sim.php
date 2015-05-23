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
<script src="jquery-2.1.4.js"></script>
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
	<div id="seat<?php echo $i + 1 ?>" class="<?php if($seats[$i + 1]){echo "enabled";} else {echo "disabled";} ?> box" style="top: <?php echo 191 - $i * 2 ?>px; left: <?php echo 278 + $i * 23 ?>px;"><?php echo $i + 1 ?></div>
	<?php	
}
for($i = 0; $i < 8; $i++){
	?>
	<div id="seat<?php echo $i + 9 ?>" class="<?php if($seats[$i + 9]){echo "enabled";} else {echo "disabled";} ?>  box" style="top: <?php echo 177 + $i * 2 ?>px; left: <?php echo 462 + $i * 23 ?>px;"><?php echo $i + 9 ?></div>
	<?php	
}
for($i = 0; $i < 16; $i++){
	?>
	<div id="seat<?php echo $i + 17 ?>" class="<?php if($seats[$i + 17]){echo "enabled";} else {echo "disabled";} ?> box" style="top: <?php echo 176 - $i * 3 ?>px; left: <?php echo 93 + $i * 23 ?>px;"><?php echo $i + 1 ?></div>
	<?php	
}
for($i = 0; $i < 16; $i++){
	?>
	<div id="seat<?php echo $i + 33 ?>" class="<?php if($seats[$i + 33]){echo "enabled";} else {echo "disabled";} ?>  box" style="top: <?php echo 146 + $i * 3 ?>px; left: <?php echo 462 + $i * 23 ?>px;"><?php echo $i + 17 ?></div>
	<?php	
}
?>
<script>
function enablesome(){
	for(i = 0; i < 4; i++){
		var seat = Math.floor((Math.random() * 16)) + 1;
		$.get( "index.php?action=setseat&seat="+seat+"&enabled=1" );
	}
	setTimeout(refresh, 1000);
}

function disablesome(){
	for(i = 0; i < 4; i++){
		var seat = Math.floor((Math.random() * 16)) + 1;
		$.get( "index.php?action=setseat&seat="+seat+"&enabled=0" );
	}
	setTimeout(refresh, 1000);
}

function disableall(){
	for(seat = 2; seat <= 16; seat++){
		$.get( "index.php?action=setseat&seat="+seat+"&enabled=0" );
	}
	setTimeout(refresh, 1000);
}

function refresh() {
	location.reload(true);	
}
</script>
<form>
<input type="button" value="Enable Some" onclick="enablesome()">
<input type="button" value="Disable Some" onclick="disablesome()">
<input type="button" value="Disable All" onclick="disableall()">
</form>
</body>
</html>
