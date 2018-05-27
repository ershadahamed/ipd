<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('cifacandidatemanagement');
    $PAGE->navbar->add(ucwords(strtolower($listusertoken)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
	echo $OUTPUT->heading($listusertoken);
?>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}

	td { padding:3px;}
</style>
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('download_button').disabled=false;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
		//document.getElementById('download_button').disabled=true;
	}
  }
</script>

<!--form name="form" id="form" action="<?//=$CFG->wwwroot. '/offlineexam/download_token.php'; ?>" method="post"-->
<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('cifacandidatedatabase');?></legend>
<?=get_string('multiplepwordresetnotice');?><br/>
<div style="color:red; padding-top:0.5em;">
<?//=get_string('resetsuccessful');?>
<?php
	if(isset($_POST['multiplereset'])){ 
		if($_POST['checktoken'] != ""){
			$checkBox = $_POST['checktoken'];
			for($i=0; $i<sizeof($checkBox); $i++){
			
			$pword_text='Pa55w0rd01';
			$password=md5($pword_text);
			$ucuser=mysql_query("UPDATE mdl_cifauser SET password='".$password."' WHERE id='".$checkBox[$i]."'") or die("Not update".mysql_error());
				if($i=='0'){
					echo $notice=get_string('resetsuccessful');	
				}
			}
			
			/* if($ucuser){
				include('../emailsettings/emailfunction.php');

				$sqlAdmin="
						Select
						  a.lastname,
						  a.id,
						  a.username,
						  a.email,
						  a.firstname
						From
						  mdl_cifauser a
						Where
						  a.id = '2'";
				$queryAdmin=mysql_query($sqlAdmin);
				$rowAdmin=mysql_fetch_array($queryAdmin);
				
				$sqlsd=mysql_query("SELECT * FROM mdl_cifauser WHERE id='".$checkBox[$i]."'");
				$sd=mysql_fetch_array($sqlsd);
				
				$linkchangepassword="<a href='".$CFG->wwwroot."/login/change_password.php'>".$CFG->wwwroot."/login/change_password.php</a>";
				$from=$rowAdmin['email'];//"mohd.arizan@mmsc.com.my"; //administrator mail
				$namefrom="CIFA Administrator";
				$to = $sd['email'];//"arizan_86@yahoo.com";
				$nameto = ucwords(strtolower($sd['firstname'])).' '.ucwords(strtolower($sd['lastname']));
				$subject = "Changed password";
				$username=$sd['username'];
				
				$message = "
				Hi $nameto,<br/><br/>

				Your account password at <strong>LearnCIFA Workspace</strong> has been reset
				and you have been issued with a new temporary password.<br/><br/>

				Your current login information is now:<br/>
				<strong>username: </strong>strtoupper($username)<br/>
				<strong>password: </strong>$pword_text<br/>
							 (you will have to change your password
							  when you login for the first time)

				<br/><br/>
				Please go to this page to change your password:<br/>
				$linkchangepassword
				   
				<br/><br/>
				In most mail programs, this should appear as a blue link
				which you can just click on.  If that doesn\'t work,
				then cut and paste the address into the address
				line at the top of your web browser window.<br/><br/>

				Cheers from the <strong>LearnCIFA Workspace</strong> administrator,<br/><br/>

				Your Sincerely,	<br/>	
				<b>CIFA Support</b>		
				";
						
				// this is it, lets send that email!
				authgMail($from, $namefrom, $to, $nameto, $subject, $message);				
							
			} */
		}
	}
?>
</div>
<form name="form" id="form" action="" method="post">
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td scope="row">Candidate Detail</td>
    <td width="2%">:</td>
    <td>
	<select name="candidatedetails" id="candidatedetails" style="width:200px;">
      <option value="traineeid">Candidate ID</option>
      <option value="firstname">First Name</option>
      <option value="lastname">Last Name</option>
      <option value="dob">Date Of Birth</option>
    </select>
	<input type="text" style="width:300px;" name="candidatedetails_s" id="candidatedetails_s" />
	<input type="submit" name="button" id="button" value="Search" />
	</td></tr> 
