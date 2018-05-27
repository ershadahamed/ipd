<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--script src="http://code.jquery.com/jquery-1.8.2.min.js"></script-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#dialog" ).dialog({ 
	top : 200, 
	overlay : 0.4, 
	title: "MAKLUMAN", 
	background:'#FFA500',
	fontColor:'#FFFFFF',
	type:false,
	height:500,
	width:700,
	position: 'fixed'
	});
  });
  </script>
  <script>
  $(function() {
    $( document ).tooltip();
  });
  </script> 
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
	
	//to get list of financial
	$statement = mysql_query("
				Select
				  *
				From
				  mdl_cifastatement
				Where
					candidateid='".$USER->traineeid."' Order By candidateid, courseid ASC
	");		
?>
<form id="form1" name="form1" method="post" action="">
<?php
	//candidate fullname
	if($USER->middlename!=''){
		$cfullname=$USER->firstname.' '.$USER->middlename.' '.$USER->lastname;
	}else{
		$cfullname=$USER->firstname.' '.$USER->lastname;
	}
	
	//candidate fulladdress
	$scountry=mysql_query("SELECT countryname FROM {$CFG->prefix}country_list WHERE countrycode='".$USER->country."'");
	$cname=mysql_fetch_array($scountry);
	$cfulladdress=$USER->address.' '.$USER->address2. '<br/>'.$USER->city.' '.$USER->state.', <br/>'.$USER->postcode.' '.$cname['countryname'];
?>

<p><h4><?=get_string('financialstatement');?></h4></p><br/>
<p>Date: <?=date('d/m/Y', strtotime('now'));?></p>
<p><?=$cfulladdress;?></p>

<p>Dear (<?=$cfullname;?>),</p>
<p><?php 
	echo get_string('candidateid').': ';
	echo '<strong>'.$USER->traineeid.'</strong>';
?></p><br/><br/>

<p>The amount details below has been received with thanks for the following transactions: </p>

  <table class="viewdata" width="100%" border="1" cellpadding="2" cellspacing="0">
    <tr>
      <th style="width:10%">Date</th>
      <th>Description</th>
      <th style="width:10%">Debit (USD)</th>
      <th style="width:10%">Credit (USD)</th>
    </tr>
<?php
	$bil='1';
	$frowcol=mysql_num_rows($statement);
	if($frowcol!='0'){
	while($financial=mysql_fetch_array($statement)){
		if($financial['remark']=='Subscribe'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate']; }
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
      <td colspan="3" style="text-align:center;"><strong>Balance</strong></td>
      <td style="text-align:center;"><strong><?=$sum2-$sum;?></strong></td>
    </tr> 
<?php }else{ ?>     
    <tr>
      <td colspan="4" style="text-align:center;"><strong>No records found</strong></td>
    </tr>
<?php } ?>    
  </table>
  
<p>Should you require further assistance, please <a href="#" target="_blank"><u>contact us</u></a>. We will be pleased to help. </p>  
<br/><br/>
<p>Yours Sincerely,<br/>
<strong>Abdulkader Thomas</strong><br/>
CEO</p><br/>

<p><font size="1"><?=get_string('disclaimer');?></font></p>
<!--<a class="simple-ajax-popup-align-top" href="candidateview.php">Load content via ajax</a><br>
<a class="simple-ajax-popup" href="candidateview.php">Load another content via ajax</a>
<input id="age" title="We ask for your age only for statistical purposes.">-->
</form>

<!--<div id="dialog" title="Basic dialog">
  <p><strong>Makluman perubahan penggunaan ID dan kata laluan.</strong></p>
  <p>Untuk log masuk ke sistem E-TMS, sila gunakan no mykad untuk ID dan kata laluan. Setelah berjaya log masuk, sila ubah kata laluan anda.</p>
  <p><strong><u>Contoh</u><br/> MyKad:</strong> no.mykad<br/> <strong>Kata laluan:</strong> no.mykad</p>
  <p>Sekian, terima kasih.</p>
</div>-->
<?php
	echo $OUTPUT->footer();
?>
</body>
</html>