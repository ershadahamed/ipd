<?php	
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$heading=get_string('transactionreport');
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	
	$PAGE->navbar->add($heading);	
	//$PAGE->set_pagelayout('courses');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($heading, 2, 'headingblock header');
	
	//$sql="SELECT * FROM mdl_cifauser";
	//$query=mysql_query($sql);
?>
<link rel="stylesheet" type="text/css" media="all" href="../offlineexam/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../offlineexam/jquery.1.4.2.js"></script>
<script type="text/javascript" src="../offlineexam/jsDatePick.jquery.full.1.3.js"></script>
<script type="text/javascript">
	$("tr").click(function(){
		$(this).addClass("selected").siblings().removeClass("selected");
	});

	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"
		});
		new JsDatePick({
			useMode:2,
			target:"dateto",
			dateFormat:"%d-%m-%Y"
		});
	};
</script>
<style>
<?php 
	include('../css/style2.css'); 
	include('../css/button.css');
	include('../css/pagination.css');
	include('../css/grey.css');
?>
#availablecourse tr:hover, tr.selected {
    background-color: #5DCBEC;
}
</style>
<div style="min-height: 390px;">
<form id="formname" name="formname" method="post" onClick="return displ();">
<!--fieldset id="fieldset"><legend id="legend">Search candidate</legend-->
<table border="0" cellpadding="1" cellspacing="1" style="margin-top:30px; width:95%; font:13px/1.231 arial,helvetica,clean,sans-serif bolder;">
	<tr>
		<td style="width:30px;text-align:left;"><input type="text" id="inputField" name="datefrom" style="width:180px;" /></td>
		<!--td style="width:30px;text-align:left;"><input type="text" id="dateto" name="dateto" /></td-->
		<td style="width:100px;text-align:left;">
		<?php 
			$month = array(
				"01" => "January",
				"02" => "February",
				"03" => "March",
				"04" => "April",
				"05" => "May",
				"06" => "June",
				"07" => "July",
				"08" => "August",
				"09" => "September",
				"10" => "October",
				"11" => "Novemeber",
				"12" => "December"
			);
		?>
		<select id="month" name="month" style="width:100%;text-align:left;">
		<option value=""> - month - </option>
		<?php
			
			foreach($month as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>		
		</td>
		<td style="width:80px;text-align:left;">
		<?php 
			$years = array_combine(range(date("Y"), 2011), range(date("Y"), 2011)); 
		?>
		<select id="years" name="years" style="width:100%;text-align:left;">
		<option value=""> - year - </option>
		<?php
			
			foreach($years as $key => $value):
			echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
			endforeach;
		?>
		</select>		
		</td>        
		<td><input style="width:80px;" title="Press to search" onMouseOver="style.cursor='pointer'" type="submit" name="search" value="<?=get_string('view').' record';?>"/></td>
	</tr>
	<tr>
		<td style="width:100px;text-align:left;">
		<select name="paymethod" style="width:180px;">
			<option value=""> - payment method - </option>
			<option value="telegraphic">Telegraphic Transfer</option>
			<option value="creditcard">Credit Card</option>
            <option value="paypal">Paypal</option>
		</select>		
		</td>
		<td style="width:80px;text-align:left;">
		<select name="status" style="width:180px;">
			<option value=""> - status - </option>
			<option value="pending">In progress</option>
			<option value="paid">Subscribed</option>
            <option value="cancel">Unsubscribed</option>
		</select>		
		</td>        
	</tr>		
</table><!--/fieldset-->
</form>
<!---End search---->

<?php 
	$carianbulan=$_POST['month']; 
	$carianpilihan=$_POST['years']; 
	$cariandatefrom=$_POST['datefrom'];
	$dateto=$_POST['dateto'];
	$status=$_POST['status']; 
	$paymethod=$_POST['paymethod']; 	
?>
<table id="availablecourse">
  <tr class="yellow">
    <th class="adjacent" width="1%">No</th>
	<th class="adjacent" width="8%" align="left"><strong><?=get_string('candidateid');?></strong></th>
    <th class="adjacent" width="30%" align="left"><strong><?=get_string('candidatename');?></strong></th>
    <th class="adjacent" width="18%" style="text-align:center;"><strong><?=get_string('confirmationno');?></strong></th>
    <th class="adjacent" width="22%" style="text-align:left;"><?=get_string('coursemodule');?></th>	
    <th class="adjacent" width="10%" style="text-align:center;"><?=get_string('paymentmethod');?></th>
	<th class="adjacent" width="10%" style="text-align:center;"><?=get_string('datepurchase');?></th>
	<th class="adjacent" style="text-align:center;"><?=get_string('status');?></th>
  </tr>
<?php 	
    //paging
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 12;
    $startpoint = ($page * $limit) - $limit;
	
	//collect user to list out on table
	$statement=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
	$sqlcourse="SELECT * FROM {$statement} WHERE b.paymethod!=''";	
	if($carianpilihan != ''){ $sqlcourse.= " AND (date_format(from_unixtime(b.date), '%Y') LIKE '%".$carianpilihan."%')"; }
	if($carianbulan != ''){ $sqlcourse.= " AND (date_format(from_unixtime(b.date), '%m') LIKE '%".$carianbulan."%')"; }
	if($cariandatefrom != ''){ $sqlcourse.= " AND (date_format(from_unixtime(b.date), '%d-%m-%Y') LIKE '%".$cariandatefrom."%')"; } //datefrom
	if($dateto != ''){ $sqlcourse.= " AND (date_format(from_unixtime(b.date), '%d-%m-%Y') LIKE '%".$dateto."%')"; } //dateto

	if($status != ''){ $sqlcourse.= " AND ((b.paystatus LIKE '%".$status."%'))"; }
	if($paymethod != ''){ $sqlcourse.= " AND ((b.paymethod LIKE '%".$paymethod."%'))"; }
	
	if(($cariandatefrom != '') && ($dateto != '')){ $sqlcourse.= " AND ((date_format(from_unixtime(b.date), '%d-%m-%Y') LIKE '%".$cariandatefrom."%') OR (date_format(from_unixtime(b.date), '%d-%m-%Y') LIKE '%".$dateto."%'))"; }	
	$carianstatement = "((date_format(from_unixtime(b.date), '%Y') LIKE '%".$carianpilihan."%') OR (date_format(from_unixtime(b.date), '%m') LIKE '%".$carianbulan."%'))";
	if(($carianpilihan != '') && ($carianbulan != '')){ $sqlcourse.= " AND $carianstatement"; }
	$sqlcourse.=" Group By b.confirmationno Order By b.date DESC, a.traineeid DESC";	
		
	$sqlquery=mysql_query($sqlcourse);
	$sqlquery_count=mysql_num_rows($sqlquery);
	if($sqlquery_count > 0){
	$no='1';
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$bil=$no++;
?>
<?php 
	$pstatus1=$sqlrow['paystatus'] == 'pending';
	$pstatus2=$sqlrow['paystatus'] == 'paid';
	
	//$color1='background-color:#fff;';
	//$color2='background-color:#81F781;';
	//$color3='background-color:#FA5858;';
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
    <td class="adjacent" style="text-align:center;">
		<?php 
			//confirmation no.
			echo $sqlrow['confirmationno']; 	
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
				
			if ($sqlrow['paystatus'] == 'pending') {
				echo 'In progress';		
			} else if ($sqlrow['paystatus'] == 'paid') {
				$linkconfirmpaid=$CFG->wwwroot. "/image/paid.png";
				$imagepaid = '<img src="'.$linkconfirmpaid.'" width="50" title="User already paid & confirmed to access LMS" />';
				//echo $imagepaid;
				echo 'Subscribed';
			} else {
				$linkconfirmcancel=$CFG->wwwroot. "/image/cancelp.png";
				$imagecancel = '<img src="'.$linkconfirmcancel.'" width="68" title="User cancel to proceed payment" />';
				//echo $imagecancel;
				echo 'Unsubscribed';
			}		
		?>
		</form>
	</td>
  </tr>
<?php 	
	} // end while 
	}else{
?>
  <tr>
    <td class="adjacent" colspan="8"><?=get_string('norecords');?></td>
  </tr> 
<?php
		}
		if($sqlInsert){ 
		?>
			<script language="javascript">
				window.alert("<?=strtoupper($q30['traineeid']).' '.$confirmuser.'-'.$datepurchase;?> has been confirmed.");
			</script>
		
			
		<?php 
			//redirect/reload page.	
			$urlredirect=$CFG->wwwroot.'/transaction_status.php';
			redirect($urlredirect);
		}
?>
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