</table>
<?php 
	$candidatedetails=$_POST['candidatedetails']; 
	if($candidatedetails != 'dob'){
		
		$candidatedetails_s=$_POST['candidatedetails_s'];
	}else{
		$candidatedetails_s=strtotime($_POST['candidatedetails_s']); 	
	}
?>
</form><form name="form1" id="form1" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right"><input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
				<input type="submit" name="multiplereset" id="multiplereset" value="Reset Password" onClick="this.form.action='<?//=$CFG->wwwroot. '/candidatemanagement/masterresetuser.php';?>'" />
			</td>
		</tr>    
	</table>
	
<?php
	$statement="
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
	";
	
	$statement.=" WHERE  b.status='0' AND b.enrol='manual' AND (d.usertype='Active candidate' OR d.usertype='Inactive candidate' OR d.usertype='Prospect') 
				AND d.id != '2' And d.deleted != '1' And d.confirmed = '1' And d.id != '1' And a.category='1'";
	if($candidatedetails_s!=''){
		$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
	}
	$csql="SELECT b.courseid, d.traineeid, d.email, d.firstname, d.lastname, d.dob, a.fullname, d.usertype, d.id as userid FROM {$statement}";
	$csql.=" GROUP BY d.traineeid ORDER BY d.traineeid";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="11%" scope="row">Candidate ID</th>
		  <th width="15%">First Name</th>
		  <th width="15%">Last Name</th>
		  <th width="8%">DOB</th>
		  <th>CIFA&#8482; Program Title</th>
		  <th width="8%"> Status</th>
		  <th width="1%">&nbsp;</th>
		  <th width="1%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/candidatemanagement/candidateexamsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['courseid'];
	$linktitle="Clickable and takes to ".get_string('candidateexamsummary');
	$bil=$no++;
?>
		<tr>
		  <td scope="row" align="center"><a href="<?=$linkto;?>" title="<?=$linktitle;?>" target="_blank"><?=strtoupper($sqlrow['traineeid']);?></a></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
		  <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y', $sqlrow['dob']);?></td>
		  <td>
			<?php
				//list out cifa program title
				$enrolsql=mysql_query("
					Select
					  *
					From
					  mdl_cifacourse a Inner Join
					  mdl_cifaenrol b On a.id = b.courseid Inner Join
					  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
					  mdl_cifauser d On c.userid = d.id
					Where
					  c.userid = '".$sqlrow['userid']."' And
					  b.enrol = 'manual' And
					  a.category = '1' And
					  a.visible = '1' And
					  b.status = '0'				
				");
				while($euser=mysql_fetch_array($enrolsql)){
				echo '- '.$euser['fullname'].'<br/>';
				}
			?>
			<?//=$sqlrow['fullname'];?>
		  </td>
		  <td><?=$sqlrow['usertype'];?></td>
		  <td align="center"><input type="submit" name="updatedetail" id="updatedetail" value="Update Detail" onMouseOver="style.cursor='hand'" onClick="this.form.action='<?=$CFG->wwwroot. '/user/edit.php?id='.$sqlrow['userid'].'&course=1';?>'" /></td>
		  <td style="text-align:center;"><input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['userid'];?>" /></td>		
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="8" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form>	
		<form name="form" id="form" action="" method="post">
		<table width="95%" border="0" style="margin:0px auto; padding:0px; border: 0px solid #666666; border-collapse:collapse;">
			<tr>
			  <td align="right">
				<?php
					$candidatedetails=$_POST['candidatedetails']; 
					if($candidatedetails != 'dob'){
						
						$candidatedetails_s=$_POST['candidatedetails_s'];
					}else{
						$candidatedetails_s=strtotime($_POST['candidatedetails_s']); 	
					}				
					$printto=$CFG->wwwroot. '/candidatemanagement/cifacandidatemanagement_print.php?xtext='.$candidatedetails.'&xtext2='.$candidatedetails_s;
				?>
				<input type="submit" name="buttonprint" id="buttonprint" value="Print" onClick="this.form.action='<?=$printto;?>', target='_blank'" />
				<input type="submit" name="buttonback" id="buttonback" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="<?=get_string('back');?>" />
			  </td>
			</tr>    
		</table></form>	
		<br/>	  
  
  </fieldset>

<?php 
	echo $OUTPUT->footer();
?>