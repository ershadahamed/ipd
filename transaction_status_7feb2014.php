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
				$telegraphic = 'Telegraphic transfer';
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
			$expiry=strtotime(date('d-m-Y H:i:s',strtotime($beli . " + 3 month")));
			//$expiry=strtotime(date('d-m-Y H:i:s',strtotime($beli)));
			$today = strtotime('now');
				
			if ($sqlrow['paystatus'] == $pendingstatus) {
				if($sqlrow['paymethod'] != 'telegraphic'){
					//if credit card or paypal
					//$confirmbutton = "<a href=\"user.php?confirmuser=".$userscolumn['id']."&amp;sesskey=".sesskey()."\">" . get_string('confirm') . "</a>";
					//$confirmbutton="<a onClick=\"alert('This payment method not available.')\" />".get_string('confirm')."</a>";
					$confirmbutton="<input onMouseOver=\"style.cursor='pointer'\" type=\"button\" value=".get_string('confirm')." name=\"nottelegraphic\" onClick=\"alert('This payment method not available.')\" \>";
					echo $confirmbutton;
				}else{	
					//if telegraphic
					if($today > $expiry){
						//Dah expiry.
						$sqltransaction=mysql_query("UPDATE {$CFG->prefix}orders SET paystatus='".$cancelstatus."' WHERE paystatus='".$pendingstatus."' AND paymethod='telegraphic'"); 
						$linkconfirm=$CFG->wwwroot. "/image/not.png";
						$confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User cancel to proceed payment" />';
						echo $confirmbutton; 
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
								//echo $getcourseid;
								
								$senroluser=mysql_query("Select * From mdl_cifaenrol Where enrol = 'manual' And courseid='".$getcourseid."' And status='0'");
								$qenroluser=mysql_fetch_array($senroluser);
								$getenrolid=$qenroluser['id'];
								$gotuser=$sgetuser['candidateid'];
								
								$uselectuser=mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='".$yes."'");
								$qselectuser=mysql_fetch_array($uselectuser);
								$ucadidateid=$qselectuser['id'];								
								
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
									$today = strtotime('now');
									$expiring_date=strtotime('now + 3 months'); //expiring date
									$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
															SET enrolid='".$getenrolid."', userid='".$ucadidateid."', timestart='".$today."', timeend='".$expiring_date."',
															timecreated='".$today."', timemodified='".$today."',
															modifierid='2', emailsent='1'");
									
									//enrol user to chat									
									$sqlchat=mysql_query("INSERT INTO mdl_cifauser_enrolments 
															SET enrolid='144', userid='".$ucadidateid."', timestart='".$today."', timeend='".$expiring_date."',
															timecreated='".$today."', timemodified='".$today."',
															modifierid='2', emailsent='1'");															

									//to define contextid
									$sL=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='".$getcourseid."'");
									$L=mysql_fetch_array($sL);
									$contextid=$L['id'];
									
									//to define contextid chat
									$sLchat=mysql_query("SELECT contextlevel, instanceid, id FROM mdl_cifacontext WHERE contextlevel='50' AND instanceid='44'");
									$Lchat=mysql_fetch_array($sLchat);
									$chatcontextid=$Lchat['id'];									
									
									if($rpros!='0'){
										$sqlassign=mysql_query("UPDATE mdl_cifarole_assignments SET roleid='5', contextid='".$contextid."' WHERE userid='".$ucadidateid."'");
										
										//chat
										$sqlassignchat=mysql_query("UPDATE mdl_cifarole_assignments SET roleid='5', contextid='".$chatcontextid."' WHERE userid='".$ucadidateid."'");
									}else{
										$sqlassign=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$contextid."', userid='".$ucadidateid."', modifierid='2', timemodified='".$today."'");
										
										//chat
										$sqlassignchat=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='5', contextid='".$chatcontextid."', userid='".$ucadidateid."', modifierid='2', timemodified='".$today."'");
									}
								}																			
							} //end while loop	
						} //end $_POST['sahbeli']					
					} // if already expiry
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