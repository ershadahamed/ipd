<?php	
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$get_userrole=mysql_query("SELECT roleid FROM {$CFG->prefix}role_assignments WHERE userid='".$USER->id."' AND contextid='1'");
	$guserrole=mysql_fetch_array($get_userrole);
	$userrole=mysql_num_rows($get_userrole);
	$uroleid=$guserrole['roleid'];	
	
	$examresult=get_string('examresult');
	$title="$SITE->shortname: ".$examresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	if($uroleid!='5'){
		$PAGE->set_pagelayout('buy_a_cifa');
	}
	//$PAGE->set_pagelayout('courses');
	$vresult_link=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;
	$PAGE->navbar->add($examresult, $vresult_link);	
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($examresult, 2, 'headingblock header');
	
	//$sql="SELECT * FROM mdl_cifauser";
	//$query=mysql_query($sql);
?>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	//include('../css/pagination.css');
	include('../css/grey.css');
?>
</style>
<!---Search------>

<link rel="stylesheet" type="text/css" media="all" href="../offlineexam/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../offlineexam/jquery.1.4.2.js"></script>
<script type="text/javascript" src="../offlineexam/jsDatePick.jquery.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"
		});
	};
</script>
<script type="text/javascript">
/***untuyk select value listbox to textbox***/	
function displ()
{
  if(document.formname.pilihancarian1.options[0].value == true) {
    return false
  }
  else {
	document.formname.dob2.value=document.formname.pilihancarian1.options[document.formname.pilihancarian1.selectedIndex].value;
  }
  return true;
}	
</script>
<form id="formname" name="formname" method="post" onClick="return displ();">
<table border="0" cellpadding="1" cellspacing="1" style="margin-top:30px; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr>
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian1" style="width:180px;">
			<option value=""> - select - </option>
			<option value="traineeid"><?=get_string('candidateid');?></option>
			<option value="email"><?=get_string('email');?></option>
			<option value="name"><?=get_string('examname');?></option>
			<!--option value="timestart"><?//=get_string('examdate');?></option-->			
		</select>
		</td>
		<td width="10%"><input type="text" name="search1" style="width:250px;" /></td>
		<td>
			<input type="submit" name="search" value="<?=get_string('search');?>"/>
			<!--input type="text" id="inputField2" name="dob2" size="40" /-->
			<!--input type="text" id="inputField" name="dob" size="40" /-->
		</td>
	</tr>	
	<tr>
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian2" style="width:180px;">
			<option value=""> - select - </option>
			<option value="traineeid"><?=get_string('candidateid');?></option>
			<option value="email"><?=get_string('email');?></option>
			<option value="name"><?=get_string('examname');?></option>	
			<!--option value="timestart"><?//=get_string('examdate');?></option-->	
		</select>
		</td>
		<td width="10%"><input type="text" name="search2" style="width:250px;" /></td>
		<!--td><input type="submit" name="search" value="<?//=get_string('search');?>"/></td-->
	</tr>    
</table>
</form>
<?php 
	$selectsearch1=$_POST['pilihancarian1']; 
	$candidateid1=$_POST['search1']; 
	$selectsearch2=$_POST['pilihancarian2']; 
	$candidateid2=$_POST['search2']; 	
?>
<!---end search------>

<div style="min-height: 390px;">
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="12%" align="left"><strong><?=get_string('candidateid');?></strong></th>
    <th class="adjacent" width="33%" align="left"><strong><?=get_string('name');?></strong></th>
    <th class="adjacent" width="25%" align="left"><strong><?=get_string('email');?></strong></th>
    <th class="adjacent" width="14%" style="text-align:center;"><?=get_string('lastaccess');?></th>	
    <th class="adjacent" width="10%" style="text-align:center;"><?=get_string('status');?></th>
	<th class="adjacent" width="5%" style="text-align:center;"><?=get_string('result');?></th>
  </tr>
