<?php	
    require_once('config.php');
	include('manualdbconfig.php'); 
	include_once ('pagingfunction.php');
	
	
	$site = get_site();
	
	$heading=get_string('transactionstatus');
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	
	$PAGE->navbar->add($heading);	
	$PAGE->set_pagelayout('buy_a_cifa');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	//echo $OUTPUT->heading($heading, 2, 'headingblock header');
	
	$sql="SELECT * FROM mdl_cifauser";
	$query=mysql_query($sql);
?>
<style>
<?php 
	include('css/style2.css'); 
	include('css/button.css');
	include('css/pagination.css');
	include('css/grey.css');
?>
</style>
<!---Search------>

<link rel="stylesheet" type="text/css" media="all" href="offlineexam/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="offlineexam/jquery.1.4.2.js"></script>
<script type="text/javascript" src="offlineexam/jsDatePick.jquery.min.1.3.js"></script>
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
  if(document.formname.cariandate.value == true) {
    return false
  }
  else {
	document.formname.dob2.value=document.formname.cariandate.value;
  }
  return true;
}	
</script>
<div style="min-height: 390px;">
<form id="formname" name="formname" method="post" onClick="return displ();">
<!--fieldset id="fieldset"><legend id="legend">Search candidate</legend-->
<table border="0" cellpadding="1" cellspacing="1" style="margin-top:30px; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr>
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian" style="width:180px;">
			<option value=""> - select - </option>
			<option value="traineeid"><?=get_string('candidateid');?></option>
			<option value="name"><?=get_string('name');?></option>
            <option value="email"><?=get_string('email');?></option>
		</select>
		</td>
		<td width="10%"><input type="text" name="traineeid" style="width:250px;" /></td>
		<td width="10%">
		<select name="status" style="width:180px;">
			<option value=""> - status - </option>
			<option value="pending"><?=get_string('new');?></option>
			<option value="paid">Paid</option>
            <option value="cancel">Cancel</option>
		</select>		
		</td>
		<td><input type="submit" name="search" value="<?=get_string('search');?>"/></td>
	</tr>	
	<tr>
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian2" style="width:180px;">
			<option value=""> - select - </option>
			<option value="traineeid"><?=get_string('candidateid');?></option>
			<option value="name"><?=get_string('name');?></option>
            <option value="email"><?=get_string('email');?></option>
		</select>
		</td>
		<td width="10%"><input type="text" name="traineeid2" style="width:250px;" /></td>
		<td width="10%">
		<select name="paymethod" style="width:180px;">
			<option value=""> - payment method - </option>
			<option value="telegraphic">Telegraphic Transfer</option>
			<option value="creditcard">Credit Card</option>
            <option value="paypal">Paypal</option>
		</select>		
		</td>		
	</tr> 	
</table><!--/fieldset-->
</form>
<!---End search---->

<?php 
	$selectsearch=$_POST['pilihancarian']; 
	$candidateid=$_POST['traineeid']; 
	$selectsearch2=$_POST['pilihancarian2']; 
	$candidateid2=$_POST['traineeid2']; 
	$status=$_POST['status']; 
	$paymethod=$_POST['paymethod']; 
?>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="8%" align="left"><strong><?=get_string('candidateid');?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=get_string('name');?></strong></th>
    <th class="adjacent" width="18%" align="left"><strong><?=get_string('email');?></strong></th>
    <th class="adjacent" width="22%" style="text-align:left;"><?=get_string('coursemodule');?></th>	
    <th class="adjacent" width="10%" style="text-align:center;"><?=get_string('paymentmethod');?></th>
	<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('datepurchase');?></th>
	<th class="adjacent"  style="text-align:center;"><?=get_string('status');?></th>
	<th class="adjacent"  style="text-align:center;">#</th>
  </tr>
