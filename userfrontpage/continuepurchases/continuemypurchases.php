<?php	
    require_once('../../config.php');
	include('../../manualdbconfig.php'); 
	include_once ('../../pagingfunction.php');
	
	
	$site = get_site();
	
	$heading=ucwords(strtolower(get_string('continuemypurchases')));
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	
	$PAGE->navbar->add($heading);	
	//$PAGE->set_pagelayout('courses');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($heading, 2, 'headingblock header');
	
	$sql="SELECT * FROM mdl_cifauser";
	$query=mysql_query($sql);
?>
<style>
<?php 
	include('../../css/style2.css'); 
	include('../../css/button.css');
	include('../../css/pagination.css');
	include('../../css/grey.css');
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
<table id="availablecourse" style="margin-top:30px;">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="10%" align="left"><strong><?=get_string('candidateid');?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=get_string('name');?></strong></th>
    <th class="adjacent" width="22%" style="text-align:left;"><?=get_string('coursemodule');?></th>	
	<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('datepurchase');?></th>
	<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('mypurchase');?></th>
  </tr>
<?php
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 12;
    $startpoint = ($page * $limit) - $limit;
	
	//collect user to list out on table
	$statement=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse="SELECT * FROM {$statement} WHERE b.confirmationno='' AND b.paymethod='' AND b.paystatus='new' AND a.traineeid = '".$USER->traineeid."'";
	if($candidateid!='' && $selectsearch!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%'))";}
	if($candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch2 LIKE '%".$candidateid2."%'))";}			
	if($candidateid!='' && $selectsearch!='' && $candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%') AND ($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	$sqlcourse.=" Group By b.date Order By b.date DESC, a.traineeid DESC";	
		
	$sqlquery=mysql_query($sqlcourse);
	$rowcount=mysql_num_rows($sqlquery);
	if($rowcount != '0'){ 	
	$no='1';	
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
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
		}else{
			$sqluser=mysql_query("
				Select
				  *
				From
					mdl_cifacandidates a Inner Join
					mdl_cifaorders b On a.serial = b.customerid Inner Join
					mdl_cifaorder_detail c On b.serial = c.orderid
				Where a.traineeid = '".$sqlrow['traineeid']."' AND b.date='".$sqlrow['date']."'
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
    <td class="adjacent" style="text-align:center;">
		<?php $datepurchase=$sqlrow['date']; echo date('d-m-Y',$datepurchase); ?>
	</td>
    <td class="adjacent" style="text-align:center; vertical-align:middle;">
	<div style="padding:5px;">
	<form method="post">
	<?php $linktopage=$CFG->wwwroot. "/userfrontpage/continuepurchases/continuepayment.php?orderid=".$sqlrow['orderid']; ?>
	<input title="<?=get_string('continuemypurchases');?>" type="submit" name="submitpage" id="submitpage" onMouseOver="style.cursor='pointer'" value="<?=get_string('continue');?>" onClick="this.form.action='<?=$linktopage;?>'" />
	</form>
	</div>	
	</td>		
  </tr>
<?php 	} // end while	 	
 }else{ ?> 
  <tr>
    <td class="adjacent" colspan="7"><?=get_string('norecords');?></td>
  </tr>
<?php } ?>
</table>
<div style="margin-top:10px;">
<table align="center"><tr><td>
</td></tr></table>
</div></div>
<?php	
	}
	echo $OUTPUT->footer();	
?>