<?php
	//$row=mysql_fetch_array($query);
	//if($row['id'] >= 1){ 
	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 12;
    $startpoint = ($page * $limit) - $limit;
	
	//collect user to list out on table
	//$statement=" mdl_cifauser a, mdl_cifaquiz_grades b WHERE a.id=b.userid AND a.deleted='0' AND (a.usertype='Active candidate' OR a.usertype='inactive candidate')";
   	
	$statement=" 
	  mdl_cifauser a Inner Join
	  mdl_cifaquiz_grades b On a.id = b.userid Inner Join
	  mdl_cifaquiz_attempts c On b.userid = c.userid And b.quiz = c.quiz Inner Join
	  mdl_cifaquiz d On c.quiz = d.id Inner Join
	  mdl_cifauser_accesstoken e On e.userid = c.userid		
	";	
	if($_GET['id']!='2'){
		$statement.=" Where a.deleted!='1' AND ((a.usertype = 'Active candidate') Or (a.usertype = 'Inactive Candidate'))";
	}else{
		$statement.=" Where a.deleted!='1' AND ((a.usertype = 'Active candidate') Or (a.usertype = 'Inactive Candidate'))";
	}
	if($candidateid1!='' && $selectsearch1!=''){$statement.= " AND (($selectsearch1 LIKE '%".$candidateid1."%'))";}
	if($candidateid2!='' && $selectsearch2!=''){$statement.= " AND (($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	if($candidateid1!='' && $selectsearch1!='' && $candidateid2!='' && $selectsearch2!=''){$statement.= " AND (($selectsearch1 LIKE '%".$candidateid1."%') AND ($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	
	$sqlcourse="SELECT * FROM {$statement} GROUP BY a.id ORDER BY a.firstname ASC";
	// $sqlcourse.=" LIMIT {$startpoint} , {$limit}";	
		
	$sqlquery=mysql_query($sqlcourse);
	$mycount=mysql_num_rows($sqlquery);
	//echo $mycount;
	if($mycount!='0'){ 
	$no='1';
	$candidateID='0';
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
?>
	  <tr>
		<td class="adjacent" width="1%" align="center"><?php echo $bil+($startpoint); ?></td>
		<td class="adjacent" style="text-align:left;"><?=ucwords(strtoupper($sqlrow['traineeid']));?></td>
		<td class="adjacent" style="text-align:left;">
			<?php 
				//view user fullname
				$userfullname=$sqlrow['firstname'].' '.$sqlrow['lastname'];
				echo ucwords(strtolower($userfullname)); 
			?>
		</td>
		<td class="adjacent" style="text-align:left;">
			<?php echo $sqlrow['email']; ?>
		</td>
		<td class="adjacent" style="text-align:center;">
		<?php 		
			//echo $sqlrow['id']; //last access
			require_once('../functiontime.php');
			$sqlaccess=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$sqlrow['userid']."'");
			$qulast=mysql_fetch_array($sqlaccess);
			$lastaccess=date('d-m-Y H:i:s',$qulast['lastaccess']);
			echo $lastaccess;
		?>
		</td>	
		<td align="center" class="adjacent">
		<?php 
		//start date
			$createdate = unix_timestamp_to_human($sqlrow['timecreated']);		
			
			$tarikhdaftar=$sqlrow['timecreated'];
			$tarikhakhir=$sqlrow['lasttimecreated'];
			$today = strtotime('now');
			
			if($tarikhdaftar <= $today && $today <= $tarikhakhir) {
				echo'Active'; 			
			}else{			
				
				$displayrole=mysql_query("SELECT * FROM mdl_cifarole WHERE (id='5' OR id='13')");
				$countroles=mysql_num_rows($displayrole);
				if($countroles!='0'){
					//inactive bila sudah expired dr. last date
					//to make sure all enrolment status ='1'
					$semak=mysql_query("SELECT status FROM mdl_cifauser_enrolments WHERE status!='1' AND userid='".$sqlrow['userid']."'");
					$countsemak=mysql_num_rows($semak);
					if($countsemak!='0'){
						$supdate=mysql_query("UPDATE mdl_cifauser_enrolments SET status='1' WHERE status!='1' AND userid='".$sqlrow['userid']."'");
						
						//change role from active to inactive
						$roleupdate=mysql_query("UPDATE mdl_cifarole_assignments SET roleid='9', contextid='1' WHERE roleid='5' AND contextid!='1' AND userid='".$sqlrow['userid']."'");
						if($roleupdate){
							$queryrole  = $DB->get_records('role_assignments',array('userid'=>$sqlrow['userid']));
							foreach($queryrole as $qrole){
								$sq=mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='".$qrole->roleid."'");
								$qs=mysql_fetch_array($sq); 
								//update usertype
								$updatetype=mysql_query("UPDATE mdl_cifauser SET usertype='".$qs['name']."' WHERE id='".$sqlrow['userid']."'");
							}
						}
					}	
					
					//change role- active to inactive institution client
					$Oroleupdate=mysql_query("UPDATE mdl_cifarole_assignments SET roleid='14' WHERE roleid='13' AND contextid='1' AND userid='".$sqlrow['userid']."'");
					if($Oroleupdate){
						$queryrole  = $DB->get_records('role_assignments',array('userid'=>$sqlrow['userid'], 'contextid'=>'1'));
						foreach($queryrole as $qrole){
							$sq=mysql_query("SELECT id, name FROM mdl_cifarole WHERE id='".$qrole->roleid."'");
							$qs=mysql_fetch_array($sq);
							//update usertype
							$updatetype=mysql_query("UPDATE mdl_cifauser SET usertype='".$qs['name']."' WHERE id='".$sqlrow['userid']."'");
						}				
					}
				}
				//user status
				echo'Inactive';
			}

		?>
		</td>
		<td class="adjacent" style="text-align:center;">
		<form id="form1" name="form1" method="post" action="">
		<div style="padding:3px;">
			<input type="submit" value="<?=get_string('view');?>" title="<?=get_string('view');?> result" name="viewresult" onClick="this.form.action='<?=$CFG->wwwroot ."/userfrontpage/viewresult.php?id=".$sqlrow['userid']."&nav=".$examresult;?>'"  onMouseOver="style.cursor='hand'"/>
		</div>
		</form>
		</td>	
	  </tr>
<?php 	
	//}
		//$candidateID=$sqlrow['traineeid'];
	} }else{ ?> 
  <tr>
    <td class="adjacent" colspan="7"><?=get_string('norecords');?></td>
  </tr>
<?php } ?>
</table>

<div style="margin-top:10px;">
<table align="center"><tr><td>
<?php 
	//paging numbers
	//echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div></div>
<?php	
	}
	echo $OUTPUT->footer();	
?>