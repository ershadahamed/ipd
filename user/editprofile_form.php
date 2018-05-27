<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');

	$site = get_site();
	
	$purchaseprogramview=get_string('buyacifa');
	$title="$SITE->shortname: Courses - ".$purchaseprogramview;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->navbar->add($purchaseprogramview);		
	$PAGE->set_pagelayout('standard');
	echo $OUTPUT->header();	
	
	$scountrylist=mysql_query("Select * From {$CFG->prefix}country_list");
	
	$selectcode=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$USER->country."'");
	$ccode=mysql_fetch_array($selectcode);	
	
	$title=$USER->title;
	$firstname=$USER->firstname;
	$middlename=$USER->middlename;
	$lastname=$USER->lastname;
	$dob=$USER->dob;
	$gender=$USER->gender;
	$email=$USER->email;
	$address1=$USER->address;
	$address2=$USER->address2;
	$address3=$USER->address3;
	$city=$USER->city; 
	$postcode=$USER->postcode; 
	$state=$USER->state;
	$phoneno=$USER->phone1;
	$empstatus=$USER->empstatus;
	$empname=$USER->empname;
	
	$designation=$USER->designation;
	$department=$USER->department;
	$empstartdate=$USER->empstartdate;
	
	$highesteducation=$USER->highesteducation;
	$yearcomplete_edu=$USER->yearcomplete_edu;
	$professionalcert=$USER->professionalcert;
	$nameofqualification=$USER->nameofqualification;
	$yearcomplete=$USER->yearcomplete;
	$college_edu=$USER->college_edu;
	$major_edu=$USER->major_edu;
	$startdate_edu=$USER->startdate_edu;
	$completion_edu=$USER->completion_edu;
?>
<style>
th, td {
    border: 0px solid #000;
    padding: 0.2em;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script type="text/javascript">
	$(function() {
		$( "#employmentstartdate" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:"dd/mm/yy"
		});
	});
	$(function() {
		$( "#startdate_edu" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:"dd/mm/yy"
		});
	});
	$(function() {
		$( "#completion_edu" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:"dd/mm/yy"
		});
	});		
</script>

<script type="text/javascript">
function check(elem) {
    document.getElementById('empname').disabled = !elem.selectedIndex;
}
</script>

<style type="text/css">
.fsubmit {
	text-align: center;
	padding: 2px;
	width: 70%;
	border-width: 0;
	width: 80%;
	margin-left: 16%;
	margin-bottom:2em;
}

#profile_edit_form .error {
 padding:2px;
 /*margin:5px 0;
 border:1px solid #f00;*/
 color: #AA0000;
}
#profile_edit_form label {
 display:block;
}

.contactus_table td{vertical-align:top;}
</style>

<!---validate-->
<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script-->
<!--script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script-->
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#profile_edit_form").validate();
});
</script><!---validate-->

<form action="<?=$contactusform_link;?>" method="post" id="profile_edit_form">
<div style="color: #AA0000; text-align: right;">Required fields are marked *</div>
<?php
	$required='<span style="color: #FF1111; text-align: right;">*</span>';
