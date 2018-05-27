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
	
    $venrollmentconfirmation = 'Enrollment Confirmation';
    $PAGE->navbar->add(ucwords(strtolower($venrollmentconfirmation)));	
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');

	$country = $USER->country;
	$traineeID=$USER->traineeid;
	
	$orderid = $_GET['orderid'];	
    echo $OUTPUT->header();
	if (isloggedin()) { //if login
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
	border:		2px solid #21409A;
	padding:		5px 10px !important;
	margin-bottom: 2px;
	font-size:		12px !important;
	background-color:	#21409A;
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
	background-color:#21409A; padding-left:5px;
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
	$account_title=$_POST['accounttitle'];
	$swiftcode=$_POST['swiftcode'];
	$iban=$_POST['iban'];
	$accountnumber=$_POST['accountnumber'];
	$textline1=$_POST['textline1'];
	$textline2=$_POST['textline2'];
	
	$acinfoupdate=mysql_query("UPDATE mdl_cifaaccount_info SET headtitle='".$headtitle."', branch='".$branch."',
	account_title='".$account_title."', swiftcode='".$swiftcode."', iban='".$iban."', accountnumber='".$accountnumber."', textline1='".$textline1."', textline2='".$textline2."'  WHERE id='".$branchid."'");

	$acinfo=mysql_query("SELECT * FROM {$CFG->prefix}account_info");
	$aci=mysql_fetch_array($acinfo);
?>
<div style="width:98%; margin:0px auto;"><h2>View Enrollment Confirmation</h2></div>

<table  width="98%" border="1" id="availablecourse4" style="bgcolor:#FFFFFF; border-collapse: collapse; border-spacing: 0; border-color:#cccccc;margin: 0px auto;">
	<tr style="background-color:#21409A; color:#fff;"><td colspan="3" style="padding-left:10px;"><h3><?=$aci['headtitle'];?></h3></td></tr>	
	<tr><td width="20%">
	<table id="candidatedetails" style="width:100%;padding:0px;">
	<tr><td width="20%">Branch</td><td width="1%"><strong>:</strong></td><td><?=$aci['branch'];?></td></tr>
	<tr><td>Account Title/Beneficiary</td><td><strong>:</strong></td><td><?=$aci['account_title'];?></td></tr>
	<tr><td>SWIFT Code</td><td><strong>:</strong></td><td><?=$aci['swiftcode'];?></td></tr>
	<tr><td>IBAN  #	</td><td><strong>:</strong></td><td><?=$aci['iban'];?></td></tr>
	<tr><td>Account Number</td><td><strong>:</strong></td><td><?=$aci['accountnumber'];?></td></tr>	
	<tr><td>Reference</td><td><strong>:</strong></td>
	<td>Candidate ID</td></tr>
	<tr><td colspan="3"><?=$aci['textline1'];?></td></tr>
	<tr><td colspan="3">
        <?=$aci['textline2'];?>
    </td></tr>    
    </table>
	</td></tr>
	<tr style="background-color:#d6dee7;"><td colspan="3">&nbsp;</td></tr>	
</table>
<br/>
<div style="width:98%;text-align:center;">
	<form>
	<input onClick="this.form.action='<?=$CFG->wwwroot. '/index.php';?>'" type="submit" name="backbutton" id="backbutton" value="Back" style="cursor:pointer;" /></form>
    
</div><br/>
<?php 
	}else{
		echo '<div style="color:red">You cannot access this page. Please login.</div>';
	}
	echo $OUTPUT->footer();
?>