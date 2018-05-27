<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	include_once ('../pagingfunction.php');
	
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);

	$examid=$_GET['examid'];

	$cidosexam1 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'A'";
	$cidosexam2 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'B'";
	$cidosexam3 = "SELECT * FROM mdl_cifaexam_ref WHERE id = 'C'";

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
<script language="javascript">
var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape")
     document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
     var myevent = (isNS) ? e : event;
     var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;
function killCopy(e){
    return false
}
function reEnable(){
    return true
}
document.onselectstart = new Function ("return false")
if (window.sidebar){
    document.onmousedown=killCopy
    document.onclick=reEnable
}
</script>
<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
}
table{
	font-family: Verdana,Geneva,sans-serif;
	font-size:0.95em;
}
input[type="submit"]{
	border:		2px solid #00C5FB;
	padding:		8px 10px !important;
	margin-bottom: 2px;
	/* font-size:		12px !important; */
	background-color:	#FFFFFF;
	font-weight:		bold;
	color:			#000000;	
	cursor:pointer;
	border-radius: 5px;
	min-width: 80px;
}
</style><center>
<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
		width:400px;
		height:1042px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/statementbg1.jpg"/>
<table class="with-bg-image" height="1022px" border="0" cellspacing="0" cellpadding="10" width="98%" style="padding:0px; margin:0px;" align="center"><tr><td style="vertical-align:top;">

<table width="100%" border="0"  style="padding:0px;">
  <tr valign="top">
    <td align="left">
	<table style="padding:0px; margin:0px; color:#666;">
	<tr><td>Tel: [+965] 22915580</td></tr>
	<tr><td>Fax: [+965] 22915580</td></tr>
	<tr><td>Website: learnCIFA.com</td></tr>
	<tr><td>P.O.Box 29916, Safat 13159,</td></tr>
	<tr><td>Kuwait City, Kuwait</td></tr></table>
	</td>
    <td align="right" style="width:50%"><img style="width:45%" src="<?=$CFG->wwwroot;?>/image/logocifa.jpg"></td>
  </tr>
</table>
<table style="width:100%"><tr><td style="text-align:justify"><br/><br/>
<div class="demo" style="margin-bottom:1em;">
Date: <?=date('d-F-Y', strtotime('now'));?>
</div>
<?php
	echo ucfirst($USER->address)."<br>";
	if($USER->address2!=''){
	echo ucfirst($USER->address2)."<br>";
	}
	if($USER->address3!=''){
	echo ucfirst($USER->address3)."<br>";
	}
	echo ucfirst($USER->city);
	echo "<br>";
	echo "<br>";
?>
<form action="#" method="post">
<input name="id" type="text" value="<?php echo $id;  ?>" hidden> 
<br>
<?php
	if($USER->middlename!=''){ $mname=$USER->middlename; }
	echo "Dear "; 
	echo ucfirst($USER->firstname.' '.$mname.' '.$USER->lastname) .", ";
?>
<br><br>
<div style="margin-bottom:1em;">
Candidate ID: A14116MY<strong><?=$USER->traineeid;?></strong>
</div>
<?php
	$s=mysql_query("SELECT * FROM mdl_cifafinancial_statement WHERE id='1'");
	$ss=mysql_fetch_array($s);
	
	echo $ss['summary'];
?>
  <table class="viewdata" border="1" style="border-collapse:collapse;width:100%; margin:1.2em 0px;">
    <tr style="background-color:#6D6E70; color:#FFFFFF;">
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
      <td style="text-align:center;"><strong><?=$sum-$sum2;?></strong></td>
    </tr> 
<?php }else{ ?>     
    <tr>
      <td colspan="4" style="text-align:center;"><strong>No records found</strong></td>
    </tr>
<?php } ?>    
  </table>
<?php 		
	echo $ss['financialsummary'];
?>
<br><br><br/>
Yours Sincerely,<br/>
<img src="../image/signiture.jpg" alt="" width="161" height="62"><br/>
<strong>Abdulkader Thomas</strong><br/>
CEO

</form></table>
<span style="font-size:0.6em;"><?=get_string('disclaimer');?></span>
</td></tr></table></center><br/>

<div style="text-align:center;">
	<form>
		<input type="submit" id="btnPrint" name="backbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" value="Back" />
	</form>
</div><br/>


