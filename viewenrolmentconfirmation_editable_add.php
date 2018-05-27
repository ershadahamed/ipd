<!--body onLoad="javascript:window.print()"-->
<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php'); 
	include("includes/functions.php");

	$site = get_site();
	
	$purchase='Purchase IPD modules';
	$title="$SITE->shortname: SHAPE IPD - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);

	$country = $USER->country;
	$traineeID=$USER->traineeid;
	
	$orderid = $_GET['orderid'];	
?>
<script language="javascript">
/*var isNS = (navigator.appName == "Netscape") ? 1 : 0;
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
}*/
</script>
<script type="text/javascript"> 
function printPage() {
	if(document.all) {
		document.all.divButtons.style.visibility = 'hidden';
		window.print();
		document.all.divButtons.style.visibility = 'visible';
	} else {
		document.getElementById('divButtons').style.visibility = 'hidden';
		window.print();
		document.getElementById('divButtons').style.visibility = 'visible';
	}
}

function myPopup2() {
//var printtxt = document.getElementById('printtxt').value;
//window.open(printtxt);
window.print();
}
</script>
<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
}

input[type="submit"]{
	border:		2px solid #00C5FB;
	padding:		5px 10px !important;
	margin-bottom: 2px;
	font-size:		12px !important;
	background-color:	#5DCBEB;
	font-weight:		bold;
	color:			#ffffff;
	border-radius:5px;
}
<?php 
	include('css/style2.css'); 	
?>



#availablecourse4, textarea, div{
font-family: Arial,Verdana,Helvetica,sans-serif;font-size: 13px; margin: 0px auto; 
}
#availablecourse4 tr, td .classtr{
	border-color:#cccccc; padding-left:5px;
}
#availablecourse4 tr .classtitle{
	border-color:#cccccc;
	background-color:#d6dee7; padding-left:5px;
}
#candidatedetails{
	font-family: Arial,Verdana,Helvetica,sans-serif;font-size: 13px;
	border-collapse: collapse; border-spacing: 0; border-color:#cccccc; margin: 10px 0px 10px 0px; padding-left:5px;
	width:100%;
}

#candidatedetails td, tr{ padding:5px 10px; }

h3{
margin: 1em 0;
}
</style>
<?php
	$branchid=$_POST['branchid'];
	$headtitle=$_POST['headtitle'];
	$branch=$_POST['branch'];
	$account_title=$_POST['account_title'];
	$swiftcode=$_POST['swiftcode'];
	$iban=$_POST['iban'];
	$accountnumber=$_POST['accountnumber'];
	$textline1=$_POST['textline1'];
	$textline2=$_POST['textline2'];

	$acinfo=mysql_query("SELECT * FROM {$CFG->prefix}account_info WHERE id='".$branchid."'");
	$aci=mysql_fetch_array($acinfo);
?>
<div style="width:98%; margin:0px auto;"><h2>Enrollment Confirmation Content</h2></div>

<table  width="98%" border="1" id="availablecourse4" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">
	<tr style="background-color:#5DCBEB;"><td colspan="3" style="padding-left:10px;"><h3><input style="width:98%;" type="text" name="headtitle" id="headtitle" value="<?=$aci['headtitle'];?>" /></h3></td></tr>	
	<tr><td width="20%">
	<table id="candidatedetails" style="width:100%;padding:0px;">
	<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td>
	  <input style="width:50%;" type="text" name="branch" id="branch" value="<?=$aci['branch'];?>" /></td></tr>
	<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td>
	  <input style="width:50%;" type="text" name="accounttitle" id="accounttitle" value="<?=$aci['account_title'];?>" /></td></tr>
	<tr><td>SWIFT Code</td><td><strong>:</strong></td><td>
	  <input style="width:50%;" type="text" name="swiftcode" id="swiftcode" value="<?=$aci['swiftcode'];?>" /></td></tr>
	<tr><td>IBAN  #	</td><td><strong>:</strong></td><td>
	  <input style="width:50%;" type="text" name="iban" id="iban" value="<?=$aci['iban'];?>" /></td></tr>
	<tr><td>Account Number</td><td><strong>:</strong></td><td>
	  <input style="width:50%;" type="text" name="accountnumber" id="accountnumber" value="<?=$aci['accountnumber'];?>" /></td></tr>	
	<tr><td>Reference</td><td><strong>:</strong></td>
	<td>Candidate ID</td></tr>
	<tr><td colspan="3">
	  <input name="textline1" type="text" id="textline1" value="<?=$aci['textline1'];?>" style="width:100%;" /></td></tr>
	<tr><td colspan="3">
        <textarea rows="10" cols="100" style="width:100%"><?=$aci['textline2'];?></textarea>
    </td></tr>    
    </table>
	</td></tr>
	<tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
</table>
<br/>
<div style="width:98%;text-align:center;">
	<input type="submit" name="savechanges" id="savechanges" value="Save Changes" style="cursor:pointer;" />
</div><br/>