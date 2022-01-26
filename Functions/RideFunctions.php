<?php

Function RideButton($pdo, $Ride, $ParentReport, $UserInfo, $Edit = 0)
{

// Only retrieve existing rides

	if ($Ride['RideInd'] > 0)
	{

// First, get the airport's information by Ride (RideAirport)

		$AirportQuery = "SELECT * FROM Airport WHERE AirportInd=" . $Ride['RideAirport'];
		$stmt = $pdo->prepare($AirportQuery);
		$stmt->execute();
		$AirportInfo = $stmt->fetch();
//		echo "Airport fetched<br>";

// Check this ride's route information to see if it's been scrobbled before or not.
// If so, just put the information in the button. If not, grab it from the 
// Google Maps code.

		if ($Ride['RideRoute'] != "")
		{
			if (($Ride['RideDistance'] == 0) || ($Ride['RideDistanceUnit'] == ""))
//			 || ($Ride['RideElevationUp'] == 0) || ($Ride['RideElevationDown'] == 0)
//			 || ($Ride['RideElevationUnit'] == ""))
			{

// Get the distance traveled in this ride by parsing the Google Maps code for it

				$GoogleMap = file_get_contents($Ride['RideRoute']);
				$pattern = "`[0-9]*\.[0-9] ((miles)|(km))`";	// Grab distance string
				preg_match($pattern, $GoogleMap, $matches);
//				print_r($matches);
				$MatchArray = explode(" ", $matches[0]);		// Split into number and unit
				$Ride['RideDistance'] = $MatchArray[0];
				$Ride['RideDistanceUnit'] = $MatchArray[1];
				$FixRideQuery = "UPDATE `Ride` SET `RideDistance`=" . $Ride['RideDistance'] . ","
				 . " `RideDistanceUnit`='" . $Ride['RideDistanceUnit'] . "'"
				 . " WHERE `RideInd`=" . $Ride['RideInd'];
				$FixRideStmt = $pdo->prepare($FixRideQuery);
				$FixRideStmt->execute();
			}
		}

// Show a button for this segment, and make it a link if editing

		echo "<a class=\"ResponsiveButton\" href=\"RideReport.php?RideInd="
		 . $Ride['RideInd'] . "\">"
		 . $AirportInfo['AirportCodeIATA'] . " (" . $Ride['RideDate'];
		if ($Ride['RideRoute'] != "")
			echo ", " . $Ride['RideDistance'] . " " . $Ride['RideDistanceUnit'];
		echo ")<br>"
		 . $Ride['RideName'] . "</a>";
	}

// Draw a button to create a new segment for a zero case

	if ($Ride['RideInd'] == 0)
	{
		echo "<a class=\"ResponsiveButton\" href=\"RideReport.php?RideInd=0&RideParentReport="
		 . $ParentReport . "&RideUserInd=" . $UserInfo['UserInd'] . "\">"
		 . "New Ride</a>";
	}
}

?>
