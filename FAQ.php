<?php

	include('Include/Header.php');

	echo "<center><div style=\"width: 960px; text-align: left; padding-top: 20px;\">";

	echo "<ul>";
	echo "<li><a href=\"#WhatFor\">What is the purpose of this site?</a>";
	echo "<li><a href=\"#Phones\">Does this site work on phones (iOS, Android)?</a>";
	echo "<li><a href=\"#Bugs\">I found a bug. How do I report it?</a>";
	echo "<li><a href=\"#Certificates\">Why do we need MIT certificates to use this?</a>";
	echo "<li><a href=\"#Data\">Speaking of collecting data, what/how much are you collecting?</a>";
	echo "<li><a href=\"#NoComment\">Why can't I leave comments on a question?</a>";
	echo "<li><a href=\"#Committee\">Who chooses which questions to ask, and how?</a>";
	echo "<li><a href=\"#Privacy\">Don't you get all my private information through my MIT certificate?</a>";
	echo "<li><a href=\"#DataUse\">How will my data be used? Who can see it?</a>";

	echo "</ul>";

	echo "<a id=\"WhatFor\"></a><b>What is the purpose of this site?</b><br>";
	echo "<i>The purpose of this site is to create a zero-barrier way to quickly take the pulse of MIT on community-sourced questions affecting us. The answers will also help guide the administration in crafting policies and communications with the full voice and wishes of the community, not just the subset whose opinions are uptaken via other means. This allows everyone a one-click mechanism to have an equal say on what is important to them!</i><br><br>";

	echo "<a id=\"Phones\"></a><b>Does this site work on phones (iOS, Android)?</b><br>";
	echo "<i>It should, as I cloned this from another site confirmed to work on multiple versions of both iOS and Android. The CSS is optimized for mobile too.</i><br><br>";

	echo "<a id=\"Bugs\"></a><b>I found a bug. How do I report it?</b></br>";
	echo "<i>Submit a screenshot and description to <a href=\"mailto: hereiam@mit.edu\">hereiam@mit.edu</a>. Response times may vary, I both sleep 8 hours a night and have a 6-year old. Will do my best during this crazy time to respond quickly.</i><br><br>";

	echo "<a id=\"Certificates\"></a><b>Why do we need MIT certificates to use this?</b><br>";
	echo "<i>That's how we know you're an MIT community member, and specifically a student or staff member (including faculty) for questions where we want to differentiate responses. Keeps the scam bots and other human members of the public out. Also lets us absolutely minimize data collected.</i><br><br>";

	echo "<a id=\"Data\"></a><b>Speaking of collecting data, what/how much are you collecting?</b><br>";
	echo "<i>Only a <a href=\"https://privacycanada.net/hash-functions/why-are-hashes-irreversible/\">non-reversible</a> "
         . "<a href=\"https://www.educative.io/edpresso/what-is-hashing\">hash</a> of your MIT email address, a binary yes/no if you clicked the \"I Agree\" button, and your anonymized idea votes. Nothing else. We collect hash-tagged votes to make sure one person can only vote for each idea once.</i><br><br>";

	echo "<a id=\"NoComment\"></a><b>Why can't I leave comments on a question??</b><br>";
	echo "<i>This tool is meant to be a <b>very</b> fast way to get the pulse of MIT on specific questions. "
	 . "It is not meant to be a forum or message board. You can debate the questions with your colleagues, and you can change your vote at any time.</i><br><br>";

	echo "<a id=\"Committee\"></a><b>Who chooses which questions to ask, and how?</b><br>";
	echo "<i>A grassroots, self-assembled committee of faculty, staff, and students, equally represented, brainstorms the questions. They then "
	 . "debate which question(s) are most pressing, and each week a few questions are sent to <a href=\"https://ir.mit.edu/\">Institutional Research</a>, "
	 . "where specialists in posing questions correctly to obtain the desired data help us to rephrase them free of bias and skew. Then they are "
	 . "released on a regular schedule, with notifications sent out to those who opt in to receive them.</i><br><br>";

	echo "<a id=\"Privacy\"></a><b>Don't you get all my private information through my MIT certificate?</b><br>";
	echo "<i>Nope. MIT certificates do not work that way. <a href=\"https://web.mit.edu/touchstone/www/applications.html\">Behold!</a></i><br><br>";

        echo "<a id=\"DataUse\"></a><b>How will my data be used? Who can see it?</b><br>";
	echo "<i>We don't collect any usage data, at all. Ideas and votes are linked to hashes of your Kerberos ID, and we can't unhash those.</i><br><br>";

// Welcome message and disclaimers

        echo "<b>WARNING:</b> This tool is not controlled or managed by MIT (I'm working on that). I hope that by making this exist, it will be woven into the weekly fabric of MIT life.<br><br>";

	include('Include/Footer.php');

?>
