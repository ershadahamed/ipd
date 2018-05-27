 <?php   
	require_once('config.php');
	include('manualdbconfig.php'); 
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');

    if ($CFG->forcelogin) {
        require_login();
    } else {
        user_accesstime_log();
    }

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	//header
    echo $OUTPUT->header();
	echo $OUTPUT->heading('Report', 2, 'headingblock header');
	echo '<br/>';
?>
<style type="text/css">
<?php 
	include('css/style2.css'); 
	include('css/style.css'); 
?>
</style>
<?php $courselist=mysql_query("SELECT * FROM mdl_cifacourse WHERE category='1' ORDER BY id"); ?>
<form name="listcourses" method="post">
<table width="38%" border="0" style="text-align:left;">
<tr>
	<td>List of courses</td><td width="1%">:</td>
    <td>
    	<select name="listcourse">
        <option value=""> - Select one - </option>
        <?php
			while($slist=mysql_fetch_array($courselist)){
				echo '<option value="'.$slist['fullname'].'">'.ucwords(strtolower($slist['fullname'])).'</option>';
			}
		?>
        </select>
    </td><td><input type="submit" name="view" value="View"/></td>
</tr>
</table></form>

<?php $coursename=$_POST['listcourse'];?>

<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
    <th class="adjacent" width="25%" align="left"><strong>Firstname</strong></th>
    <th class="adjacent" width="25%" align="left"><strong>Lastname</strong></th>
    <th class="adjacent" width="39%" style="text-align:left;">Course name</th>	
    <th class="adjacent" width="10%" style="text-align:center;">Date enrol</th>
  </tr>
  <?php
  	$statement="SELECT * FROM mdl_cifaenrol a, mdl_cifauser_enrolments b, mdl_cifacourse c 
	WHERE a.id=b.enrolid AND c.id=a.courseid AND c.category='1'";
	if($coursename!='') $statement.=" AND c.fullname='".$coursename."'";
	$que=mysql_query($statement);
	$count=mysql_num_rows($que);
	if($count!=''){
	$no='1';
	while($list=mysql_fetch_array($que)){
	$bil= $no++;	
  ?>
  <tr>
  	<td class="adjacent" width="1%" align="center"><?=$bil; ?></td>
    <td class="adjacent" style="text-align:left;">
		<?php
			$sql=mysql_query("SELECT id,firstname, lastname FROM mdl_cifauser WHERE id='".$list['userid']."'");
			$row=mysql_fetch_array($sql);
        	echo ucwords(strtolower($row['firstname']));
		?>
    </td>
    <td class="adjacent" style="text-align:left;"><?=ucwords(strtolower($row['lastname']));?></td>
    <td class="adjacent" style="text-align:left;">
		<?php 
			//display of course fullname 
			$statement_course=mysql_query("SELECT * FROM mdl_cifacourse WHERE category='1' AND id='".$list['courseid']."'");
			$scourse=mysql_fetch_array($statement_course);
			echo ucwords(strtolower($scourse['fullname']));
		?>
    </td>
    <td class="adjacent">
		<?php 
			//$enroldate=$list['timecreated'];
			$enroldate=date('Y-m-d',$list['timecreated']);
			echo $enroldate;
		?>
    </td>
  </tr>
  <?php }}else{ //if no record found?>
  <tr><td colspan="5">Record not found</td></tr>  
  <?php } ?>
</table>

 <?php   
	echo '<br />';
	//end content area
	
	//footer
    echo $OUTPUT->footer();?>