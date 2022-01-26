<?php

	include('Include/Header.php');
	include('Functions/SegmentFunctions.php');

	echo "<center><div style=\"width: 960px; text-align: left; padding-top: 20px;\">";

// Loop thorugh all this student's courses and show things about them.

	$TestQuestionInd = 2;

	$QuestionQuery = "SELECT * FROM Questions WHERE Ind=" . $TestQuestionInd;
	$QuestionStmt = $pdo->prepare($QuestionQuery);
	$QuestionStmt->execute();
	$QuestionInfo = $QuestionStmt->fetch();

	echo $QuestionInfo['Title'] . "<br><br>";

	echo $QuestionInfo['Description'] . "<br><br>";

// Figure out how many votes this Question has by a simple row count

	$QuestionVoteQuery = "SELECT * FROM FinalVotes WHERE Question=" . $QuestionInfo['Ind'];
	$QuestionVoteStmt = $pdo->prepare($QuestionVoteQuery);
	$QuestionVoteStmt->execute();
	echo "Results so far: ";
	$YesVotes = 0;
	$NoVotes = 0;
	foreach ($QuestionVoteStmt as $QuestionVote)
	{
		if ($QuestionVote['Value'] == 1)
			$YesVotes++;
		if ($QuestionVote['Value'] == 0)
			$NoVotes++;
	}
	echo $YesVotes . " Yes, " . $NoVotes . " No<br><br>";

// Check to see if this user already voted for this Question. If so, grey out the button.

// First, get this user's index based on their hashed_eppn.

	$HumanQuery = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
	$HumanStmt = $pdo->prepare($HumanQuery);
	$HumanStmt->execute();
	$HumanInfo = $HumanStmt->fetch();

// Then see if this human has already voted for this Question.

	$QuestionVoteQuery = "SELECT * FROM FinalVotes WHERE Question=" . $QuestionInfo['Ind'] . " AND Human=" . $HumanInfo['Ind'];
	$QuestionVoteStmt = $pdo->prepare($QuestionVoteQuery);
	$QuestionVoteStmt->execute();

			if ($QuestionVoteStmt->rowCount() <= 0)		// If a user-Question vote was found
			{
				echo "<a id=\"ResponsivePlusOne\" class=\"ResponsiveButton\" "
				 . "href=\"VoteOnQuestion.php?Question=" . $QuestionInfo['Ind'] . "&Value=1\">" . "Yes</a> ";
				echo "<a id=\"ResponsivePlusOne\" class=\"ResponsiveButton\" "
				 . "href=\"VoteOnQuestion.php?Question=" . $QuestionInfo['Ind'] . "&Value=1\">" . "No</a><br><br>";
			}
			else
			{
				echo "Your vote for this question has already been recorded.<br><br>";
			}

	include('Include/Footer.php');

?>
