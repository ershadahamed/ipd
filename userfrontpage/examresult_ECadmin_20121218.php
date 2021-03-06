<?php	
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$examresult=get_string('examresult');
	$title="$SITE->shortname: ".$examresult;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('courses');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($examresult, 2, 'headingblock header');
	
	$sql="SELECT * FROM mdl_cifauser";
	$query=mysql_query($sql);
?>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	include('../css/pagination.css');
	include('../css/grey.css');
?>
</style>
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
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 12;
    $startpoint = ($page * $limit) - $limit;
	
	//collect user to list out on table
	$statement=" mdl_cifauser a, mdl_cifaquiz_grades b WHERE a.id=b.userid AND a.deleted='0' AND (a.usertype='Active candidate' OR a.usertype='inactive candidate')";
	$sqlcourse="SELECT * FROM {$statement} GROUP BY a.id ORDER BY a.firstname ASC";
	$sqlcourse.=" LIMIT {$startpoint} , {$limit}";	
		
	$sqlquery=mysql_query($sqlcourse);
	//$mycount=mysql_num_rows($sqlquery);
	//echo $mycount;
	$no='1';
	$candidateID='0';
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
	
	//if($sqlrow['traineeid'] == $candidateID){
	//	continue;
	//}else{
		//echo $sqlrow['traineeid'].'<br/>';
?>
	  <tr>
		<td class="adjacent" width="1%" align="center"><?php echo $bil+($startpoint); ?></td>
		<td class="adjacent" style="text-align:left;"><?=ucwords(strtolower($sqlrow['traineeid']));?></td>
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
			<input type="submit" value="<?=get_string('view');?>" title="<?=get_string('view');?> result" name="viewresult" onClick="this.form.action='<?=$CFG->wwwroot ."/userfrontpage/viewresult.php?id=".$sqlrow['userid'];?>'"  onMouseOver="style.cursor='hand'"/>
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
	echo pagination($statement,$limit,$page); 
?>
</td></tr></table>
</div></div>
<?php	
	}
	echo $OUTPUT->footer();	
?>