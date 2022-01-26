<?php

function GetTripStats($pdo, $UserInd)
{

// Get accumulated stats for this user, or all other users

	$StatQuery = "SELECT * FROM TripReport";
	if ($UserInd > 1)
		$StatQuery .= " WHERE TripReportUserInd=" . $UserInd;
	$stmt = $pdo->prepare($StatQuery);
        $stmt->execute();
	$Trips = $stmt->rowCount();

	$StatQuery = "SELECT * FROM Segment";
	if ($UserInd > 1)
		$StatQuery .= " WHERE SegmentUserInd=" . $UserInd;
	$stmt = $pdo->prepare($StatQuery);
        $stmt->execute();
	$Segments = $stmt->rowCount();

	echo ($UserInd > 1 ? "You" : "Users") . " have successfully completed " . $Trips . " folding bike trips with " . $Segments . " segments.<br><br>\n";

// Accumulate average trip ratings

	$SegmentGateFriendliness = 0;
	$SegmentCrewFriendliness = 0;
	$SegmentPassengerFriendliness = 0;
	$SegmentGateCounter = 0;
	$SegmentCrewCounter = 0;
	$SegmentPassengerCounter = 0;

	foreach($stmt as $Experience)
	{
		if ($Experience['SegmentGateFriendliness'] > 0)
		{
			$SegmentGateFriendliness += $Experience['SegmentGateFriendliness'];
			$SegmentGateCounter++;
		}
		if ($Experience['SegmentCrewFriendliness'] > 0)
		{
			$SegmentCrewFriendliness += $Experience['SegmentCrewFriendliness'];
			$SegmentCrewCounter++;
		}
		if ($Experience['SegmentPassengerFriendliness'] > 0)
		{
			$SegmentPassengerFriendliness += $Experience['SegmentPassengerFriendliness'];
			$SegmentPassengerCounter++;
		}
	}

	$SegmentGateFriendliness /= $SegmentGateCounter;
	$SegmentCrewFriendliness /= $SegmentCrewCounter;
	$SegmentPassengerFriendliness /= $SegmentPassengerCounter;

	$SegmentGateFriendliness = round($SegmentGateFriendliness, 1);
	$SegmentCrewFriendliness = round($SegmentCrewFriendliness, 1);
	$SegmentPassengerFriendliness = round($SegmentPassengerFriendliness, 1);

	echo "Average segment bike friendliness ratings:<br><br>\n";
	echo "Departure Airport: " . $SegmentGateFriendliness . "/5<br>\n";
	echo "Flight Crew: " . $SegmentCrewFriendliness . "/5<br>\n";
	echo "Fellow Passengers: " . $SegmentPassengerFriendliness . "/5<br><br>\n";
}

?>
