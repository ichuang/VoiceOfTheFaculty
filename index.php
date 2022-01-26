<?php

	include('Include/Header.php');

	echo "<table><tbody><tr><td style=\"width: 5px;\">";

	echo "</td></tr></tbody></table>";

// Welcome message and disclaimers

	echo "<center><div style=\"width: 960px; text-align: left;\">";

	echo "Please scroll down, read everything, and click \"I Agree\" to continue.<br><br>";

	echo "<b>Legal Warning:</b> This tool is not <i>currently</i> controlled or managed by MIT.<br><br>";

	echo "<b>Purpose of This Site:</b> Perform rapid, single question climate surveys on issues raised by a "
	 . "representative group of faculty, students, and staff, and share the pulse of the community!<br><br>";

	echo "<b>Access:</b> We use <a href=\"https://kb.mit.edu/confluence/pages/viewpage.action?pageId=3908944\">"
         . "MIT Certificates</a> to authenticate users, ensuring that (1) it's just MIT people helping, and (2) that "
	 . "each person can only upvote each idea once.<br><br>";

	echo "<b>Privacy - What Is Recorded?</b> Only a <a href=\"https://privacycanada.net/hash-functions/why-are-hashes-irreversible/\">non-reversible</a> "
	 . "<a href=\"https://www.educative.io/edpresso/what-is-hashing\">hash</a> of your MIT email address, your affiliation (student or staff, the latter of which includes faculty), and what you vote for, "
	 . "linked to this non-reversible hash. We cannot reconstruct who voted for what. "
	 . "<a href=\"https://kb.mit.edu/confluence/pages/viewpage.action?pageId=3908944\">"
	 . "MIT Certificates</a> are used to ensure security. No other data is recorded for privacy reasons.<br><br>";

	echo "By clicking the button below, you agree to use this site as stipulated above."
	 . " Clicking the button will also record that you have read and understood what is written above.<br><br>";

	echo "<center><a class=\"ResponsiveButton\" href=\"Agree.php\">I Agree</a></center>";

	echo "</div></center>";

	include('Include/Footer.php');

?>
