<?php
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
if ($_GET['action'] != null) {
	if ($_GET['action'] == "from") {
		echo $fromStr;
	}
	if ($_GET['action'] == "votes") {
		echo $votesStr;
	}
}
?>
