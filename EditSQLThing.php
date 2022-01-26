<?php

	include('Functions/SegmentFunctions.php');

	$Thing = $_GET['Thing'];
	if (isset($_GET['Ind']))
		$Ind = $_GET['Ind'];

// If the Thing ends in .php, trim that.

	if (substr($Thing, -4) == ".php")
	{
		$Thing = substr($Thing, 0, -4);
	}

	if (!ctype_alnum($Thing))
	{
		die ('Bad Thing!');	//invalid expression or injection
	}

	if (!isset($_GET['Ind']))
	{
		$Ind = "0";
	}

	if (!ctype_digit($Ind))
	{
		die ('Bad Ind!');	//invalid expression or injection
	}

	include('Include/Header.php');

// Grab the list of columns from the table labeled "<Thing>"

	$FieldArray = array();
	$ColumnQuery = "SHOW FULL COLUMNS FROM `" . $Thing . "`";
	$stmt = $pdo->prepare($ColumnQuery);
	$stmt->execute();
	$stmt->fetch();
	$DataType=array();
	$DataDesc=array();
	$DataDatabase=array();
	foreach ($stmt as $ColumnInfo)
	{
//		print_r($ColumnInfo);
		array_push($FieldArray, $ColumnInfo['Field']);
		$Comment = explode(':', $ColumnInfo['Comment']);
		$type = $Comment[0];
		if (isset($Comment[1])) $description = $Comment[1];
		$database = @$Comment[2];
		$DataType[$ColumnInfo['Field']]=$type;
		$DataDesc[$ColumnInfo['Field']]=$description;
		$DataDatabase[$ColumnInfo['Field']] = $database;
			//Type can be
		// txt - default to text input value, limit 256 characters
		// long - big textbox
		// date - date (not datetime)
// dropconst - drop down box with single value, linked to a database table
		// multi - drop down box with multiple values, linked to a database table
// hidden - create a hidden input value which scripts can change
		// file - file link
		// img - image link
		// img_affil - affiliation logo
		// ind - index - not editable, not displayed
		// ts - timestamp (last update) - not editable
	}

	if ($Ind != "0")
	{
		echo "<form action=\"ChangeSQLThing.php?Ind=" . $Ind
		 . "&Action=Update&Thing=" . $Thing . "\"";
	}
	if ($Ind == "0")
	{
		echo "<form action=\"ChangeSQLThing.php?Action=Add&Thing=" . $Thing . "\"";
//		 . "enctype=\"multipart/form-data\" method=\"post\">";
	}

	echo "enctype=\"multipart/form-data\" method=\"post\">";