?>
<fieldset style="text-align: left;padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('general');?></legend>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="15%" align="right" scope="row">Title</td>
      <td width="84%">
	  	<?php 		
			if($title=='0'){ echo 'Mr';}
			if($title=='1'){ echo 'Mrs';}
			if($title=='2'){ echo 'Miss';}
		?>
      	<input type="hidden" name="title" id="title" value="<?=$title;?>" />
      </td>
    </tr>
    <tr>
      <td align="right" scope="row">First Name</td>
      <td><?=ucwords(strtolower($firstname));?><input type="hidden" name="firstname" id="firstname" value="<?=$firstname;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Middle Name</td>
      <td>
      <label for="middlename"></label>
      <input type="text" name="middlename" id="middlename" value="<?=$middlename;?>"  maxlength="26" size="40"/></td>
    </tr>
    <tr>
      <td align="right" scope="row">Last Name</td>
      <td><?=ucwords(strtolower($lastname));?><input type="hidden" name="lastname" id="lastname" value="<?=$lastname;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">D.O.B</td>
      <td><?=date('d/m/Y',$dob);?><input type="hidden" name="dob" id="dob" value="<?=$dob;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Gender</td>
      <td>
        <?php 		
			if($gender=='0'){ echo 'Male';}
			if($gender=='1'){ echo 'Female';}
		?>
      	<input type="hidden" name="gender" id="gender" value="<?=$gender;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row"><div style="display:inline;">Email Address <?=$required?></div></td>
      <td><input type="text" name="email" id="email" value="<?=$email;?>" maxlength="100" size="30" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Address (Line 1)</td>
      <td><input type="text" name="address1" id="address1" value="<?=$address1;?>" maxlength="120" size="40" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Address (Line 2)</td>
      <td><input type="text" name="address2" id="address2" value="<?=$address2;?>" maxlength="120" size="40" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Address (Line 3)</td>
      <td><input type="text" name="address3" id="address3" value="<?=$address3;?>" maxlength="120" size="40" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">City/Town<?=$required?></td>
      <td><input type="text" name="citytown" id="citytown" value="<?=$city;?>" maxlength="120" size="21" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Postcode/Zip<?=$required?></td>
      <td><input type="text" name="poscode" id="poscode" value="<?=$postcode;?>" maxlength="120" size="21" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">State/Province</td>
      <td><input type="text" name="province" id="province" value="<?=$state;?>" maxlength="120" size="21" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Select a Country<?=$required?></td>
      <td>
      <label for="countrylist"></label>
        <select name="countrylist" id="countrylist">
        <?php
		
			while($countrylist=mysql_fetch_array($scountrylist)){
				echo '<option value="'.$countrylist['iso_countrycode'].'"'; 
				if($USER->country==$countrylist['countrycode']){ 
				echo 'selected'; 
				}
				echo '>';
				echo $countrylist['countryname'];
				echo '</option>';
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td align="right" scope="row">Phone (Daytime)<?=$required?></td>
      <td><?='+'.$ccode['iso_countrycode'];?>&nbsp;<input type="text" name="daytimephone" id="daytimephone" value="<?=$phoneno;?>" maxlength="20" size="25" /></td>
    </tr>
  </table></fieldset>
  
<fieldset style="text-align: left;padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Employment Background</legend>  
<table width="100%" border="0">
    <tr>
      <td width="20%" align="right" scope="row">Employment Status</td>
      <td width="84%"> 
      <select name="empstatus" id="empstatus" onChange="check(this);">
      <option value=''>Select one..</option> 
      <option value='1' <?php if($empstatus=='1'){ echo 'Selected="Selected"';} ?>><?=get_string('working');?></option>  
      <option value='2' <?php if($empstatus=='2'){ echo 'Selected="Selected"';} ?>><?=get_string('notworking');?></option>     
      </select></td>
    </tr>
    <tr>
      <td align="right" scope="row">Employer Name<?=$required?></td>
      <td><input type="text" name="empname" id="empname" maxlength="50" size="40" value="<?=$empname;?>" disabled="disabled" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Designation<?=$required?></td>
      <td><input type="text" name="designation" id="designation" value="<?=$designation;?>" maxlength="50" size="40" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Department<?=$required?></td>
      <td><input type="text" name="department" id="department" value="<?=$department;?>" maxlength="50" size="40" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Start Date<?=$required?></td>
      <td><input type="text" name="employmentstartdate" id="employmentstartdate" value="<?=date('d/m/Y',$empstartdate);?>" /></td>
    </tr>
  </table> 
</fieldset> 
  
<fieldset style="text-align: left;padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Education Background</legend>  
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-width:0px;">
    <tr>
      <td width="20%" align="right" scope="row">Highest Education</td>
      <td width="84%">
      <select name="highesteducation" id="highesteducation">
      <?php
		$highesteducationtitle = get_string('highesteducation');
		$highesteducationlist = array();
		$highesteducationlist['0']='Select one..';
		$highesteducationlist['1'] = get_string('highesteducation1');
		$highesteducationlist['2'] = get_string('highesteducation2');
		$highesteducationlist['3'] = get_string('highesteducation3');
		$highesteducationlist['4'] = get_string('highesteducation4');
		$highesteducationlist['5'] = get_string('highesteducation5');
		$arrlength=count($highesteducationlist);
		for($x=0;$x<$arrlength;$x++)
		{
		  echo '<option value="'.$x.'"';
		  if($highesteducation==$x){ echo 'Selected';}
		  echo '>'.$highesteducationlist[$x].'</option>';
		}			  
	  ?>    
      </select></td>
    </tr>
    <tr>
      <td align="right" scope="row">Year Completed</td>
      <td>
      <select name="yearcomplete_edu" id="yearcomplete_edu">
		<?php
			//Year completed education
			$currentyeardateedu=date('Y',strtotime('now'.'+ 23 years'));		
			$listyearsedu = array();
			//$listyearsedu['']='Select one..';
			echo '<option value="0">Select one..</option>';
			for($i = 1933;$i<= $currentyeardateedu;$i++){
				$listyearsedu["$i"] = $i;
				echo '<option value="'.$listyearsedu["$i"].'"';
				if($yearcomplete_edu==$i){ echo 'Selected';}
				echo '>';
				echo $i;
				echo '</option>';	
			}
        ?>      
      </select></td>
    </tr>
    <tr>
      <td align="right" scope="row">Professional Certification</td>
      <td>
      <select name="professionalcert" id="professionalcert">
 	  <?php
		$profcerttitle = get_string('professionalcert');
		$profcertlist = array();
		$profcertlist['0']='Select one..';
		$profcertlist['1'] = get_string('certificate0');
		$profcertlist['2'] = get_string('certificate1');
		$profcertlist['3'] = get_string('certificate2');
		$profcertlist['4'] = get_string('certificate3');
		$profcertlist['5'] = get_string('certificate4');	
		$profcertlist['6'] = get_string('certificate5');
		$profcertlist['7'] = get_string('certificate6');
		$profcertlist['8'] = get_string('certificate7');
		$profcertlist['9'] = get_string('certificate8');
		$profcertlist['10'] = get_string('certificate9');
		$profcertlist['11'] = get_string('certificate10');
		$profcertlist['12'] = get_string('certificate11');	  

		$arrlength=count($profcertlist);
		for($x=0;$x<$arrlength;$x++)
		{
		  echo '<option value="'.$x.'"';
		  if($professionalcert==$x){ echo 'Selected';}
		  echo '>'.$profcertlist[$x].'</option>';
		}
	  ?>       
      </select></td>
    </tr>
    <tr>
      <td align="right" scope="row">Name of Qualification</td>
      <td><input type="text" name="nameofqualification" id="nameofqualification" value="<?=$nameofqualification;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Year Completed</td>
      <td>
      <select name="yearcomplete" id="yearcomplete">
		<?php
		//Year completed education
		$currentyeardate=date('Y',strtotime('now'.'+ 23 years'));					
		$listyears = array();
		$listyears['']='Select one..';
		echo '<option value="0">Select one..</option>';
		for($i = 1933;$i<= $currentyeardate;$i++){
			$listyears["$i"] = $i;	
				echo '<option value="'.$listyears["$i"].'"';
				if($yearcomplete==$i){ echo 'Selected';}
				echo '>';
				echo $i;
				echo '</option>';				
		}				
        ?>       
      </select></td>
    </tr>
    <tr>
      <td align="right" scope="row">College/University Name</td>
      <td><input type="text" name="college_edu" id="college_edu" value="<?=$college_edu;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Major</td>
      <td><input type="text" name="major_edu" id="major_edu" value="<?=$major_edu;?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Start Date</td>
      <td><input type="text" name="startdate_edu" id="startdate_edu" value="<?=date('d/m/Y',$startdate_edu);?>" /></td>
    </tr>
    <tr>
      <td align="right" scope="row">Completion Date</td>
      <td><input type="text" name="completion_edu" id="completion_edu" value="<?=date('d/m/Y',$completion_edu);?>" /></td>
    </tr>
  </table></fieldset>

<fieldset style="text-align: left;padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('communicationpreferences');?></legend> 
<?php
//popup
		$a = new stdClass();
		
		$policy=$CFG->wwwroot .'/userpolicy.php';
		$a = "<a href=\"javascript:void(0);\" onclick=\"popupwindow('".$policy."', 'myPop1',820,600);\"><u><b>".get_string('cifaonlinepolicy')."</b></u></a>";			
		//End popup	
?> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-width:0px;">
    <tr>
      <td colspan="2" scope="row"><div style="padding-left:0.3em;"><h6>Please read the options in this column carefully.</h6></div></td>
    </tr>
    <tr>
      <td width="2%" valign="middle" scope="row">
      <input type="checkbox" name="checkbox" id="checkbox" checked disabled="disabled" />
      <input type="hidden" id="compreference1" name="compreference1" value="1">
      <label for="checkbox"></label></td>
      <td width="98%"><?=get_string('compreference1');?></td>
    </tr>
    <tr>
      <td valign="middle" scope="row">
      <input type="checkbox" name="checkbox2" id="checkbox2" <?php if($USER->compreference1=='1'){ echo 'checked';}  ?> />
      </td>
      <td><?=get_string('compreference2');?></td>
    </tr>
    <tr>
      <td valign="middle" scope="row">
      <input type="checkbox" name="checkbox3" id="checkbox3" checked disabled="disabled" />
      <input type="hidden" id="compreference3" name="compreference3" value="1">
      </td>
      <td><?=get_string('compreference3_1').get_string('compreference3', '', $a).get_string('compreference3_2');?></td>
    </tr>
  </table>
</fieldset>
  
  <table border="0" align="center">
    <tr>
      <th align="right" scope="row">
      <input type="submit" name="button" id="button" value="Save" />    
      </th>
      <td align="left"><input type="submit" name="button2" id="button2" value="Cancel" /></td>
    </tr>
  </table>
  </form>
<?php 	echo $OUTPUT->footer();	?>
</body>
</html>