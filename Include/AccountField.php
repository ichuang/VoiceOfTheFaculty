<?php

	function AccountField($FieldName, $Text = "Fill me in, idiot!", $UserInfo, $PostText = "", $Align = "left", $Width = "300px")
	{
		echo "<tr><td class=\"FieldLabel\">" . $Text;
		echo "</td><td style=\"width: 350px;\">";
		if (!strstr($FieldName, "DOB"))
		{
			echo "<input ";
			if (strstr($FieldName, "Password")) echo " type=\"password\"";
			echo "name=\"" . $FieldName . "\" style=\"width: " . $Width
				 . "; text-align: " . $Align . ";\"  value=\"" . $UserInfo[$FieldName]
				 . "\">" . $PostText . "</td>";
		}
		else
		{
			$myCalendar = new tc_calendar($FieldName, true, false);
			  $myCalendar->setIcon(".Images/iconCalendar.gif");
			  $myCalendar->setPath(".");
			  $myCalendar->setDateFormat("F d, Y");
			  $myCalendar->setDateYMD($UserInfo[$FieldName]);
			  $myCalendar->setYearInterval(1800, 2020);
			  $myCalendar->writeScript();
			echo "</td>";
		}
		echo "<td class=\"WarningMessage\">"
		 . (isset($_POST[$FieldName . 'Message']) ? $_POST[$FieldName . 'Message'] : "")
		 . "</td></tr>";
	}

	function AccountTextarea($FieldName, $Text = "Fill me in, idiot!", $UserInfo, $PostText = "", $Rows = 3, $Cols = 40)
	{
		echo "<tr><td class=\"FieldLabel\">" . $Text;
		echo "</td><td style=\"width: 350px;\">";
		echo "<textarea rows=" . $Rows . " cols=" . $Cols . " ";
		echo "name=\"" . $FieldName . "\">" . $UserInfo[$FieldName]
			 . "</textarea>" . $PostText . "</td>";
		echo "<td class=\"WarningMessage\">"
		 . (isset($_POST[$FieldName . 'Message']) ? $_POST[$FieldName . 'Message'] : "")
		 . "</td></tr>";
	}
?>
