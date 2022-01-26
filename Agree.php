<?php

	include('Include/Header.php');

	echo "<table><tbody><tr><td style=\"width: 5px;\">";

	echo "</td></tr></tbody></table>";

// Welcome message and disclaimers

	echo "<center><div style=\"width: 960px;\">";

// Put the person in the student agreed list if they are a student

	if (isset($_SERVER['unscoped-affiliation']))
	{
		if (($_SERVER['unscoped-affiliation'] == "student") || ($DebugMode))
		{
			$query = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
		        $stmt = $pdo->prepare($query);
		        $stmt->execute();
		        $info = $stmt->fetch();

			if ($info['Ind'] == NULL)
			{
		                $ColumnQuery = "SELECT MAX(`Ind`)+1 FROM `Humans`";

		                $stmt = $pdo->prepare($ColumnQuery);
		                $stmt->execute();
		                $result = $stmt->fetch();
		                $Ind = array_shift($result);

				$query = "INSERT INTO Humans VALUES ('" . $Ind . "', '1', '" . hash("sha512", $_SERVER['eppn']) . "', '" . $_SERVER['unscoped-affiliation'] . "')";
		                $stmt = $pdo->prepare($query);
		                $stmt->execute();
				echo "Added to hashed database of student agreements.<br>";
				echo "Thank you for agreeing, your response has been recorded.<br>";
				echo "Please feel free to self report unit-hours.<br><br>";
			}
			else
			{
				echo "Already in the database, feel free to cruise on in.";
			}
		}
	}

	echo("<script>location.href='/Pulse/Home.php'</script>");

	echo "</div></center>";

	include('Include/Footer.php');

?>
