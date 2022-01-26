<?php

function UploadFile($TargetDir)
{
echo "<br><br><br><br><br><br><br><br>";

	$TargetFile = $TargetDir . basename($_FILES["FileToUpload"]["name"]);
	$uploadOk = 1;
//	$imageFileType = pathinfo($TargetFile,PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image
/*	if(isset($_POST["submit"]))
	{
		$check = getimagesize($_FILES["FileToUpload"]["tmp_name"]);
		if ($check !== false)
		{
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		}
		else
		{
			echo "<script>alert('File is not an image.');</script>";
			$uploadOk = 0;
		}
	}
*/

	// Check if file already exists
	if (file_exists($TargetFile))
	{
		echo "<script>alert('Sorry, file already exists.');</script>";
		$uploadOk = 0;
	}

	// Check file size
	if ($_FILES["FileToUpload"]["size"] > 512000000)
	{
		echo "<script>alert('Sorry, your file is too large. Please shrink your file to 512MB or less.');</script>";
		$uploadOk = 0;
	}

/*	// Allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	 && $imageFileType != "gif" )
	{
		echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');<script>";
		$uploadOk = 0;
	}
*/

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0)
	{
		echo "<script>alert('Sorry, your file was not uploaded.');</script>";

	// if everything is ok, try to upload file
	}
	else
	{
		if (move_uploaded_file($_FILES["FileToUpload"]["tmp_name"], $TargetFile))
		{
			echo "The file ". basename( $_FILES["FileToUpload"]["name"]). " has been uploaded.";
		}
		else
		{
			echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
		}
	}
}


function UploadFileSQL($Thing, $fn, $index, $isimg=0, $type = "img")
{
	echo "Starting Upload";
	$imageFileType = pathinfo($_FILES[$fn]["name"],PATHINFO_EXTENSION);
	$filename= $fn . $index .'.'. $imageFileType;
	$TargetFile = 'SQLThingFiles/'. $Thing . '/' .$filename;
	if ($type == "img_affil")
		$TargetFile = 'Images/'. $Thing . '/' .$filename;
	if ($type == "public")
		$TargetFile = '../SQLThingFiles/'. $Thing . '/' .$filename;
	$uploadOk = 1;

	echo $TargetFile;

	if($isimg==1){
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES[$fn]["tmp_name"]);
		if ($check !== false)
		{
			//echo "File is an image - " . $check["mime"] . ".";
			//$uploadOk = 1;
		}
		else
		{
			echo "<script>alert('File is not an image.');</script>";
			$uploadOk = 0;
		}
	}

	// Check file size
	if ($_FILES[$fn]["size"] > 512000000)
	{
		echo "<script>alert('Sorry, your file is too large. Please shrink your file to 512MB or less.');</script>";
		$uploadOk = 0;
	}

	if($isimg==1){
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		 && $imageFileType != "gif" )
		{
			echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');<script>";
			$uploadOk = 0;
		}
	}

		// Check if file already exists
	/*if (file_exists($TargetFile))
	{
		//unlink($TargetFile);
		echo "<script>alert('Sorry, file already exists.');</script>";
		$uploadOk = 0;
	}*/

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0)
	{
		echo "<script>alert('Sorry, your file was not uploaded.');</script>";

	// if everything is ok, try to upload file
	}
	else
	{
		if (move_uploaded_file($_FILES[$fn]["tmp_name"], $TargetFile))
		{
			echo "The file ". basename( $_FILES[$fn]["name"]). " has been uploaded.";
		}
		else
		{
			echo "<script>alert('Sorry, there was an error uploading your file ".basename( $_FILES[$fn]["name"])." as ".$TargetFile."');</script>";
			$uploadOk=0;
		}
	}

	if($uploadOk==1){
		return $filename;
	}else{
		return "";
	}
}

?> 
