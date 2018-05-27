<?php	
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$heading=get_string('prospect');
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	
	$PAGE->navbar->add($heading);	
	//$PAGE->set_pagelayout('courses');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($heading, 2, 'headingblock header');
	
	//$sql="SELECT * FROM mdl_cifauser";
	$statement_count=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse_count="SELECT * FROM {$statement_count} WHERE a.candidateid='0' AND b.paystatus='new' AND b.paymethod='' AND b.confirmationno='' AND a.visible='1'";	
	
	$query=mysql_query($sqlcourse_count);
	$recordcount=mysql_num_rows($query);
?>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	include('../css/pagination.css');
	include('../css/grey.css');
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
	<th class="adjacent" width="10%" align="left"><strong><?=get_string('candidateid');?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=get_string('name');?></strong></th>
    <th class="adjacent" width="18%" align="left"><strong><?=get_string('email');?></strong></th>
    <th class="adjacent" width="22%" style="text-align:left;"><?=get_string('coursemodule');?></th>	
	<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('datepurchase');?></th>
	<th class="adjacent"  style="text-align:center;"><?=get_string('action');?></th>
  </tr>
<?php
	$row=mysql_fetch_array($query);
	if($recordcount >= 1){ 
	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 12;
    $startpoint = ($page * $limit) - $limit;
	
	//collect user to list out on table
	$statement=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse="SELECT * FROM {$statement} WHERE a.candidateid='0' AND b.paystatus='new' AND b.paymethod='' AND b.confirmationno='' AND a.visible='1'";
	if($status != ''){ $sqlcourse.= " AND ((b.paystatus LIKE '%".$status."%'))"; }
	if($paymethod != ''){ $sqlcourse.= " AND ((b.paymethod LIKE '%".$paymethod."%'))"; }
	
	if($candidateid!='' && $selectsearch!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%'))";}
	if($candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch2 LIKE '%".$candidateid2."%'))";}			
	if($candidateid!='' && $selectsearch!='' && $candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%') AND ($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	$sqlcourse.=" Group By b.date Order By b.date DESC, a.traineeid DESC";
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
	$confirmedpay='Click confirm to generate password for this prospect';
	$deletesubscribed='Delete subscribed';
	
	//color row
	$pstatus=$sqlrow['paystatus'] == $newstatus;
	$pstatus1=$sqlrow['paystatus'] == $pendingstatus;
	$pstatus2=$sqlrow['paystatus'] == $paidstatus;
	
	$color='background-color:#fff;'; //new
	$color1='background-color:#fff;'; //pending
	$color2='background-color:#81F781;'; //paid
	$color3='background-color:#FA5858;'; //cancel
?>
  <tr style="<?php if ($pstatus1){ echo $color1; }else if ($pstatus2){ echo $color2; }else if ($pstatus){ echo $color; }else{ echo $color3; } ?>">
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
		$sqluser=mysql_query("
			Select
			  *
			From
				mdl_cifacandidates a Inner Join
				mdl_cifaorders b On a.serial = b.customerid Inner Join
				mdl_cifaorder_detail c On b.serial = c.orderid
			Where 
				a.traineeid = '".$sqlrow['traineeid']."' AND b.date='".$sqlrow['date']."' AND
				a.candidateid='0' AND b.paystatus='new' AND b.paymethod='' AND b.confirmationno='' AND a.visible='1'
		");		
		
		$b='1';
		while($suser=mysql_fetch_array($sqluser)){
		
		$slecourse=mysql_query("Select * From mdl_cifacourse Where id='".$suser['productid']."'");
		$qselcourse=mysql_fetch_array($slecourse);
		
		echo $b++.') - '.$qselcourse['fullname'].'<br/>';
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
			$today = strtotime('now');
				
			if ($sqlrow['paystatus'] == $newstatus) {	
					//if telegraphic
					if($today > $expiry){ //jika lebih 3 bulan
						$sqltransaction=mysql_query("UPDATE {$CFG->prefix}orders SET paystatus='".$cancelstatus."' WHERE paystatus='".$pendingstatus."' AND paymethod='telegraphic'"); 
						$linkconfirm=$CFG->wwwroot. "/image/not.png";
						$confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User cancel to proceed payment" />';
						echo $confirmbutton;
					}else{
						echo '<div style="padding:5px;">';
						?>
						<input title="<?=$confirmedpay;?>" onClick="this.form.action='<?=$CFG->wwwroot ."/userfrontpage/prospectstatus.php?confirmuser=".$sqlrow['customerid']."&orderid=".$sqlrow['orderid']."&datepurchase=".$sqlrow['date'];?>'" onMouseOver="style.cursor='pointer'" type="submit" name="sahbeli" value="<?=get_string('confirm');?>"/>
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
								echo $getcourseid;

								//untuk first registration
								if($sqlrow['candidateid'] == '0'){
									//update confirm value
									$ucuser=mysql_query("UPDATE mdl_cifauser SET confirmed='1' WHERE traineeid='".$yes."'");
																					
									$uselectuser=mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='".$yes."'");
									$qselectuser=mysql_fetch_array($uselectuser);
									$ucadidateid=$qselectuser['id'];	
									$cnow=strtotime("now");
									//assign role tu user
									$insertrole=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='16', contextid='1', userid='".$ucadidateid."', modifierid='2', timemodified='".$cnow."'");
									
									$ucandidates=mysql_query("UPDATE mdl_cifacandidates SET candidateid='".$ucadidateid."', visible='0' WHERE traineeid='".$yes."'");
								} //end first register - new user																		
							} //end while loop	
						} //end $_POST['sahbeli']					
					} // if already expiry		
			}		
		?>
		</form>
	</td>
  </tr>
<?php 	} // end while	 
		if($ucandidates){ 
		$prospectfullname=$qselectuser['firstname']." ".$qselectuser['lastname'];
		$prospectusername=strtoupper($qselectuser['traineeid']);
		$prospectpassword="Password01$";
		$prospecttext="Prospect CandidateID and password with name ".$prospectfullname." is ".$prospectusername." and ".$prospectpassword;
		?>
			<script language="javascript">
				window.alert("<?=$prospecttext;?>");
			</script>
		
			
		<?php 
			//redirect/reload page.	
			echo '<br/><br/>';
			$urlredirect=$CFG->wwwroot.'/userfrontpage/prospectstatus.php';
			redirect($urlredirect);
		}
		/*if($sqldelete){
			//redirect/reload page.	
			$urlredirect=$CFG->wwwroot.'/transaction_status.php';
			redirect($urlredirect);		
		}*/
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