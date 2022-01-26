<?php

	include('Include/Header.php');
	include('Functions/SegmentFunctions.php');

	echo "<center><div style=\"width: 960px; text-align: left; padding-top: 20px;\">";

// First, get a list of all this student's current courses.

	$CurrentCourses = 0;				// Track number of courses

// Loop thorugh all this student's courses and show things about them.

        $QuestionQuery = "SELECT * FROM Questions WHERE QuestionStatus>0 ORDER BY QuestionStatus ASC, Date ASC";
        $QuestionStmt = $pdo->prepare($QuestionQuery);
        $QuestionStmt->execute();

	$CurrentQuestionStatus = 1;
	$CurrentQuestionNumber = 0;
	$QuestionStatusInfo['Description'] = "Featured";

	echo "<table class=\"QuestionTable\"><tbody>\n";
	echo "<th colspan=3>Featured Question(s)</th>";

// First display column headers

	echo "<tr><th style=\"width: 60px;\">&#8470;</th><th>Title</th><th>Your Vote</th><th></th></tr>\n";

	foreach($QuestionStmt as $Question)
	{
		$CurrentQuestionNumber++;

// Make a separate table for the three types of questions: Featured, Open, and Closed, in that order.

		$NewStatusFlag = 0;

		if ($Question['QuestionStatus'] != $CurrentQuestionStatus)
		{
			$NewStatusFlag = 1;
			$CurrentQuestionNumber = 0;
			$CurrentQuestionStatus = $Question['QuestionStatus'];

	                $QuestionStatusQuery = "SELECT * FROM QuestionStatus WHERE Ind='" . $CurrentQuestionStatus . "'";
	                $QuestionStatusStmt = $pdo->prepare($QuestionStatusQuery);
	                $QuestionStatusStmt->execute();
	                $QuestionStatusInfo = $QuestionStatusStmt->fetch();

			echo "</tbody></table><br><br>\n\n";
			echo "<table class=\"QuestionTable\"><tbody>\n";

// First display column headers

			echo "<th colspan=3>" . $QuestionStatusInfo['Description'] . " Question(s)</th>";
			echo "<tr><th style=\"width: 50px;\">&#8470;</th><th style=\"width: 500px;\">Title</th><th style=\"width: 350px;\">Your Vote</th></tr>\n";

// Display this Question's information

		}

		$RowType = $QuestionStatusInfo['Description'] . "Row-" . (($CurrentQuestionNumber % 2) + 1);

// Figure out how many votes this Question has by a simple row count

                $QuestionVoteQuery = "SELECT * FROM FinalVotes WHERE Question=" . $Question['Ind'];
                $QuestionVoteStmt = $pdo->prepare($QuestionVoteQuery);
                $QuestionVoteStmt->execute();

		echo "<tr class=\"" . $RowType . "\"><td>" . $Question['Ind'] . "</td>\n";
		echo "<td style=\"padding-left: 10px;\"><span class=\"tooltip\" onmouseover=\"tooltip.pop(this, '" . $Question['Description'] . "')\">\n"
		 . $Question['Title'] . " (" . $QuestionVoteStmt->rowCount() . " votes)</span></td>\n";

		echo "<td style=\"text-align: center;\">";

// Check to see if this user already voted for this Question. If so, grey out the button.

// First, get this user's index based on their hashed_eppn.

                $HumanQuery = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
                $HumanStmt = $pdo->prepare($HumanQuery);
                $HumanStmt->execute();
		$HumanInfo = $HumanStmt->fetch();

// Then see if this human has already voted for this Question.

                $QuestionVoteQuery = "SELECT * FROM FinalVotes WHERE Question=" . $Question['Ind'] . " AND Human=" . $HumanInfo['Ind'];
                $QuestionVoteStmt = $pdo->prepare($QuestionVoteQuery);
                $QuestionVoteStmt->execute();
		$QuestionVoteInfo = $QuestionVoteStmt->fetch();

		echo "<a id=\"ResponsivePlusOne\" class=\"" . ((($QuestionVoteInfo['Value'] == 1) && ($QuestionVoteStmt->rowCount() > 0)) ? "Selected" : "") . "ResponsiveButton\" "
		 . "href=\"VoteOnQuestion.php?Question=" . $Question['Ind'] . "&Value=1\">" . $Question['PlusOneString'] . "</a>";
		echo "<a id=\"ResponsiveMinusOne\" class=\"" . ((($QuestionVoteInfo['Value'] == -1) && ($QuestionVoteStmt->rowCount() > 0)) ? "Selected" : "") . "ResponsiveButton\" "
		 . "href=\"VoteOnQuestion.php?Question=" . $Question['Ind'] . "&Value=-1\">" . $Question['MinusOneString'] . "</a>";
		echo "<a id=\"ResponsiveAbstain\" class=\"" . ((($QuestionVoteInfo['Value'] == 0) && ($QuestionVoteStmt->rowCount() > 0)) ? "Selected" : "") . "ResponsiveButton\" "
		 . "href=\"VoteOnQuestion.php?Question=" . $Question['Ind'] . "&Value=0\">" . "Abstain</a>";

		echo "</td></tr>\n";
	}
	echo "</tbody></table><br><br>\n\n";

	include('Include/Footer.php');

?>
