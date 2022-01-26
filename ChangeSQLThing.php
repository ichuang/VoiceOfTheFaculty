<?php
	include('Include/Header.php');
	include('/var/www/html/Functions/UploadFile.php');

// The script will get four parameters through GET: 'Ind,' 'Type,' 'JumpLink,' and 'Action.'

	$Thing = $_GET['Thing'];

// If the Thing ends in .php, trim that.

        if (substr($Thing, -4) == ".php")
        {
                $Thing = substr($Thing, 0, -4);
        }

	if(!ctype_alnum($Thing)){
		die('Bad Thing!');//invalid expression or injection
	}

	$Action = $_GET['Action'];

	$FieldArray = array();
	$ColumnQuery = "SHOW FULL COLUMNS FROM `" . $Thing . "`";

        $stmt = $pdo->prepare($ColumnQuery);
        $stmt->execute();
        $stmt->fetch();
        $DataType=array();
        $DataDesc=array();
//	print_r($_POST);
        foreach ($stmt as $ColumnInfo)
	{
		array_push($FieldArray, $ColumnInfo['Field']);
		list($type, $description)=explode(':',$ColumnInfo['Comment']);
		$DataType[$ColumnInfo['Field']]=$type;
		$DataDesc[$ColumnInfo['Field']]=$description;
			//Type can be
		// txt - default to text input value, limit 256 characters
		// long - big textbox
		// date - date (not datetime)
		// file - file link
		// img - image link
		// img_affil - affiliation logo
		// ghs - ghs symbols
		// ind - index - not editable, not displayed
		// ts - timestamp (last update) - not editable
	}

	if($Action=="Update"){
		$Ind = $_GET['Ind'];
		$query1="UPDATE `" . $Thing . "` SET ";

		if(!ctype_digit($Ind)){
			die('Bad Ind!');//invalid expression or injection
		}
		echo "Starting update";

		foreach ($FieldArray as $field){
			switch($DataType[$field]){
				case "txt":
				case "autofill":
				case "long":
				case "hidden":
				case "date":
                                case "dropconst":
                                        if(!isset($_POST[$field]))
                                                continue;
                                        $txt=substr($_POST[$field],0,250);
                                        $query1 .= '`'.$field . "`=\"" . addslashes($txt) . "\", ";
                                break;

                                case "num":
                                        if(!isset($_POST[$field]))
                                                continue;
                                        $txt=substr($_POST[$field],0,250);
					$txt = preg_replace("/[^0-9.]/", "", $txt );     // Strip out non-numerics
                                        $query1 .= '`'.$field . "`=\"" . addslashes($txt) . "\", ";
                                break;

				case "ghs":
                                case "multi":
                                        if(!isset($_POST[$field]))
                                                continue;
                                        $txt = "," . implode(",", $_POST[$field]) . ",";
                                        $query1 .= '`'.$field . "`=\"" . addslashes($txt) . "\", ";
                                break;

				case "file":
					if(!isset($_FILES[$field]))
						continue;
					if (basename($_FILES[$field]["name"]) == "")
						continue;
					$f=UploadFileSQL($Thing, $field, $Ind);
					if($f=="")
						continue;
					$query1 .= '`'.$field . "`=\"" . addslashes($f) . "\", ";
				break;

				case "img":
				case "img_affil":
					if(!isset($_FILES[$field]))
						continue;
					if (basename($_FILES[$field]["name"]) == "")
						continue;
					$f=UploadFileSQL($Thing, $field, $Ind, 1, $DataType[$field]);
					if($f=="")
						continue;
					$query1 .= '`'.$field . "`=\"" . addslashes($f) . "\", ";
				break;

				default:
					continue;
				break;
			}
		}
		$query1 = substr($query1, 0, -2);
		$query1 .= " WHERE `Ind`=" . $Ind;
                $stmt = $pdo->prepare($query1);
                $stmt->execute();
	}

    if ($Action == "Add"){
		$ColumnQuery = "SELECT MAX(`Ind`)+1 FROM `" . $Thing."`";

	        $stmt = $pdo->prepare($ColumnQuery);
	        $stmt->execute();
	        $result = $stmt->fetch();
		$Ind = array_shift($result);

		$query1="INSERT INTO `" . $Thing . "` (";
		$values1=") VALUES (";

		foreach ($FieldArray as $field){
			switch($DataType[$field]){
				case "ind"://don't edit index
					continue;
				break;

				case "ghs":
				case "multi":
					if(!isset($_POST[$field]))
						continue;
					$txt = "," . implode(',',$_POST[$field]) . ",";
					$query1 .= '`'.$field . "`, ";
					$values1 .= '"'.addslashes($txt).'", ';
				break;

				case "file":
					if(!isset($_FILES[$field]['tmp_name']))
					{
						echo "No filename for some reason.";
						continue;
					}
					if (basename($_FILES[$field]["name"]) == "")
					{
						echo "No base filename for some reason.";
						continue;
					}
					$f=UploadFileSQL($Thing, $field, $Ind);
					if($f=="")
					{
						echo "No file pointer made.";
						continue;
					}
					$query1 .= '`'.$field . "`, ";echo $query1 . "\n";
					$values1 .= '"'.addslashes($f).'", ';echo $values1 . "\n";
				break;

				case "img":
				case "img_affil":
					if(!isset($_FILES[$field]['tmp_name']))
						continue;
					if (basename($_FILES[$field]["name"]) == "")
						continue;
					$f=UploadFileSQL($Thing, $field, $Ind, 1, $DataType[$field]);
					if($f=="")
						continue;
					$query1 .= '`'.$field . "`, ";
					$values1 .= '"'.addslashes($f).'", ';
				break;

				case "txt":
				case "autofill":
				case "long":
				case "hidden":
				case "date":
				case "dropconst":
					if(!isset($_POST[$field]))
						continue;
					$txt=substr($_POST[$field],0,250);
					$query1 .= '`'.$field . "`, ";
					$values1 .= '"'.addslashes($txt).'", ';
				break;

				case "num":
					if(!isset($_POST[$field]))
						continue;
					$txt=substr($_POST[$field],0,250);
					$txt = preg_replace("/[^0-9.]/", "", $txt );	// Strip out non-numerics
					$query1 .= '`'.$field . "`, ";
					$values1 .= '"'.addslashes($txt).'", ';
				break;

				default:
					continue;
				break;
			}
		}
		$query1 = substr($query1, 0, -2);
		$values1 = substr($values1, 0, -2);
//		echo $query1.$values1.")"; exit;
                $stmt = $pdo->prepare($query1.$values1.")");
                $stmt->execute();
//		$result_add = QueryResult($query1.$values1.")") or die ("Failed column query of " . $query1.$values1.")");
	}

	if ($Action == "Delete")
	{
	    $Ind = $_GET['Ind'];

		if(!ctype_digit($Ind)){
			die('Bad Ind!');//invalid expression or injection
		}

		$Query = "SELECT * FROM `" . $Thing . "` WHERE Ind=" . $Ind;
                $stmt = $pdo->prepare($Query);
                $stmt->execute();
		$Data = $stmt->fetch();

		foreach ($FieldArray as $field){
			switch($DataType[$field]){
				case "file":
					$fn='SQLThingFiles/'.$Thing.'/'.$Data[$field];
					if (file_exists($fn))
					{
						unlink($fn);
					}
				break;
				case "img":
					$fn='SQLThingFiles/'.$Thing.'/'.$Data[$field];
					if (file_exists($fn))
					{
						unlink($fn);
					}
				break;
				case "img_affil":
					$fn='Images/'.$Thing.'/'.$Data[$field];
					if (file_exists($fn))
					{
						unlink($fn);
					}
				break;
				default:
					continue;
				break;
			}
		}

		$query1="DELETE FROM `" . $Thing . "` WHERE Ind=" . $Ind;
                $stmt = $pdo->prepare($query1);
                $stmt->execute();
//		$result_del = QueryResult($query1) or die("Failed column query of " . $query1);
	}

	echo("<script>location.href='/Pulse/ViewQuestions.php'</script>");

?>
