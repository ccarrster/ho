<?php
$user = 'root';
$password = 'Ods4wPHZ35';
$db = 'mysql';
$con = mysqli_connect('127.0.0.1', $user, $password, $db);

$fromStr = '{
    "from": {
        "data": [
            {
                "time": 1.1,
                "pan": 0.4
            },
            {
                "time": 2.5,
                "pan": -0.4
            }
        ]
    }
}';
$votesStr = '{
	"votes": {
		"total": 0.3,
		"zone1": 0.0,
		"zone2": 0.1,
		"zone3": 0.7,
		"zone4": 0.2,
		"zone5": 1.0,
		"zone6": 0.3,
		"zone7": 0.5,
		"zone8": 0.2,
		"zone9": 0.1,
		"zone10": 0.1
	}
}';

$homeLat = 43.454308;
$homeLon = -80.48386;

if ($_GET['action'] != null) {
	if ($_GET['action'] == "from") {
		echo $fromStr;
		/*
		$result = mysqli_query($con,"SELECT * FROM `youfrom`;");
		while($row = mysqli_fetch_array($result)) {
			$time = $row['time'];
			$pan = $row['pan'];
			json_encode($thing);
			echo $time;
			echo $pan;
		}
		*/
	}
	if ($_GET['action'] == "votes") {
		echo $votesStr;
		/*
		$result = mysqli_query($con,"SELECT * FROM `seats`;");
		while($row = mysqli_fetch_array($result)) {
			$seat = $row['seat'];
			$vote = $row['vote'];
			echo $seat;
			echo $vote;
		}
		*/
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
