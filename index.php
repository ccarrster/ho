<?php

/*

create table seats (id MEDIUMINT NOT NULL AUTO_INCREMENT, seat INTEGER, vote INTEGER, inserttime TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (ID));

create table youfrom (id MEDIUMINT NOT NULL AUTO_INCREMENT, time double, pan double, primary key (id));


 */
/*
$user = 'webgdr';
$password = 'webgdr';
$db = 'webgdr';
*/

$user = 'root';
$password = 'Ods4wPHZ35';
$db = 'mysql';

$con = mysqli_connect('127.0.0.1', $user, $password, $db);

$homeLat = 43.454308;
$homeLon = -80.48386;

if ($_GET['action'] != null) {
	if ($_GET['action'] == "from") {
		$result = mysqli_query($con,"SELECT * FROM `youfrom`;");
		$data = array();
		while($row = mysqli_fetch_array($result)) {
			$time = $row['time'];
			$pan = $row['pan'];			
			$data[] = array("time" => $time, "pan" => $pan);
		}
		echo json_encode(array("from" => array("data" => $data)));
	}
	if ($_GET['action'] == "votes") {
		$result = mysqli_query($con,"SELECT * FROM `seats`;");
		$total = 0;
		$total_vote = 0;
		$votes = array();
		for($i = 0; $i < 5; $i++){
			$zone_string = "zone".($i + 1);
			$votes[$zone_string] = array();
			$votes[$zone_string]['total'] = 0;
			$votes[$zone_string]['votes'] = 0;
		}
		while($row = mysqli_fetch_array($result)) {
			$seat = $row['seat'];
			$vote = $row['vote'];
			$total++;
			if($vote != 0){
				$total_vote++;
			}
			$seat_group = $seat % 5;
			$zone_string = "zone".($seat_group + 1);
			$votes[$zone_string]['total']++;
			if($vote != 0){
				$votes[$zone_string]['votes']++;
			}
		}
		$final_votes = array();
		if($total_vote > 0) {
			$final_votes['total'] =  $total_vote / $total;
		} else {
			$final_votes['total'] = 0;
		}
		foreach($votes as $seat_group_name => $seat_group_array){
			if($seat_group_array['total'] != 0){
				$final_votes[$seat_group_name] = $seat_group_array['votes'] / $seat_group_array['total'];
			} else {
				$final_votes[$seat_group_name] = 0;
			}
		}
		echo json_encode(array("votes" => $final_votes));
	}
	if ($_GET['action'] == "setfrom") {
		$lat = (float)$_GET['lat'];
		$lon = (float)$_GET['lon'];
		$distance = distance($lat, $lon, $homeLat, $homeLon);
		$time = ($distance * 2) / 340;
		//$bering = bering($homeLat, $homeLon, $lat, $lon);
		mysqli_query($con,"INSERT INTO `youfrom` (time, pan) values(".$time.", 0);");
	}
	if ($_GET['action'] == "setseat") {
		$seat = intval($_GET['seat']);
		$enabled = intval($_GET['enabled']);
		mysqli_query($con,"INSERT INTO `seats` (seat, vote) values(".$seat.", ".$enabled.");");
	}
	if ($_GET['action'] == "removeseat") {
		$seat = intval($_GET['seat']);
		mysqli_query($con,"DELETE FROM `seats` WHERE seat = ".$seat.";");
	}
	//Clear Data
	//Simulator
}

//function bering($lat1, $lon1, $lat2, $lon2) {
//	return (rad2deg(atan2(sin(deg2rad($lon2) - deg2rad($lon1)) * cos(deg2rad($lat2)), cos(deg2rad($lat1)) * sin(deg2rad($lat2)) - sin(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon2) - deg2rad($lon1)))) + 360) % 360;
//}

function distance($lat1, $lng1, $lat2, $lng2) {
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;

	$r = 6372.797;
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;

	return $km;
}

?>
