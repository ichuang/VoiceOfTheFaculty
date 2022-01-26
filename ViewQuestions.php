<?php

	include('Include/Header.php');
	include('Functions/SegmentFunctions.php');

	echo "<center><div style=\"width: 960px; text-align: left; padding-top: 20px;\">";

// First, get a list of all this student's current courses.

	$CurrentCourses = 0;				// Track number of courses
        echo "<center>Please be sure to check existing questions <i>before</i> writing a new one. "
         . "If you see a similar question, just give it a "
         . "<a id=\"FakePlusOne\" class=\"ResponsiveButton\" href=\"#\">+1</a>, a <a id=\"FakePlusOne\" class=\"ResponsiveButton\" href=\"#\">-1</a>, or an <a id=\"FakePlusOne\" class=\"ResponsiveButton\" href=\"#\">Abstain</a> and add a comment if you like. If not, then please submit a new one.<br><br></center>";

// Loop thorugh all this student's courses and show things about them.

        $QuestionQuery = "SELECT * FROM Questions ORDER BY QuestionStatus ASC, Date ASC";
        $QuestionStmt = $pdo->prepare($QuestionQuery);
        $QuestionStmt->execute();

	$CurrentQuestionStatus = 0;
	$CurrentQuestionNumber = 0;
	$QuestionStatusInfo['Description'] = "Unreleased";

	echo "<table class=\"QuestionTable\"><tbody>\n";
	echo "<th colspan=4>Unreleased Question(s) (Users Cannot See These)</th>";

// First display column headers

	echo "<tr><th style=\"width: 60px;\">&#8470;</th><th>Title (Click to Edit)</th><th>User Choices</th><th>Rate Question</th></tr>\n";

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

			echo "<th colspan=4>" . $QuestionStatusInfo['Description'] . " Question(s)</th>";
			echo "<tr><th style=\"width: 50px;\">&#8470;</th><th style=\"width: 500px;\">Title (Click to Edit)</th><th style=\"width: 350px;\">User Choices</th><th>Rate Question</th></tr>\n";

// Display this Question's information

		}

		$RowType = $QuestionStatusInfo['Description'] . "Row-" . (($CurrentQuestionNumber % 2) + 1);

// Figure out how many votes this Question has by a simple row count

                $QuestionVoteQuery = "SELECT * FROM PrimaryVotes WHERE Question=" . $Question['Ind'];
                $QuestionVoteStmt = $pdo->prepare($QuestionVoteQuery);
                $QuestionVoteStmt->execute();

		$CurrentScore = 0;
		foreach($QuestionVoteStmt as $Score)
		{
			$CurrentScore += $Score['Value'];
		}

// If this is an unreleased question, also get a new number summing up the total score

		echo "<tr class=\"" . $RowType . "\"><td>" . $Question['Ind'] . "</td>\n";
		echo "<td style=\"padding-left: 10px;\"><a id=\"TicketAdd\" class=\"ResponsiveButton\" href=\"EditSQLThing.php?Thing=Questions&Ind="
		 . $Question['Ind'] . "\"><span class=\"tooltip\" onmouseover=\"tooltip.pop(this, '" . $Question['Description'] . "')\">\n"
		 . $Question['Title'] . "</a> (" . $QuestionVoteStmt->rowCount() . " primary votes, score = " . $CurrentScore . ")</span></td>\n";

		echo "<td style=\"text-align: center;\">";

// Show the possible answers exactly as the users will see them.

		echo "<a id=\"ResponsivePlusOne\" class=\"ResponsiveButton\" "
		 . ">" . $Question['PlusOneString'] . "</a>";
		echo "<a id=\"ResponsiveMinusOne\" class=\"ResponsiveButton\" "
		 . ">" . $Question['MinusOneString'] . "</a>";
		echo "<a id=\"ResponsiveAbstain\" class=\"ResponsiveButton\" "
		 . ">Abstain</a>";

		echo "</td>";

// Check to see if this user already voted for this Question. If so, grey out the button.

// First, get this user's index based on their hashed_eppn.

                $HumanQuery = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
                $HumanStmt = $pdo->prepare($HumanQuery);
                $HumanStmt->execute();
		$HumanInfo = $HumanStmt->fetch();

// Then see if this human has already voted for this Question.

                $QuestionVoteQuery = "SELECT * FROM PrimaryVotes WHERE Question=" . $Question['Ind'] . " AND Human=" . $HumanInfo['Ind'];
                $QuestionVoteStmt = $pdo->prepare($QuestionVoteQuery);
                $QuestionVoteStmt->execute();
		$QuestionVoteInfo = $QuestionVoteStmt->fetch();

		echo "<td>";

		echo "<a id=\"ResponsivePlusOne\" class=\"" . ((($QuestionVoteInfo['Value'] == 1) && ($QuestionVoteStmt->rowCount() > 0)) ? "Selected" : "") . "ResponsiveButton\" "
		 . "href=\"VoteOnPrimaryQuestion.php?Question=" . $Question['Ind'] . "&Value=1\">+1</a>";
		echo "<a id=\"ResponsiveMinusOne\" class=\"" . ((($QuestionVoteInfo['Value'] == -1) && ($QuestionVoteStmt->rowCount() > 0)) ? "Selected" : "") . "ResponsiveButton\" "
		 . "href=\"VoteOnPrimaryQuestion.php?Question=" . $Question['Ind'] . "&Value=-1\">-1</a>";
		echo "<a id=\"ResponsiveAbstain\" class=\"" . ((($QuestionVoteInfo['Value'] == 0) && ($QuestionVoteStmt->rowCount() > 0)) ? "Selected" : "") . "ResponsiveButton\" "
		 . "href=\"VoteOnPrimaryQuestion.php?Question=" . $Question['Ind'] . "&Value=0\">Abstain</a>";

		echo "</td></tr>\n";
	}

// Next, add fields to add one question.

                echo "<tr><td colspan=5 style=\"text-align: center; padding-top: 20px;\">";

                echo "<a id=\"TicketAdd\" class=\"ResponsiveButton\" href=\"EditSQLThing.php?Thing=Questions\">"
                 . "Submit New Question</a>";

                echo "</td></tr>";

	echo "</tbody></table><br><br>\n\n";

	include('Include/Footer.php');

?>
