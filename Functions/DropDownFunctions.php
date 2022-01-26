<?php

function DropConstOption($pdo, $ThingInd, $field, $data, $ExistingData, $Params = "")
{
       	switch ($field)
	{
		case "Members":
		$DisplayString = $data['Last'] . ", " . $data['First'];
		$DisplayValue = $data['Ind'];
		break;

		case "Funding":
		$DisplayString = $data['Program'];
		$DisplayValue = $data['Ind'];
		break;

		case "Journals":
		$DisplayString = $data['Abbreviation'] . " (" . $data['Name'] . ")";
		$DisplayValue = $data['Ind'];
		break;

		case "Projects":
		$DisplayString = $data['ShortTitle'];
		$DisplayValue = $data['Ind'];
		break;

		case "Affiliations":
		$DisplayString = $data['Acronym'] . " - " . $data['Institution'];
		$DisplayValue = $data['Ind'];
		break;

		case "PubStatus":
		$DisplayString = $data['Name'];
		$DisplayValue = $data['Name'];
		break;

		default:
		break;
	}

	$innerHTML = "";
	$innerHTML .= "<option value=\"" . $DisplayValue . "\"";

// Auto-select whatever the user already selected if an existing thing

	if (($data['Ind'] > 0) && ($ExistingData == $DisplayValue))
	       	$innerHTML .= " selected";

	if (strstr($ExistingData, "," . $DisplayValue . ",") !== FALSE)
	       	$innerHTML .= " selected=\"selected\"";

	$innerHTML .= ">" . $DisplayString . "</option>\n";

	echo $innerHTML;
}


?>
