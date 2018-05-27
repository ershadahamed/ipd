<?php
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$heading='Report - Total Subscribe Course';
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('courses');
	$PAGE->navbar->add($heading);
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($heading, 2, 'headingblock header');
?>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	include('../css/pagination.css');
	include('../css/grey.css');
?>
</style>
<form id="form1" name="form1" method="post" action="">

<table border="0" width="100px">
  <tr>
    <td>Year</td>
    <td>	
	<select name="years" id="years">
	<option value=""> - Year - </option>
	<?php
		$currentyeardate=date('Y',strtotime('now'));
		//$currentyeardate=date('Y',strtotime('now'));
		$listyears = array_combine(range($currentyeardate, 2013), range($currentyeardate, 2013));
		
		foreach($listyears as $k){
        $string .= '<option value="'.$k.'">'.$k.'</option>'."\n";     
    }
	echo $string;
	?>	
    </select></td>
	<td width="2%">&nbsp;</td>
    <td>Month</td>
    <td><select name="month" id="month">
		<option value=""> - Month - </option>
		<option value="1"> January </option>
		<option value="2"> February </option>
		<option value="3"> March </option>
		<option value="4"> April </option>
		<option value="5"> May </option>
		<option value="6"> June </option>
		<option value="7"> July </option>
		<option value="8"> August </option>
		<option value="9"> September </option>
		<option value="10"> October </option>
		<option value="11"> November </option>
		<option value="12"> December </option>
    </select></td>
	<td width="1%">&nbsp;</td>
    <td><input type="submit" name="view" value="View" /></td>
  </tr>
</table>
</form>
<?php 
	if(isset($_POST['view'])){ 
		$monthdata=$_POST['month'];
		$yearsdata=$_POST['years']; 
	}
?>
  <table id="availablecourse3" width="100%" border="1">
    <tr class="yellow">
      <th class="adjacent" width="50%" style="text-align:left;"><strong>Course / Module Name</strong></th>
      <th class="adjacent" width="50%"><strong>Total Subscribe</strong></th>
    </tr>
  	<?php
		$selectsql=mysql_query("
		SELECT * FROM mdl_cifacourse WHERE category='1'
		");
		$q1sum=0;
		$count=0;
		while($sss=mysql_fetch_array($selectsql)){
	?>
    <tr>
      <td class="adjacent" ><?=$sss['fullname'];?></td>
      <td class="adjacent" style="text-align:center;">
      <?php
		$statement=" mdl_cifacourse a Inner Join mdl_cifaenrol b On a.id = b.courseid Inner Join mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join mdl_cifauser d On c.userid = d.id";		
		$sqlcourse="SELECT * FROM {$statement} WHERE b.courseid='".$sss['id']."' And b.enrol = 'manual' And a.category = '1' And a.visible = '1' And b.status = '0' AND c.userid!='391' AND c.userid!='269' AND (d.usertype='Active candidate' OR d.usertype='Inactive candidate')";	
		if($yearsdata != ''){ $sqlcourse.= " AND (date_format(from_unixtime(c.timecreated), '%Y') LIKE '%".$yearsdata."%')"; }
		if($monthdata != ''){ $sqlcourse.= " AND (date_format(from_unixtime(c.timecreated), '%m') LIKE '%".$monthdata."%')"; }
                if(($yearsdata != '') && ($monthdata != '')) { $sqlcourse.= " AND (date_format(from_unixtime(c.timecreated), '%Y') LIKE '%".$yearsdata."%') AND (date_format(from_unixtime(c.timecreated), '%m') LIKE '%".$monthdata."%')"; }
		
		$selectsql2=mysql_query($sqlcourse);
		$countsql=mysql_num_rows($selectsql2); 
		echo $countsql;
		$q1sum+=(float) ($countsql); //count total subscribe
	  ?>
      </td>
    </tr>
    <?php } ?>
	<tr>
		<td class="adjacent" style="font-weight:bolder;background-color:#ccc;"> Total Subscribe </td>
		<td class="adjacent" style="text-align:center;font-weight:bolder; background-color:#ccc;"><?=$q1final_result=$q1sum;?></td></tr>
  </table>
  <br/><br/>
 
<?php	
	}
	echo $OUTPUT->footer();	
?>