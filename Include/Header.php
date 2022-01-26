<?php

	$DebugMode = 1;
	include("Constants.php");

// Start by recording page load start time

	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;

// Block facebook crawlers

$ua = $_SERVER['HTTP_USER_AGENT'];

	if (strpos('facebook', $ua))
{
header('Location: no_fb_page.php');
die();
}

 ini_set('display_errors',1);
 error_reporting(E_ALL);

// New PDO connection method

	$host = "localhost";
	$db   = "Pulse";
	$user = "hereiam";
	$pass = "M\$Estro7";
	$charset = "utf8";

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
	    PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// Record the MySQL connection establishment end time, and report it

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$pdo_time = round(($finish - $start), 4);
//echo "Header generated in " . $total_time . " seconds.";


?>

<!DOCTYPE html>
<html>
<head>

                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">

<title>The Pulse of MIT</title>
<meta name="robots" content="index">

<meta http-equiv="X-UA-Compatible" content="chrome=1, IE=edge">

<script type="text/javascript" src="/Pulse/Scripts/ImagereadyPreload.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.css" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.js"></script>

<link rel="stylesheet" type="text/css" href="/Pulse/Styles/jquery.asmselect.css">
<script type="text/javascript" src="/Pulse/Scripts/jquery.asmselect.js"></script>

<link rel="stylesheet" type="text/css" href="/Pulse/Styles/tooltip.css">
<script type="text/javascript" src="/Pulse/Scripts/tooltip.js"></script>

<link href="/Pulse/Styles/jquery.nice-number.css" rel="stylesheet">
<script src="/Pulse/Scripts/jquery.nice-number.js"></script>

<link rel="stylesheet" type="text/css" href="/Pulse/Scripts/semantic/semantic.min.css">
<script src="/Pulse/Scripts/semantic/semantic.min.js"></script>

<script src="/Pulse/Scripts/Highcharts-8.2.0/code/highcharts.js"></script>
<script src="/Pulse/Scripts/Highcharts-8.2.0/code/modules/series-label.js"></script>
<script src="/Pulse/Scripts/Highcharts-8.2.0/code/modules/exporting.js"></script>
<script src="/Pulse/Scripts/Highcharts-8.2.0/code/modules/export-data.js"></script>
<script src="/Pulse/Scripts/Highcharts-8.2.0/code/modules/accessibility.js"></script>

                <style type="text/css">
.highcharts-figure, .highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
    min-height: 300px;
}

.highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
	height: 100%;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
        font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

                </style>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

<script type="text/javascript">

$(document).ready(function() {
$("select[multiple]").asmSelect({
addItemTarget: 'bottom',
animate: true,
highlight: true,
sortable: true
});
			$(function(){
				$('input[type="number"]').niceNumber();
			});
			$('.SingleSearchableDropDown').select2({
				width: 700
			});
			$('.BigSingleSearchableDropDown').select2({
				minimumInputLength: 3,
				width: 700
			});

// Experimental week picker thing

});
$(function() {
    var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    $('.week-picker').datepicker( {
        showOtherMonths: true,
        selectOtherMonths: true,
	maxDate: 0,
	minDate: new Date(2021, 2 - 1, 15),
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#startDate').text($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
            $('#endDate').text($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
		$('#BlockReport').css("display", "none");
		$('#SubmitReport').css("display", "block");
		$('#Week').val($('#startDate').text());
            
            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });
    
});
</script>

<link href="/Pulse/Styles/Styles.css" rel="stylesheet" type="text/css">

</head>

<?php
ob_start()
?>

<body>

<div id="dek"></div>
<script type="text/javascript" src="/Scripts/Mouseover.js"></script>

<table id="MainPage"><tr class="TopNavRow">

<?php

// Get the student info, specifically if they're in the database yet.

$query="SELECT * FROM Humans WHERE hashed_eppn='" . (isset($_SERVER['eppn']) ? hash("sha512", $_SERVER['eppn']) : "blank") . "'";
$stmt = $pdo->prepare($query);
$stmt->execute();
$info = $stmt->fetch();

// Display the links at the top of the page

	echo "<td class=\"TopNavCell\">";
	echo "<span class=\"TopNavLinks\">";
	echo "The Pulse of MIT<br>";
	echo "<i><small>Make your voice heard on community-wide issues, securely and privately</small></i>";
	$CurrentURL = $_SERVER["SCRIPT_NAME"];

	if (!strpos($CurrentURL, "index.php"))
	{

// Look up the current Human, and see if they have any courses selected yet.

// First, look up the current certificate-authenticated Human by the hash of their eppn

		$HumanQuery = "SELECT * FROM Humans WHERE hashed_eppn='" . hash("sha512", $_SERVER['eppn']) . "'";
		$HumanStmt = $pdo->prepare($HumanQuery);
		$HumanStmt->execute();
		$HumanInfo = $HumanStmt->fetch();

		if ($info['Ind'] != NULL)
		{
			echo "<br><a href=\"/Pulse/Home.php\" class=\"TopLink\">Home</a>";
			echo "<a href=\"/Pulse/FAQ.php\" class=\"TopLink\">FAQ</a>";
			echo "<div class=\"dropdown\">";
			if (isset($_SERVER['unscoped-affiliation']))
			{
	
			}
		}
		else
		{
			echo "<br>Please sign in at <a href=\"https://pripyat.mit.edu/Pulse/\">Pulse</a> to continue.";
			if (!strpos($CurrentURL, "Agree.php")) exit;
		}
	}
	else
		echo "</div></div>";

	echo "</span>";
	echo "</td>";

//      print_r($_COOKIE);

// Record the header page load end time, and report it

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$header_time = round(($finish - $start), 4);
//echo "Header generated in " . $total_time . " seconds.";

?>

</tr></tbody></table>