<?php
	$row=mysql_fetch_array($query);
	if($row['id'] >= 1){ 
	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 12;
    $startpoint = ($page * $limit) - $limit;
	
	//collect user to list out on table
	$statement=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse="SELECT * FROM {$statement} WHERE b.paymethod!=''";
	if($status != ''){ $sqlcourse.= " AND ((b.paystatus LIKE '%".$status."%'))"; }
	if($paymethod != ''){ $sqlcourse.= " AND ((b.paymethod LIKE '%".$paymethod."%'))"; }
	
	if($candidateid!='' && $selectsearch!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%'))";}
	if($candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch2 LIKE '%".$candidateid2."%'))";}			
	if($candidateid!='' && $selectsearch!='' && $candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%') AND ($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	$sqlcourse.=" Group By b.confirmationno Order By b.date DESC, a.traineeid DESC";
	//$sqlcourse.=" LIMIT {$startpoint} , {$limit}";	
		
	$sqlquery=mysql_query($sqlcourse);
	$no='1';
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++; 
?>
<?php 
	//payment status
	$newstatus='new';
	$pendingstatus='pending';	
	$paidstatus='paid';
	$corruptedstatus='corrupted';
	$cancelstatus='cancel';	
	$confirmedpay='Click confirm if payment have been confirm';
	$deletesubscribed='Delete subscribed';
	
	//color row
	$pstatus1=$sqlrow['paystatus'] == $pendingstatus;
	$pstatus2=$sqlrow['paystatus'] == $paidstatus;
	
	$color1='background-color:#fff;'; //pending
	$color2='background-color:#81F781;'; //paid
	$color3='background-color:#FA5858;'; //cancel
?>
  <tr style="<?php if ($pstatus1){ echo $color1; }else if ($pstatus2){ echo $color2; }else{ echo $color3; } ?>">
    <td class="adjacent" width="1%" align="center"><?php echo $bil+($startpoint); ?></td>
	<td class="adjacent" style="text-align:left;"><?=strtoupper($sqlrow['traineeid']);?></td>
	<td class="adjacent" style="text-align:left;">
		<?php 
			//view user fullname
			echo ucwords(strtolower($sqlrow['name'])); 
		?>
	</td>
    <td class="adjacent" style="text-align:left;">
		<?php echo $sqlrow['email']; ?>
	</td>
	<td class="adjacent" style="text-align:left;">
	<?php 
		//senarai kursus yang dibeli		
		if($sqlrow['paymethod'] == 'telegraphic'){
			$sqluser=mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '".$sqlrow['traineeid']."' And b.paymethod='telegraphic' And b.date='".$sqlrow['date']."'
			");
		}
		if($sqlrow['paymethod'] == 'paypal'){
			$sqluser=mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '".$sqlrow['traineeid']."' And b.paymethod='paypal' And b.date='".$sqlrow['date']."'
			");
		}
		if($sqlrow['paymethod'] == 'creditcard'){
			$sqluser=mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '".$sqlrow['traineeid']."' And b.paymethod='creditcard' And b.date='".$sqlrow['date']."'
			");
		}		
		
		$b='1';
		while($suser=mysql_fetch_array($sqluser)){
		
		$slecourse=mysql_query("Select * From mdl_cifacourse Where id='".$suser['productid']."'");
		$qselcourse=mysql_fetch_array($slecourse);
		
		echo $b++.') - '.$qselcourse['fullname'].'<br/>';
		}
	?>
	</td>	
    <td class="adjacent" style="text-align:left;">
		<?php 
			if($sqlrow['paymethod'] == 'telegraphic'){
				$telegraphic = 'Bank transfer';
				echo ucwords(strtolower($telegraphic));
			}
			if($sqlrow['paymethod'] == 'paypal'){
				$paypal = 'Paypal';
				echo ucwords(strtolower($paypal));
			}
			if($sqlrow['paymethod'] == 'creditcard'){
				$creditcard = 'Credit card';
				echo ucwords(strtolower($creditcard));
			}			
		?>
	</td>
    <td class="adjacent" style="text-align:center;">
		<?php $datepurchase=$sqlrow['date']; echo date('d-m-Y',$datepurchase); ?>
	</td>
    <td class="adjacent" style="text-align:center; vertical-align:middle;">
		<form name="formconfirm" method="post">
		<?php
			$beli=date('d-m-Y H:i:s', $sqlrow['date']);
			$bex=date('d-m-Y H:i:s',strtotime($beli . " + 2 month"));
			$expiry=strtotime(date('d-m-Y H:i:s',strtotime($beli . " + 2 month")));
			
			$beforeexpiry=strtotime(date('d-m-Y H:i:s',strtotime($bex . " - 14 day")));	// 2 week before expiry
			//$expiry=strtotime(date('d-m-Y H:i:s',strtotime($beli)));
			$today = strtotime('now');
				
			if ($sqlrow['paystatus'] == $pendingstatus) {
				if($sqlrow['paymethod'] != 'telegraphic'){
					//if credit card or paypal
					$confirmbutton="<input onMouseOver=\"style.cursor='pointer'\" type=\"button\" value=".get_string('confirm')." name=\"nottelegraphic\" onClick=\"alert('This payment method not available.')\" \>";
					echo $confirmbutton;
				}else{	
				
					// Set email notification (IPD candidate enrollment confirmation).
					$sqlsupportemail=mysql_query("SELECT * FROM {$CFG->prefix}config WHERE name='supportemail'");
					$q_supportemail=mysql_fetch_array($sqlsupportemail);
					$supportemail=$q_supportemail['value'];
				
					// send email 2 week before expiry
					//Reminder:  CANDIDATE ID - Enrolment Not Complete
					if($today == $beforeexpiry){
					// email to commenter
						$to = $sqlrow['email'];
						$subject = "Reminder:  CANDIDATE ID - Enrolment Not Complete";
						
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".strtoupper($sqlrow['name'])."),</p>
							<p>IPD Candidate ID: ".strtoupper($sqlrow['traineeid'])."</p>
							
							<p style='text-align:justify;'>This is a brief reminder that your enrolment process is not complete.</p>										
							<p style='text-align:justify;'>We have yet to receive the payment via bank transfer and your user status is currently prospect.</p>
							<p style='text-align:justify;'>In order for you to enjoy the benefit of the training program and gain access to the online training portal, a complete enrolment inclusive of payment must be completed within duration of 4 weeks from the point you do the part-enrolment process online.  If we do not receive the payment within the stipulated timeline, your enrolment will be cancelled.</p> 
							<p style='text-align:justify;'>However, if you have remitted the payment and received a confirmation from us on the payment receipt, kindly ignore this email. Once we have cleared the payment, your status will be updated to active candidate and you may continue with your training via IPD Online.</p> 
							<p style='text-align:justify;'>If your employer sponsors your training, it might be a good idea to check that the payment is on its way to us.</p> 
							<p style='text-align:justify;'>We are looking forward to welcoming you as our active candidate. </p> 
							
							<p style='text-align:justify;'>&nbsp;</p> 

							<p>Yours Sincerely, <br>
							<strong>SHAPE&reg; Knowledge Services</strong></p>
							<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
							This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
							</body>
							</html>
						";
						
						// Always set content-type when sending HTML email
						$link=$CFG->wwwroot;
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
						// More headers
						$headers .= 'From: <'.$supportemail.'>' . "\r\n";
						//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
						
						mail($to,$subject,$message,$headers);
						// end email config	
					} // End send email 2 week before expiry
				
					//if telegraphic 
					if($today > $expiry){
						//Dah expiry.
						$sqltransaction=mysql_query("UPDATE {$CFG->prefix}orders SET paystatus='".$cancelstatus."' WHERE paystatus='".$pendingstatus."' AND paymethod='telegraphic'"); 
						$linkconfirm=$CFG->wwwroot. "/image/not.png";
						$confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User cancel to proceed payment" />';
						echo $confirmbutton; 
						
						// Next Step:  CANDIDATE ID - Candidate Enrolment Cancellation
						// email to commenter
						$to = $sqlrow['email'];
						$subject = "Next Step:  CANDIDATE ID - Candidate Enrolment Cancellation";
						
						$message = "
							<html>
							<head>
								<title>HTML email</title>
							</head>
							<body>
							<p>Dear (".strtoupper($sqlrow['name'])."),</p>
							<p>IPD Candidate ID: ".strtoupper($sqlrow['traineeid'])."</p>
							<p style='text-align:justify;'>
							We regret to inform you that your enrolment has been cancelled thus you will not be able to pursue your training with us. However, if you have remitted the payment, kindly contact us to resolve the misunderstanding. 
							</p>
																		
							<p style='text-align:justify;'>
							If you still wish to enroll as a SHAPE® IPD candidate, please repeat the enrolment process and remit the payment within the stipulated timeline. However, we wish to remind you that you may not be entitled to any promotions which you signed up for earlier. </p>

							<p style='text-align:justify;'>&nbsp;</p> 

							<p>Yours Sincerely, <br>
							<strong>SHAPE&reg; Knowledge Services</strong></p>
							<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
							This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
							</body>
							</html>
						";
						
						// Always set content-type when sending HTML email
						$link=$CFG->wwwroot;
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
						// More headers
						$headers .= 'From: <'.$supportemail.'>' . "\r\n";
						//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
						
						mail($to,$subject,$message,$headers);
						// end email config							
						
			
					}else{ 
						//jika belom di sahkan dan belom expiry oleh admin.
						echo '<div style="padding:5px;">';
						?>
						<input title="<?=$confirmedpay;?>" onClick="this.form.action='<?=$CFG->wwwroot ."/transaction_status.php?confirmuser=".$sqlrow['customerid']."&orderid=".$sqlrow['orderid']."&datepurchase=".$sqlrow['date'];?>'" onMouseOver="style.cursor='pointer'" type="submit" name="sahbeli" value="<?=get_string('confirm');?>"/>
						<?php
						echo '</div>';
						
						if($_POST['sahbeli']){						
							$confirmuser=$_GET['confirmuser'];
							$datepurchase=$_GET['datepurchase'];
							$ordercourseid=$_GET['orderid'];
							
							$selectgetuser=mysql_query("
								Select
									*
								From
									mdl_cifacandidates a Inner Join
									mdl_cifaorders b On a.serial = b.customerid Inner Join
									mdl_cifaorder_detail c On b.serial = c.orderid
								Where
								  b.customerid = '".$confirmuser."' And c.orderid='".$ordercourseid."' And b.date='".$datepurchase."'
							");
							while($sgetuser=mysql_fetch_array($selectgetuser)){
								$yes=$sgetuser['traineeid'];
								$getcourseid=$sgetuser['productid'];
								$price=$sgetuser['price'];
								//echo $getcourseid;
								
								$senroluser=mysql_query("Select * From mdl_cifaenrol Where enrol = 'manual' And courseid='".$getcourseid."' And status='0'");
								$qenroluser=mysql_fetch_array($senroluser);
								$getenrolid=$qenroluser['id'];
								$gotuser=$sgetuser['candidateid'];
								
								$uselectuser=mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='".$yes."'");
								$qselectuser=mysql_fetch_array($uselectuser);
								$usercountid=mysql_num_rows($qselectuser);
								$ucadidateid=$qselectuser['id'];	
								
								// candidate fullname
								$ucfirstname=$qselectuser['firstname'];	
								$uclastname=$qselectuser['lastname'];
								$ucmiddlename=$qselectuser['middlename'];
								if($ucmiddlename!=''){
									$ucfullname=$ucfirstname.' '.$ucmiddlename.' '.$uclastname;
								}else{ $ucfullname=$ucfirstname.' '.$uclastname; }
															
								$rolesstatement="SELECT * FROM mdl_cifarole";
								$pilihroles=mysql_query("{$rolesstatement} WHERE id='5'");
								$ourroles=mysql_fetch_array($pilihroles);
								$ourrolesname=$ourroles['name'];
								
								$rolestype=mysql_query("SELECT * FROM mdl_cifarole_assignments WHERE userid='".$ucadidateid."'");
								$rpros=mysql_num_rows($rolestype);
								
								//untuk first registration
								if($sqlrow['candidateid'] == '0'){
									//update confirm value
									$ucuser=mysql_query("UPDATE mdl_cifauser SET confirmed='1' WHERE traineeid='".$yes."'");
								} //end first register - new user
								
								if($rpros!='0'){
									//set userrole for prospect users
									$ucuser=mysql_query("UPDATE mdl_cifauser SET usertype='".$ourrolesname."' WHERE traineeid='".$yes."'");	
								}								

								//update candidateid=>usercandidateid dalam candidates table
								$ucandidates=mysql_query("UPDATE mdl_cifacandidates SET visible='0', candidateid='".$ucadidateid."' WHERE traineeid='".$yes."'");
								$select30=mysql_query("SELECT * FROM mdl_cifacandidates WHERE candidateid='".$ucadidateid."' AND traineeid='".$yes."'");
								$q30=mysql_fetch_array($select30);
								if($q30){
									$ucandidates=mysql_query("UPDATE mdl_cifaorders SET paystatus='".$paidstatus."' WHERE date='".$sgetuser['date']."' AND paymethod='telegraphic' AND customerid='".$q30['serial']."'");
								}
																
								//enrol user to course //to check if user never enrol for this course
								$scuser=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE enrolid='".$getenrolid."' AND userid='".$ucadidateid."'");
								$ucount=mysql_num_rows($scuser);
								
								//echo $getcourseid.'-'.$ucadidateid;
								if($ucount=='0'){
									// echo 'yoyoyoyo';
									$today = strtotime('now');
									$expiring_date=strtotime('now + 2 months'); //expiring date
									$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
															SET enrolid='".$getenrolid."', userid='".$ucadidateid."', timestart='".$today."', timeend='".$expiring_date."',
															timecreated='".$today."', timemodified='".$today."',
															modifierid='2', emailsent='1'");
									
									//enrol user to CHAT									
									$sqlchat=mysql_query("INSERT INTO mdl_cifauser_enrolments 
															SET enrolid='144', userid='".$ucadidateid."', timestart='".$today."', timeend='".$expiring_date."',
															timecreated='".$today."', timemodified='".$today."',
															modifierid='2', emailsent='1'");	

									//enrol exam //	
									$enrolexam=mysql_query("
										Select
										  b.enrol,
										  a.fullname,
										  b.courseid,
										  b.id as enrolid
										From
										  mdl_cifacourse a Inner Join
										  mdl_cifaenrol b On a.id = b.courseid
										Where
										  b.enrol = 'manual' And a.visible!='0' And
										  (a.category = '3' Or a.category = '9' Or a.category='4')									
									");
									$cexam=mysql_num_rows($enrolexam);
									while($eexam=mysql_fetch_array($enrolexam)){
									$sqlexam=mysql_query("INSERT INTO mdl_cifauser_enrolments 
															SET enrolid='".$eexam['enrolid']."', userid='".$ucadidateid."', timestart='".$today."', timeend='".$expiring_date."',
															timecreated='".$today."', timemodified='".$today."',
															modifierid='2', emailsent='1'");
															
									//to define exam contextid
									$sexam=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$eexam['courseid']."'");
									$Le=mysql_fetch_array($sexam);
									$examcontextid=$Le['id'];
									
									$userassignments=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE roleid='5' AND userid='".$ucadidateid."' AND contextid='".$examcontextid."'");
									$cuseruserassignments=mysql_num_rows($userassignments);
									if($cuseruserassignments=='0'){
										$sqlassignexam=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$examcontextid."', userid='".$ucadidateid."', modifierid='2', timemodified='".$today."'");
									}
									
									//update token, center ID, token start date, token expiry
									$selectusertoken=mysql_query("SELECT * FROM {$CFG->prefix}user_accesstoken WHERE userid='".$ucadidateid."' AND courseid='64'");
									$cusertoken=mysql_num_rows($selectusertoken);
									if($cusertoken=='0'){
										$access_token=uniqid(rand());
										$tokencreated=strtotime('now'); //token start
										$tokenexpiry=strtotime(date('d-m-Y H:i:s',$tokencreated) . " + 2 month"); //token expiry
										
										$sqlUP=mysql_query("INSERT INTO {$CFG->prefix}user_accesstoken SET user_accesstoken='".$access_token."',
											timecreated_token='".$tokencreated."', tokenexpiry='".$tokenexpiry."', userid='".$ucadidateid."', courseid='".$eexam['courseid']."'") 
										or die("Not update".mysql_error());	
									}
									//End update
										
									}
									//end exam
									
									
									
									//to define contextid course
									$sL=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$getcourseid."'");
									$L=mysql_fetch_array($sL);
									$contextid=$L['id'];
									
									//to define contextid chat
									$sLchat=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='44'");
									$Lchat=mysql_fetch_array($sLchat);
									$chatcontextid=$Lchat['id'];

									//to define contextid feedback
									$sfback=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='57'");
									$fback=mysql_fetch_array($sfback);
									$fbackcontextid=$fback['id'];									
									
									//semak ada ke tak ade
									$userassignments2=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE roleid='5' AND userid='".$ucadidateid."' AND contextid='".$contextid."'");
									$cuseruserassignments2=mysql_num_rows($userassignments2);
									if($cuseruserassignments2=='0'){
										//course
										$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$contextid."', userid='".$ucadidateid."', modifierid='2', timemodified='".$today."'");
										//chat
										$sqlassignchat=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$chatcontextid."', userid='".$ucadidateid."', modifierid='2', timemodified='".$today."'");								
										//chat
										$sqlassignfback=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$fbackcontextid."', userid='".$ucadidateid."', modifierid='2', timemodified='".$today."'");
									}	

									//extend///purchase detais to statement DB
									$descsubcribe='Payment';
									$istatementsql=mysql_query("
									INSERT INTO mdl_cifastatement
									SET 
										candidateid='".$yes."',
										courseid='".$getcourseid."', 
										remark='".$descsubcribe."', 
										credit1='".$price."',
										paymentdate='".$today."',
										status='1'
									");
									
									// email to commenter
									$to = $sqlrow['email'];
									$subject = "Next Step:  CANDIDATE ID - Candidate Enrolment Confirmation >> IPD COURSE TITLE";
									
									$message = "
										<html>
										<head>
											<title>HTML email</title>
										</head>
										<body>
											<p>Dear (".strtoupper($ucfullname)."),</p>
										<p>IPD Candidate ID: ".strtoupper($yes)."<br/>
										Temporary password: ".get_string('temporarypassword')."
										</p>
										<p style='text-align:justify;'>
										I am pleased to welcome you as a new candidate to Islamic Professional Development (IPD) Training Program.
										</p>
											
										<p style='text-align:justify;'>
										You have taken the first step to enhance your knowledge in Islamic Finance. Your Candidate ID is <strong>".strtoupper($yes)."</strong>. Please quote this in all future correspondence with us. You may proceed to the first time login to your IPD Online by using the Candidate ID and the temporary password given in this email. </p>

										<p style='text-align:justify;'>
										IPD Online enables you access to the online training portal, update personal details i.e. address/email, participate in the community activities, access to candidate support area, attempting your test online, viewing your result and certification.</p> 

										<p style='text-align:justify;'>
										Since you have opted for IPD, you will be entitled to Certificate of Completion for each course you pass. You will not be required to take other examination as it is not part of the program requirement.</p>

										<p style='text-align:justify;'>However, along the way if you wish to enroll for  the CIFA&#8482; Certification program, you may proceed to  purchase the CIFA Curriculum Trainings. For more information on CIFA&#8482;  Curriculum, please visit <a href='http://www.Learncifa.com/structure'>www.Learncifa.com/structure</a>  </p>

										<p style='text-align:justify;'>As an active IPD Candidate, you may start your IPD  courses via <u>Active Training</u> link under <strong>&quot;My Training&quot;</strong>. You will be able to see the SHAPE&reg; IPD courses that  you have chosen. Click on the <strong>LAUNCH</strong> button to begin your training.</p>

										<p style='text-align:justify;'>You may now proceed to login to your IPD Online  using the link below<br>
										  <a href='http://ipdonline.consultshape.com'>ipdonline.consultshape.com</a>    </p>
										<p style='text-align:justify;'>&nbsp;</p> 

										<p>Yours Sincerely, <br>
										<strong>SHAPE&reg; Knowledge Services</strong></p>
										<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
										  This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
										</body>
										</html>
									";
									
									// Always set content-type when sending HTML email
									$link=$CFG->wwwroot;
									$headers = "MIME-Version: 1.0" . "\r\n";
									$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
									
									// More headers
									$headers .= 'From: <'.$supportemail.'>' . "\r\n";
									//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
									
									mail($to,$subject,$message,$headers);
									// end email config
									
								}else{
									///////////// Extend course ///////									
									$choose=mysql_query("
										Select
										  a.fullname,
										  b.courseid,
										  c.enrolid,
										  d.firstname,
										  d.lastname,
										  d.traineeid,
										  c.userid,
										  c.timecreated,
										  c.timestart,
										  c.timeend
										From
										  mdl_cifacourse a Inner Join
										  mdl_cifaenrol b On a.id = b.courseid Inner Join
										  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
										  mdl_cifauser d On c.userid = d.id
										Where
										  b.courseid ='".$getcourseid."' And
										  c.userid = '".$ucadidateid."'	
									");	
									$sqldisplay=mysql_fetch_array($choose);	
									
									if(($sqlrow['traineeid']==$yes) && ($sqlrow['productid']==$getcourseid)){
										$signupdate=date('d-m-Y H:i:s', $sqldisplay['timestart']);
										$enddate=strtotime($signupdate . " + 2 month");
										
										$start=$sqldisplay['timestart']; //subscribe start
										$timeendcourse=$sqldisplay['timeend']; //subscribe start
										$expired2=strtotime($signupdate . " + 2 month"); //subscribe end
										
										$todaydate=strtotime('now');									
									
										/*  mdl_cifauser_enrolments */
										//extend for 2 months once
										$update_time_start=strtotime(date('M d, Y', $timeendcourse));
										$u_timeend=strtotime(date('M d, Y',$timeendcourse) . " + 2 month");

										$enrolupdate=mysql_query("
											UPDATE {$CFG->prefix}user_enrolments SET timeend='".$u_timeend."', timestart='".$update_time_start."'
											WHERE status='0' AND userid='".$ucadidateid."' AND enrolid='".$sqldisplay['enrolid']."'
										");
										
										//instanceid
										$sexam=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$getcourseid."'");
										$Le=mysql_fetch_array($sexam);
										$examcontextid=$Le['id'];				
										
										//assigned roled.				
										$sqlassignexam=mysql_query("UPDATE {$CFG->prefix}role_assignments SET timemodified='".$todaydate."' WHERE contextid='".$examcontextid."' AND userid='".$ucadidateid."'");
														
										//extend///purchase detais to statement DB
										$extendcost='50'; //cost for extend
										$descsubcribe='Payment';
										$istatementsql=mysql_query("
										INSERT INTO mdl_cifastatement
										SET 
											candidateid='".$yes."',
											courseid='".$getcourseid."', 
											remark='".$descsubcribe."', 
											credit1='".$extendcost."',
											paymentdate='".$today."',
											status='1'
										");	
									
									if($enrolupdate){
										// email to commenter
										// Notice: CANDIDATE ID - Successful Online Training Program Extension
										$to = $sqlrow['email'];
										$subject = "Notice: CANDIDATE ID - Successful Online Training Program Extension";
										$message = "
											<html>
											<head>
												<title>HTML email</title>
											</head>
											<body>
											<p>Dear (".ucwords(strtolower($ucfullname))."),</p>
											<p>Candidate ID: ".strtoupper($sqlrow['traineeid'])."</p>
											
											<p style='text-align:justify;'>We are pleased to inform you that your extension request for the subscription to the ".$sqldisplay['fullname']." is successful. We are pleased to extend the subscription for another 2 months. Please proceed to the training program as usual. </p>
												
											<p style='text-align:justify;'>
											If you have opted to wire transfer the payment, this should be received by SHAPE® no later than 30 days from the date you made the extension request. Once your payment has been received and cleared, you will be able to continue your online training program as usual.
											</p>

											<p style='text-align:justify;'>
											If your account is not fully paid up within the stipulated deadline, SHAPE® reserve the right to withdraw your extension request.  
											</p> 

											<p style='text-align:justify;'>
											Please note that it is the responsibility of the candidate to ensure that the validity period of your IPD Courses online.  Please refer to the <u>IPD Online Policy</u> for more information.  
											</p>
											
											<p style='text-align:justify;'>&nbsp;</p> 

											<p>Yours Sincerely, <br>
											<strong>SHAPE&reg; Knowledge Services</strong></p>
											<p style='font-size:11px'><strong>Disclaimer:</strong> <br>
											  This is a system  generated email. Please do not reply. For assistance, please <strong><u>contact us</u></strong> and we will revert back to you within 72 hours. </p>
											</body>
											</html>
										";
										
										// Always set content-type when sending HTML email
										$link=$CFG->wwwroot;
										$headers = "MIME-Version: 1.0" . "\r\n";
										$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
										
										// More headers
										$headers .= 'From: <'.$supportemail.'>' . "\r\n";
										//$headers .= 'Cc: mohd.arizan@mmsc.com.my'. "\r\n";
										
										mail($to,$subject,$message,$headers);
										// end email config										
									}		
									}	
								}	// Extend course																	
							} //end while loop	
						} //end $_POST['sahbeli']					
					} // if not expiry
				} // end paymethod - telegraphic			
			} else if ($sqlrow['paystatus'] == $paidstatus) {
				$linkconfirmpaid=$CFG->wwwroot. "/image/paid.png";
				$imagepaid = '<img src="'.$linkconfirmpaid.'" width="50" title="User already paid & confirmed to access LMS" />';
				echo $imagepaid;
			} else {
				$linkconfirmcancel=$CFG->wwwroot. "/image/cancelp.png";
				$imagecancel = '<img src="'.$linkconfirmcancel.'" width="68" title="User cancel to proceed payment" />';
				echo $imagecancel;	
			}		
		?>
		</form>
	</td>
	<td class="adjacent" style="text-align:center; vertical-align:middle;">
	<form name="deleteform" method="post">
	<?php
		if ($sqlrow['paystatus'] == $pendingstatus) {
		$linkdelete=$CFG->wwwroot. "/image/not.png";
		$imagedelete= '<img src="'.$linkdelete.'" width="15" title="Delete module subscribed" />';	
	?>
	<input onClick="this.form.action='<?=$CFG->wwwroot ."/transaction_status.php?orderid=".$sqlrow['orderid'];?>'" name="submitimage" type="image" id="submit" value="submit" src="<?=$linkdelete;?>" width="15" title="<?=$deletesubscribed;?>" />
	<?php
	if (isset($_GET['orderid'])) {
		if($_GET['orderid']==$sqlrow['orderid']){
			$sqldelete=mysql_query("UPDATE {$CFG->prefix}orders SET paystatus='".$cancelstatus."' WHERE paystatus='".$pendingstatus."' AND serial='".$_GET['orderid']."'");
			//$sqlupdatevisible=mysql_query("UPDATE {$CFG->prefix}candidates SET visible='1' WHERE traineeid='".$sqlrow['traineeid']."'");
			//delete record from cifa user with confirmed=0
			$remove=mysql_query("DELETE FROM mdl_cifauser WHERE traineeid='".$sqlrow['traineeid']."' AND confirmed='0'");
		}
	}
	}else if ($sqlrow['paystatus'] == $paidstatus) {
		$linkconfirmpaid=$CFG->wwwroot. "/image/yes.png";
		$imagepaid = '<img src="'.$linkconfirmpaid.'" width="15" title="User already paid & confirmed to access LMS" />';
		echo $imagepaid;
	}else if ($sqlrow['paystatus'] == $cancelstatus) {
		$linkcancelpaid=$CFG->wwwroot. "/image/not.png";
		$imagecancel = '<img src="'.$linkcancelpaid.'" width="15" title="Already cancel" />';
		echo $imagecancel;
	}	
	?>
	</form>
	</td>
  </tr>
<?php 	} // end while	 
		if($sqlInsert){ 
		?>
			<script language="javascript">
				window.alert("<?=strtoupper($q30['traineeid']).' '.$confirmuser.'-'.$datepurchase;?> has been confirmed.");
				window.location.href = '<?=$CFG->wwwroot. "/transaction_status.php";?>'; 
			</script>
		<?php 
			//redirect/reload page.	
			//$urlredirect=$CFG->wwwroot.'/transaction_status.php';
			//redirect($urlredirect);
		}
		if($sqldelete){
			//redirect/reload page.	
			//$urlredirect=$CFG->wwwroot.'/transaction_status.php';
			//redirect($urlredirect);
		?>
			<script language="javascript">
				//window.alert("<?=strtoupper($q30['traineeid']).' '.$confirmuser.'-'.$datepurchase;?> has been confirmed.");
				window.location.href = '<?=$CFG->wwwroot. "/transaction_status.php";?>'; 
			</script>
		<?php
		}
 }else{ ?> 
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