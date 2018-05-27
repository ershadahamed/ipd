<?php 
	include('config.php'); 
	include('manualdbconfig.php');
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
		/*height:957px;*/
		height:2630px;
		margin:0px auto;
    }
    table.with-bg-image, table.with-bg-image tr, table.with-bg-image td {
        background: transparent;
    }
</style>
<img class="table-bg-image" src="<?=$CFG->wwwroot;?>/image/bg_certificate_1.png"/>

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
	$erulessql=mysql_query("SELECT * FROM mdl_cifaexamrules WHERE id='16'");
	$erules=mysql_fetch_array($erulessql);
	echo $erules['summary'];	
?>
</td></tr></table>
</td></tr></table>
</form>
