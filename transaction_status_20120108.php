<?php	
    require_once('config.php');
	include('manualdbconfig.php'); 
	include_once ('pagingfunction.php');
	
	
	$site = get_site();
	
	$heading=get_string('transactionstatus');
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('courses');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($heading, 2, 'headingblock header');
	
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
	<!--tr>
		<td style="width:180px;text-align:right;">
		<select name="pilihancarian3" style="width:180px;">
			<option value=""> - select - </option>
			<option value="date"><?//=get_string('date');?></option>
		</select>
		</td>
		<td width="10%">
			<input type="text" id="inputField" name="cariandate" style="width:250px;" />
			<input type="hidden" id="inputField2" name="dob2" style="width:250px;" />
		</td>
	</tr--> 	
</table><!--/fieldset-->
</form>
<!---End search---->

<?php 
	$selectsearch=$_POST['pilihancarian']; 
	$candidateid=$_POST['traineeid']; 
	$selectsearch2=$_POST['pilihancarian2']; 
	$candidateid2=$_POST['traineeid2']; 
	//$carianpilihan=$_POST['pilihancarian3']; 
	//$cariandate=strtotime($_POST['dob2']); 	
	//echo $cariandate;
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
	$sqlcourse="SELECT * FROM {$statement}";
	if($candidateid!='' && $selectsearch!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%'))";}
	if($candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	//if($cariandate!='' && $carianpilihan!=''){$sqlcourse.= " AND (($carianpilihan LIKE '%".$cariandate."%'))";}		
	if($candidateid!='' && $selectsearch!='' && $candidateid2!='' && $selectsearch2!=''){$sqlcourse.= " AND (($selectsearch LIKE '%".$candidateid."%') AND ($selectsearch2 LIKE '%".$candidateid2."%'))";}	
	$sqlcourse.=" Group By a.traineeid Order By b.date DESC, a.traineeid DESC";
	//$sqlcourse.=" LIMIT {$startpoint} , {$limit}";	
		
	$sqlquery=mysql_query($sqlcourse);
	$no='1';
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
?>
<?php 
	$pstatus1=$sqlrow['paystatus'] == 'new';
	$pstatus2=$sqlrow['paystatus'] == 'paid';
	$color1='background-color:#fff;';
	$color2='background-color:#81F781;';
	$color3='background-color:#FA5858;';
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
		$sqluser=mysql_query("
			Select
			  *
			From
				mdl_cifacandidates a Inner Join
				mdl_cifaorders b On a.serial = b.customerid Inner Join
				mdl_cifaorder_detail c On b.serial = c.orderid
			Where a.traineeid = '".$sqlrow['traineeid']."'
		");
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
		<?php
			$beli=date('d-m-Y H:i:s', $sqlrow['date']);
			$expiry=strtotime(date('d-m-Y H:i:s',strtotime($beli . " + 3 month")));
			//$expiry=strtotime(date('d-m-Y H:i:s',strtotime($beli)));
			$today = strtotime('now');
			
			//echo date('d-m-Y H:i:s',$today).'<br/>'.$expiry;		
			if ($sqlrow['paystatus'] == 'new') {
				if($sqlrow['paymethod'] != 'telegraphic'){
					$confirmbutton = "<a href=\"user.php?confirmuser=".$userscolumn['id']."&amp;sesskey=".sesskey()."\">" . get_string('confirm') . "</a>";
					echo $confirmbutton;
				}else{	
					if($today > $expiry){
						$sqltransaction=mysql_query("UPDATE {$CFG->prefix}orders SET paystatus='cancel' WHERE paystatus='new' AND paymethod='telegraphic'"); 
						$linkconfirm=$CFG->wwwroot. "/image/not.png";
						$confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User cancel to proceed payment" />';
						echo $confirmbutton;
					}else{
						$confirmbutton = "<a href=\"user.php?confirmuser=".$userscolumn['id']."&amp;sesskey=".sesskey()."\">" . get_string('confirm') . "</a>";
						echo $confirmbutton;
					}
				}			
			} else if ($sqlrow['paystatus'] == 'paid') {
				$linkconfirm=$CFG->wwwroot. "/image/yes.png";
				$confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User already paid & confirmed to access LMS" />';
				echo $confirmbutton;
			} else {
				$linkconfirm=$CFG->wwwroot. "/image/not.png";
				$confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User cancel to proceed payment" />';
				echo $confirmbutton;
				//echo date('d-m-Y H:i:s',$expiry);
			}		
		//}
		?>
	</td>		
  </tr>
<?php 	} ?>

<?php  }else{ ?> 
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