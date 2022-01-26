<?php

Function ResponsiveButton($pdo, $CourseInd, $StudentInfoInd)
{

// Show a button for this listing, and make it a link if editing

		echo "<a id=\"ResponsiveCourseAdd\" class=\"ResponsiveButton\" href=\"UpdateUponSelect\">"
		 . "Add Course</a>";
}

function LookupDropConst($pdo, $ThingInd, $field)
{
        $query = "SELECT * FROM " . $field . " WHERE Ind=" . $ThingInd;
        $stmt = $pdo->prepare($query);
        $stmt->execute();
	$info = $stmt->fetch();

	return $info['Description'];
}

function DropConstOption($pdo, $ThingInd, $field, $data, $ExistingData, $Params = "")
{
       	switch ($field)
	{
		case "Course":
		$DisplayString = $data['Number'] . " (" . $data['Units'] . ") - " . $data['ShortTitle'];
		$DisplayValue = $data['Ind'];
		break;

		default:
	       	$DisplayString = $data['Description'];
	       	$DisplayValue = $data['Ind'];
		break;
	}

	$innerHTML = "";
	$innerHTML .= "<option value=\"" . $DisplayValue . "\"";

// Auto-select whatever the user already selected if an existing thing

	if (($ThingInd > 0) && ($ExistingData == $DisplayValue))
	       	$innerHTML .= " selected";

// If this is a new report, just auto-select the user's home airport

       	if ($ThingInd == 0)
		$innerHTML .= " selected";

	$innerHTML .= ">" . $DisplayString . "</option>\n";

	echo $innerHTML;
}

?>
