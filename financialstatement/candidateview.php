<?php 
	require_once('../config.php');
	require_once('../manualdbconfig.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $fstatement = get_string('financialstatement');
	$myaccount = get_string('myaccount');
	
	$linkhere1= new moodle_url('/user/profile.php?id=', array('id'=>$USER->id)); //added by arizan	
	$linkhere2= new moodle_url('/financialstatement/candidateview.php?id=', array('id'=>$USER->id)); //added by arizan	
    $PAGE->navbar->add(ucwords(strtolower($myaccount)), $linkhere1)->add(ucwords(strtolower($fstatement)), $linkhere2);	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');

	if($_GET['printpage']!='1'){
	
    echo $OUTPUT->header();	}
	if (isloggedin()) { // needed to loggin

	// redirect if poassword not change
	$rselect=mysql_query("SELECT * FROM {$CFG->prefix}user_preferences WHERE userid='".$USER->id."' AND name='auth_forcepasswordchange' AND value='1'");
	$srows=mysql_num_rows($rselect);
	if($srows!='0'){
		?>
			<script language="javascript">
				window.location.href = '<?=$CFG->wwwroot .'/login/change_password.php';?>'; 
			</script>
		<?php	
	}	

	// redirect if profile not updated
	$srole=mysql_query("SELECT name FROM mdl_cifarole WHERE id='5'");
	$rwrole=mysql_fetch_array($srole);
	$usertype=$rwrole['name'];		
	
	$srolew=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$USER->id."' AND usertype='".$rwrole['name']."'");
	$srolenum=mysql_num_rows($srolew);
	if($srolenum!='0'){
		$rsc=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$USER->id."' AND (email='' OR college_edu='' OR highesteducation='0' OR yearcomplete_edu='0')");
	}else{
		$rsc=mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='".$USER->id."' AND (email='' OR designation='' OR department='')");
	}
	$srows2=mysql_num_rows($rsc);
	if($srows2!='0'){
		?>
			<script language="javascript">
				window.location.href = '<?=$CFG->wwwroot .'/user/edit.php?id='.$USER->id.'&course=1';?>'; 
			</script>
		<?php	
	}		
		
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
<script type="text/javascript">
<!--
function myPopup2() {
	var printtxt = document.getElementById('printtxt').value;
	window.open(printtxt, "Window2", "status = 1, width=880, height=630, resizable = yes, scrollbars=1");
	//window.open(printtxt);
}
//-->
</script>
<script type="text/javascript">
function popupwindow(url, title, w, h) {//Center PopUp Window added by Arizan
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>	
<?php if($_GET['printpage']=='1'){ $css=$CFG->wwwroot. '/theme/aardvark/style/core.css';?>
	<style type="text/css">
	@media print {
		input#btnPrint {
			display: none;
		}
	}
	html, table tr, td, th{
		font-family: Verdana,Geneva,sans-serif;
		font-size:0.9em;
	}
	input[type="button"]{
		/* padding:3px 8px; */
		
		border:		2px solid #21409A;
		padding:		5px 10px !important;
		margin: 2px 0px 2px 2px;
		font-size:		12px !important;
		background-color:	#21409A;
		font-weight:		bold;
		color:			#ffffff;	
		cursor:pointer;
		border-radius: 5px;
		min-width: 80px;
	}
	
	#id_defaultbutton{
	background-color:	#ffffff;
	color:			#000000;
	}			
	</style>
	
<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
		width:100%;
		/* min-height:837px; */
		height:97%;
		margin-bottom:0px;
		padding-bottom:0px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_statement.png"/>	
<table id="policy" width="100%" border="0"  style="padding:0px;">
  <tr valign="top">
    <td align="left" valign="middle" style="font-size:0.9em;"><?=get_string('ipdaddress');?></td>
    <td align="right" style="width:50%"><img style="width:134px;" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>	
