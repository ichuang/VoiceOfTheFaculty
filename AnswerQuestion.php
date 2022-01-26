<?php

	include('Include/Header.php');
	include('Functions/SegmentFunctions.php');

// Loop thorugh all this student's courses and show things about them.

	$QuestionQuery = "SELECT * FROM Questions WHERE Ind=" . $_GET['Question'];
	$QuestionStmt = $pdo->prepare($QuestionQuery);
	$QuestionStmt->execute();
	$Question = $QuestionStmt->fetch();

//	$UpdateQuery = "UPDATE Questions SET Points=" . ($Question['Points'] + 1) . " WHERE Ind=" . $_GET['Question'];
//	$UpdateStmt = $pdo->prepare($UpdateQuery);
//	$UpdateStmt->execute();

	$HumanQuery = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
	$HumanStmt = $pdo->prepare($HumanQuery);
	$HumanStmt->execute();
	$HumanInfo = $HumanStmt->fetch();

	$query1="INSERT INTO `Votes` (`Question`, `Human`) VALUES (" . $Question['Ind'] . ", " . $HumanInfo['Ind'] . ")";
	$stmt = $pdo->prepare($query1);
	$stmt->execute();

	include('Include/Footer.php');

	echo("<script>location.href='Home.php'</script>");

?>
