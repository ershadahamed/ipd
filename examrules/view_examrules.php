<?php
	include('../config.php');
	include('../manualdbconfig.php');
	include ('../pagingfunction.php');

    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	
	$site = get_site();

	$streditexamrules = get_string("editexamrules");
	$strvieweditexamrules = get_string('viewipdfaq');
	$PAGE->navbar->add($streditexamrules , new moodle_url('/examrules/admin_examrules_form.php?id=16'));
	$PAGE->navbar->add($strvieweditexamrules);
	$title = "$site->shortname: $streditexamrules";
	$fullname = $site->fullname;
	$PAGE->set_pagelayout('buy_a_cifa');
	$PAGE->set_title($title);
	$PAGE->set_heading($fullname);

	echo $OUTPUT->header();
	echo $OUTPUT->heading($strvieweditexamrules);	

	header ('Content-type: text/html; charset=utf-8');
	header('Content-Type: text/html; charset=ISO-8859-1');	
	
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
<?php include('../theme/aardvark/style/core.css'); ?>
@media print {
input#btnPrint {
display: none;
}
}
table{
	font-family: Verdana,Geneva,sans-serif;
	font-size:0.95em;
}

</style><center>

<table style="width:100%"><tr><td style="text-align:justify">
<form action="#" method="post">
<?php
	if (isloggedin()) {
	$erules=get_string('erules');
	echo '<div style="width:100%; margin:1.3em auto;">';
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

<?php
	$erulessql=mysql_query("SELECT * FROM mdl_cifaexamrules WHERE id='16'");
	$erules=mysql_fetch_array($erulessql);
	echo $erules['summary'];
?>
<p>For more information, please <a href="<?=$CFG->wwwroot .'/contactus/upload_index.php'?>" target="_blank"><u><strong>contact us</strong></u></a>.</p>
</div><?php }else{ echo '<div style="margin:2em auto"><h3>'.get_string('examrulesloggin').'</h3></div>'; } ?>
</td></tr></table></center>

<div style="text-align:center;margin-bottom:1em;">
	<input type="submit" id="id_defaultbutton" name="backbutton" onclick="this.form.action='<?=$CFG->wwwroot. '/examrules/admin_examrules_form.php?id=16';?>'" value="Back" />
</div></form>
<?php
	echo $OUTPUT->footer();
?>
