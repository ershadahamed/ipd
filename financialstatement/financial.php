<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php 
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $fstatement = get_string('financialstatement');
	$myaccount = get_string('myaccount');
    $PAGE->navbar->add(ucwords(strtolower($myaccount)))->add(ucwords(strtolower($fstatement)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();	
	if (isloggedin()) { // needed to loggin
	echo '<h2>'.get_string('financialstatement').'</h2><br/>'; // heading title
	
	//to get list of financial
	$statement = mysql_query("
				Select
				  *
				From
				  mdl_cifastatement
				Order By candidateid, courseid ASC
	");				
?>
<form id="form1" name="form1" method="post" action="">
  <table class="viewdata" width="100%" border="1" cellpadding="2" cellspacing="0">
    <tr>
      <th style="width:10%">Date</th>
	  <th style="width:10%"><?=get_string('candidateid');?></th>
      <th>Description</th>
      <th style="width:10%">Debit (USD)</th>
      <th style="width:10%">Credit (USD)</th>
    </tr>
<?php
	$bil='1';
	$frowcol=mysql_num_rows($statement);
	if($frowcol!='0'){
	while($financial=mysql_fetch_array($statement)){
		if($financial['remark']=='Subscribe'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate'];}
		if($financial['remark']=='Payment'){ $sb=$financial['credit1']; $sdate=$financial['paymentdate']; }
		if($financial['remark']=='Re-sit'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate']; }
		if($financial['remark']=='Extension'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate']; }
?>    
    <tr>
      <td style="text-align:center;">
		<?php
			//date subcribe//payment
			echo date('d M Y', $sdate);
		?>      
      </td>
      <td style="text-align:center;">
		<?php
			//date subcribe//payment
			echo strtoupper($financial['candidateid']);
		?>      
      </td>	  
      <td>
	  <?php 
		//description
	  	$sc=mysql_query("SELECT fullname FROM {$CFG->prefix}course WHERE id='".$financial['courseid']."'");
	  	$gsc=mysql_fetch_array($sc);
		echo $financial['remark']. ' - ' .$gsc['fullname'];
	  ?></td>
      <td style="text-align:center;">
	  <?php
		//debit
		if($financial['remark']!='Payment'){
			echo $sb;
			//total debit
			$sum+=$sb;			
				
		}	  
	  ?>
	  </td>
      <td style="text-align:center;">
      <?php
		//credit
		if($financial['remark']=='Payment'){
			echo $sb;
			//total credit
			$sum2+=$sb;
		}
	  ?>
      </td>
    </tr>   
<?php } ?>
    <tr>
      <td colspan="4" style="text-align:center;"><strong>Balance</strong></td>
      <td style="text-align:center;"><strong><?=$sum-$sum2;?></strong></td>
    </tr> 
<?php }else{ ?>     
    <tr>
      <td colspan="5" style="text-align:center;"><strong>No records found</strong></td>
    </tr>
<?php } ?>    
  </table>
</form>
<?php
	}else{
		echo get_string('loggedinrequire');
	}
	echo $OUTPUT->footer();
?>
</body>
</html>