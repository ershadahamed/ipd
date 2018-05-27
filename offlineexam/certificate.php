<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	include_once ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);


$id = $_GET["id"];

$trainer = "SELECT * FROM mdl_cifauser WHERE traineeid = '".$id."'";
$cidosexam1 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'A'";
$cidosexam2 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'B'";
$cidosexam3 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'C'";

$query = mysql_query($trainer);
$data = mysql_fetch_array($query);


$exam1 = mysql_query($cidosexam1);
$exam2 = mysql_query($cidosexam2);
$exam3 = mysql_query($cidosexam3);



$a = mysql_fetch_array($exam1);
$b = mysql_fetch_array($exam2);
$c = mysql_fetch_array($exam3);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jquery.1.4.2.js"></script>
<script type="text/javascript" src="jsDatePick.jquery.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%M-%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
</script>
</head>
<body>
<?php
echo ucfirst($data['firstname']).' '.ucfirst($data['lastname']);
if($data['address'] !=''){
	echo "<br/>".ucfirst($data['address']);
}
echo "<br/>".ucfirst($data['city'])."<br>";
echo ucfirst($data['country'])."<br><br>";
?>
<form name="sa" action="d_certificate.php?id=<?=$id;?>" method="post">
<div class="demo">
Date: <input name="date" type="text" size="12" id="inputField" />
</div>
<input name="id" type="text" value="<?php echo $id;  ?>" hidden> 
<br>
<?php
echo "Dear "; 
echo ucfirst($data['firstname']);
?>
<br><br>

This Letter represent confirmation of your examination result by SHAPE&#x2122; Financial Corporation.
<textarea name="line1" rows="4" cols="100">
You achieved a score of 85% on Foundation Level Examination. We wish to congratulate you on you successful completion of this course.
</textarea>

<br>

&nbsp;&nbsp;&nbsp;
A		<?php echo $a['marks'];?>% and above<br>
&nbsp;&nbsp;&nbsp;
B		<?php echo $b['marks'];?>-<?php echo $d = $a['marks']-1; ?>%<br>
&nbsp;&nbsp;&nbsp;
C		<?php echo $c['marks'];?>-<?php echo $d = $b['marks']-1; ?>%<br>
&nbsp;&nbsp;&nbsp;
Did Not Pass	<?php echo $c = $c['marks']-1; ?>% and below

<br><br>
<textarea name="line2" rows="2" cols="100">
SHAPE&#x2122; Finacial Corporation takes all possible measure to ensure that the assessment process is fair and equitable. In all cases, the exam results the final.
</textarea>
<textarea name="line3" rows="4" cols="100">
We would like to take this opportunity to thank you for studying with SHAPE&#x2122; Finacial Corporation and we hope we can continue to support you throughout your career including any futher studies you may undertake.
</textarea>
<br><br>
<input align="right" type="submit" value="View" />
</form>
</body>
</html>