<?php } ?>	
<form id="form1" name="form1" method="post" action="">	
  <?php if($_GET['printpage']!='1'){ echo '<span style="margin:0px auto;"><h2>'.get_string('financialstatement').'</h2><br/></span>'; }else{ ?>
  <?php 
  		if($_GET['printpage']=='1'){ echo '<div style="margin:1em 5em 1em 0px">'; }
		echo '<h3 style="padding-left:0.8em;">'.get_string('financialstatement').'</h3>'; } 
		if($_GET['printpage']=='1'){ echo '</div>'; }
  ?>
  <table class="viewdata" width="100%" border="1" cellpadding="0" cellspacing="0" <?php if($_GET['printpage']=='1'){ ?> style="border-collapse:collapse;width:98%; margin:1.2em auto;" <?php } ?>>
  	<?php if($_GET['printpage']=='1'){ ?> 
    <tr style="background-color:#21409A; color:#FFFFFF;">
      <th style="width:20%; padding:0px;">Date  
      </th>
      <th style="padding-left:5px;">Description
      </th>
      <th style="width:15%;padding:0px;">Debit (USD)
      </th>
      <th style="width:15%;padding:0px;">Credit (USD)     
      </th>
    </tr><?php }else{ ?>
    
    <tr style="background-color:#21409A;">
      <th style="width:15%;">Date</th>
      <th>Description</th>
      <th style="width:15%;">Debit (USD)</th>
      <th style="width:15%;">Credit (USD)</th>
    </tr>    
    
<?php
	}
	$bil='1';
	$frowcol=mysql_num_rows($statement);
	if($frowcol!='0'){
	while($financial=mysql_fetch_array($statement)){
		if($financial['remark']=='Subscribe'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate']; }
		if($financial['remark']=='Payment'){ $sb=$financial['credit1']; $sdate=$financial['paymentdate']; }
		if($financial['remark']=='Re-sit'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate']; }
		if($financial['remark']=='Extension'){ $sb=$financial['debit1']; $sdate=$financial['subscribedate']; }
		
		// resit ID
		$cfinaltestsql=mysql_query("
			Select
			  a.category,
			  a.fullname,
			  b.course,
			  b.instance,
			  c.id As cifaquizid,
			  c.name,
			  c.course As course1,
			  e.userid,
			  b.id As id1,
			  c.attempts,
			  a.idnumber
			From
			  mdl_cifacourse a Inner Join
			  mdl_cifacourse_modules b On a.id = b.course Inner Join
			  mdl_cifaquiz c On b.course = c.course And b.instance = c.id Inner Join
			  mdl_cifaenrol d On c.course = d.courseid Inner Join
			  mdl_cifauser_enrolments e On d.id = e.enrolid
			Where
			  e.userid='".$USER->id."'	And b.course='".$financial['courseid']."'	
		");
		$final=mysql_fetch_array($cfinaltestsql); 
		$finalexamid=$final['cifaquizid'];		
		$finalc=$final['category'];		
?>    
    <tr>
      <td style="text-align:center;">
		<?php
			//date subcribe//payment
			echo date('d M Y', $sdate);
		?>      
      </td>
      <td style="padding-left:5px;">
	  <?php 
		//description
	  	$sc=mysql_query("SELECT fullname FROM {$CFG->prefix}course WHERE id='".$financial['courseid']."'");
	  	$gsc=mysql_fetch_array($sc);
		echo $financial['remark']. ' - ';
		if($finalc=='3'){
		echo $examname=$final['name'];
		}else{
		echo $gsc['fullname']; }
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
      <td style="text-align:center;"><strong><?=$sum-$sum2;?></strong></td>
    </tr> 
<?php }else{ ?>     
    <tr>
      <td colspan="4" style="text-align:center;"><strong>No records found</strong></td>
    </tr>
<?php } ?>    
  </table>
	<?php if($_GET['printpage']!='1'){ ?>	
		<div style="padding:2px;text-align:center;"><center>
		<input id="id_defaultbutton" type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
		<?php $printtxt = $CFG->wwwroot. "/financialstatement/candidateview.php?seskey=".$_GET['sesskey']."&printpage=1"; ?>		
		<input id="id_defaultbutton" onclick="popupwindow('<?=$printtxt;?>','googlePopup',1042,500);" type="button" value="&nbsp;<?=get_string('print');?>&nbsp;" />
		<input id="id_actionbutton" type="button" name="viewstatement" onClick="popupwindow('<?=$CFG->wwwroot. '/financialstatement/cview_statement.php?id='.$USER->id;?>','googlePopup',880,630);" value="<?=get_string('viewstatement');?>" />
		</center></div>	  
	<?php } if($_GET['printpage']=='1'){ ?>
<body onLoad="javascript:window.print()">	
    <!--div style="text-align:center;">
			<input type="button" id="id_defaultbutton" onclick="window.print();" value="Print Page" />
	</div-->
<?php } ?>
</form>
<?php
	}else{
		echo get_string('loggedinrequire');
	}
	
	if($_GET['printpage']!='1'){
		echo $OUTPUT->footer();
	}
?>