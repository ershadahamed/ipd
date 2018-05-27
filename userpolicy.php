<?php 
	include('config.php'); 
	include('manualdbconfig.php'); 
?>
 <?php
 header ('Content-type: text/html; charset=utf-8');
 header('Content-Type: text/html; charset=ISO-8859-1');
 ?>
<style>
<?php include('theme/aardvark/style/core.css'); ?>
ol #myList
{
	list-style-type:lower-roman;
	text-align: justify;
}

#userpolicy
{
	width:95%;
	margin:0 auto;
	/* border-collapse: collapse;
	border: 2px solid rgb(152, 191, 33); */
	background-color:#fff;	
}
html, body {
    color: #333333;
    font-family: Verdana,Geneva,sans-serif !important;
}

</style>
<style type="text/css">
    img.table-bg-image {
        position: absolute;
        z-index: -1;
		width:98%;
		height:1760px;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_policy.png"/>
<?php
	//to retrive back data from form
	$traineeID = $_GET['traineeID'];
	
	$firstname = $_GET['trainee_name'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$phone2 = $_GET['phone2'];	
	$province = $_GET['province'];
	$city = $_GET['city'];
	$postal = $_GET['postal'];
	$country = $_GET['country'];
	
	$coursename = $_GET['coursename'];
	$shortname = $_GET['shortname'];
	$courseid = $_GET['courseid'];
	
	$cost = $_GET['cost'];
	$currency=$_GET['currency'];
	$PaypalBusinessEmail=$_GET['PaypalBusinessEmail']; 
	$paymethod=$_GET['pay_method'];
	
	//nilai checkbox
	//if($_POST['column1']!='1'){ $nilai1='0';}else{ $nilai1='1';};
	if($_POST['column2']!='1'){ $nilai2='0';}else{ $nilai2='1';};
	//if($_POST['column3']!='1'){ $nilai3='0';}else{ $nilai3='1';};	
	
	$nilai1='1';
	$nilai3='1';	
	//echo $nilai1.'-'.$nilai2.'-'.$nilai3;

	/*if($paymethod == 'paypal'){ 
	$link=$CFG->wwwroot. '/portal/subscribe/payment_method.php?paymethod=paypal&&traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&phone2='.$phone2.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&co1='.$nilai1.'&&co2='.$nilai2.'&&co3='.$nilai3.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 
	}else if($paymethod == 'creditcard'){
	$link2=$CFG->wwwroot. '/portal/subscribe/payment_method.php?paymethod=creditcard&&traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&phone2='.$phone2.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&co1='.$nilai1.'&&co2='.$nilai2.'&&co3='.$nilai3.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; 
	}else{
	$link3=$CFG->wwwroot. '/portal/subscribe/payment_method.php?traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&phone2='.$phone2.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&co1='.$nilai1.'&&co2='.$nilai2.'&&co3='.$nilai3; 	
	}*/	
	
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
	<script language="JavaScript">
function checkfield(msg){
	pengakuan1 = 'Please tick, if you agree with the policy.';
	elem1 = document.getElementById('pengakuan1');
		if(!elem1.checked) { 
			alert(pengakuan1);
			return false; 
		} 
		
	document.form.submit();	
	window.opener.location.href="<?php if($paymethod == 'paypal'){echo $link;}else if($paymethod == 'creditcard'){echo $link2;}else{echo $link3;}?>";
	self.close();
	return true;	
			
}
</script>

<form method="post" name="form"  action="<?//=$link; ?>">
<table class="with-bg-image"><tr><td><br/>
<table id="policy" width="100%" border="0"  style="padding:0px;">
  <tr valign="top">
    <td align="left" valign="middle" style="font-size:0.9em;"><?=get_string('ipdaddress');?></td>
    <td align="right" style="width:50%"><img style="width:134px;" src="<?=$CFG->wwwroot;?>/image/CIFALogo.png"></td>
  </tr>
</table>
<table id="policy" style="text-align:justify;width:100%;margin:2em auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>		
<?php 		
	$erulessql=mysql_query("SELECT * FROM mdl_cifaexamrules WHERE id='20'");
	$erules=mysql_fetch_array($erulessql);
	echo $erules['summary'];	
?>
</td></tr></table>
</td></tr></table>
</form>
