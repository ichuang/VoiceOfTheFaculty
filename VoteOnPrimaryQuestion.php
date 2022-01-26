<?php

	include('Include/Header.php');
	include('Functions/SegmentFunctions.php');

// Get the index of the human voting

	$HumanQuery = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
	$HumanStmt = $pdo->prepare($HumanQuery);
	$HumanStmt->execute();
	$HumanInfo = $HumanStmt->fetch();

// Put this human's vote into the system. There is a possibility that a hacker can inject someone else's hashed_eppn, but
// that would be very hard to guess so I'm not addressing it now.

// First check whether this human has voted yet. If so, destroy their old vote.

        $PrimaryVoteQuery = "SELECT * FROM PrimaryVotes WHERE Question='" . $_GET['Question'] . "' AND Human='" . $HumanInfo['Ind'] . "'";
        $PrimaryVoteStmt = $pdo->prepare($PrimaryVoteQuery);
        $PrimaryVoteStmt->execute();
        $PrimaryVoteInfo = $PrimaryVoteStmt->fetch();

	if ($PrimaryVoteStmt->rowCount() > 0)
	{
		$query1="DELETE FROM `PrimaryVotes` WHERE Ind=" . $PrimaryVoteInfo['Ind'];
	        $stmt = $pdo->prepare($query1);
	        $stmt->execute();
	}

//	print_r($PrimaryVoteInfo);
//	exit;

// Register the vote, even if it wasn't new, as a new vote.

	$query1="INSERT INTO `PrimaryVotes` (`Question`, `Human`, `Value`)"
	 . " VALUES (" . $_GET['Question'] . ", " . $HumanInfo['Ind'] . ", " . $_GET['Value'] . ")";
	$stmt = $pdo->prepare($query1);
	$stmt->execute();

	include('Include/Footer.php');

	echo("<script>location.href='ViewQuestions.php'</script>");

?>