echo "<center><div style=\"width: 960px; text-align: left;\">";

	echo "<table><tbody><tr><td class=\"FieldLabel\" colspan=\"2\">";
	echo "</td></tr>";

	// Display inputs for the fields

	$Query = "SELECT * FROM `" . $Thing . "` WHERE Ind=" . $Ind;
	$stmt2 = $pdo->prepare($Query);
	$stmt2->execute();
	$Data = $stmt2->fetch();

	foreach ($FieldArray as $field)
	{
		switch ($DataType[$field])
		{
			case "ind":	// Don't edit the index
				continue;
			break;

			case "date":
				echo "<tr class=\"RegularRow\"><td>" . $DataDesc[$field] . ": </td>";
				echo "<td><input name=\"" . $field . "\" class=\"DatePicker\" value=\""
				 . (($Data[$field] == 0) ? date('Y-m-d') : $Data[$field])
				 . "\" size=13 maxlength=10></td></tr>";
			break;

		       	case "dropconst":
				echo "<tr class=\"RegularRow\"><td>" . $DataDesc[$field] . ": </td><td>";

// Auto-populate a drop-down list from the chosen table

				$DropDownQuery = "SELECT * FROM `" . $DataDatabase[$field] . "` ORDER BY Description";
				$DropDownStmt = $pdo->prepare($DropDownQuery);
				$DropDownStmt->execute();

// Do another case/switch for which database it is, to choose the field(s) to display and keep as values

				echo "<select class=\"SingleSearchableDropDown\" name=\"" . $field . "\"";
				echo " id=\"" . $field . "\">\n";
//				echo "<option value=\"0\"></option>\n";

				foreach($DropDownStmt as $DropDownOption)
{
//					DropConstOption($pdo, ${$Thing . 'Ind'}, $DataDatabase[$field], $DropDownOption, $Data[$field]);
					DropConstOption($pdo, $Ind, $DataDatabase[$field], $DropDownOption, $Data[$field]);
				}

echo "</select>\n\n";

// Finally, select the correct value using jQuery to start if defined

				echo "<script>$(`#" . $field . "`).val(`" . (isset($Data[$field]) ? $Data[$field] : NULL) . "`);</script>";
				echo "<script>$(`#" . $field . "`).trigger(`change`);</script>";
			break;

			case "multi":
				echo "<tr class=\"RegularRow\"><td>" . $DataDesc[$field];
//				echo " (data: " . $Data[$field] . ")
				echo ": </td><td>";

// Auto-populate a multi-select drop-down list from the chosen table

			       	$DropDownQuery = "SELECT * FROM `" . $DataDatabase[$field] . "`";
				if (($DataDatabase[$field] == "Members") && ($field == "Authors"))
				{
					$DropDownQuery .= " ORDER BY FIELD(Ind, ";
					$auths = explode(',', $Data[$field]);
					array_pop($auths);
					array_shift($auths);
					foreach ($auths as $a)
					{
						$DropDownQuery .= $a . ", ";
					}
					$DropDownQuery .= "0)";
				}
			       	$DropDownStmt = $pdo->prepare($DropDownQuery);
			       	$DropDownStmt->execute();

// Do another case/switch for which database it is, to choose the field(s) to display and keep as values

				echo "<select class=\"MultipleSearchableDropDown\" style=\"width: 500px;\" id=\"" . $field
				 . "\" multiple=\"multiple\" name=\"" . $field . "[]\""
				 . " title=\"Please select " . $description . "\">\n";

				foreach ($DropDownStmt as $DropDownOption)
				{
//					DropConstOption($pdo, ${$Thing . 'Ind'}, $DataDatabase[$field], $DropDownOption, $Data[$field]);
					DropConstOption($pdo, $Ind, $DataDatabase[$field], $DropDownOption, $Data[$field]);
				}

				if ($Thing == "Members")
				{
					echo "<option value=\"-1\"";
					if (strstr($match, ",-1,") !== FALSE) echo " selected=\"selected\"";
					echo ">Hiring?</option>\n";
					echo "<option value=\"0\"";
					if (strstr($match, ",-1,") !== FALSE) echo " selected=\"selected\"";
					echo ">Nobody!</option>\n";
				}
				echo "</select>\n";

			break;
	
			case "hidden":
				switch ($field)
				{
					default:
						$DefaultValue = (isset($Data[$field]) ? $Data[$field] : (isset($_GET[$field]) ? $_GET[$field] : NULL));
					break;
				}
	
				echo "<input type=\"hidden\" id=\"" . $field . "\" name=\"" . $field . "\""
				 . " value=\"" . (isset($Data[$field]) ? $Data[$field] : $DefaultValue) . "\">\n";
			break;

			case "file":
				echo '<tr><td>'.$DataDesc[$field].": </td><td>";
				if($Data[$field]!="")
					echo "<a href=\"/Members/SQLThingFiles/" . $Thing . "/" . (isset($Data[$field]) ? $Data[$field] : NULL) . "\">" . (isset($Data[$field]) ? $Data[$field] : NULL) . "</a><br/>";
				echo "<input type=\"file\" name=\"".$field."\"></td></tr>";
			break;

			case "img":
				echo '<tr><td>'.$DataDesc[$field].": </td><td>";
				if($Data[$field]!="")
					echo "<img src=\"/Members/SQLThingFiles/" . $Thing . "/" . (isset($Data[$field]) ? $Data[$field] : NULL) . "\"><br/>";
				echo "<input type=\"file\" name=\"".$field."\">(only jpg or png or gif files)</td></tr>";
			break;

			case "img_affil":
				echo '<tr><td>'.$DataDesc[$field].": </td><td>";
				if($Data[$field]!="")
					echo "<img src=\"/Members/Images/" . $Thing . "/" . (isset($Data[$field]) ? $Data[$field] : NULL) . "\"><br/>";
				echo "<input type=\"file\" name=\"".$field."\">(only jpg or png or gif files)</td></tr>";
			break;

			case "txt":
			case "num":
				echo "<tr><td>" . $DataDesc[$field]  . ": </td>"
				 . "<td><input name=\"" . $field . "\" value=\"" . (isset($Data[$field]) ? $Data[$field] : NULL) . "\""
				 . " size=50 maxlength=100></td></tr>";
			break;

			case "autofill":
				echo "<tr><td style=\"width: 400px;\">" . $DataDesc[$field]  . ": </td>"
				 . "<td><input readonly=\"readonly\" name=\"" . $field . "\" value=\"" . $_SERVER[$DataDatabase[$field]] . "\""
				 . " size=20 maxlength=100></td></tr>";
			break;

			case "long":
				echo "<tr><td>" . $DataDesc[$field]  . ": </td>"
				 . "<td><textarea name=\"" . $field . "\" rows=\"5\" cols=\"40\" maxlength=65530>"
				 . (isset($Data[$field]) ? $Data[$field] : NULL) . "</textarea></td></tr>";
			break;

			default:
				echo "<tr><td style=\"width: 400px;\">" . $DataDesc[$field] . ": </td>"
				 . "<td style=\"width: 200px;\">" . (isset($Data[$field]) ? $Data[$field] : NULL) . "</td></tr>";
			break;
		}
	}

	if ($Ind != "0")
	{
		echo "<tr><td colspan=\"2\"><center><br><input style=\"font-weight: bold;\" type=\"submit\" "
		 . "value=\"Edit " . $Thing . "\"></form>&nbsp;&nbsp;&nbsp;<input type=\"button\" "
		 . "value=\"Cancel\" onclick=\"window.location = '/Pulse/Home.php';return true;\"></td></tr>";
		echo "</tbody></table>";
	}

	if ($Ind == "0")
	{
		echo "<tr><td colspan=\"2\"><center><br><input style=\"font-weight: bold;\" type=\"submit\" "
		 . "value=\"Create " . $Thing . "\"></form>&nbsp;&nbsp;&nbsp;<input type=\"button\" "
		 . "value=\"Cancel\" onclick=\"window.location = '/Pulse/Home.php';return true;\"></td></tr>";
		echo "</tbody></table>";
	}

	include('Include/Footer.php');
?>
