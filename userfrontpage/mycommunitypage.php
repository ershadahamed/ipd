<?php
    require_once('../config.php');
	include('../manualdbconfig.php'); 

	$site = get_site();
	$mycommunity=get_string('mycommunity');
	$title="$SITE->shortname: ".$mycommunity;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	$PAGE->navbar->add(get_string('mycommunity'));
		
	echo $OUTPUT->header();		
	if (isloggedin()) {		
		$id=$_GET['id'];
	?>	
	<script type="text/javascript">
		function popupwindow(url, title, w, h) {//Center PopUp Window added by Arizan
		  var left = (screen.width/2)-(w/2);
		  var top = (screen.height/2)-(h/2);
		  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
		} 
	</script>
		<style>
		a:hover {text-decoration:underline;}
		/* ul{	list-style-type: none;} */
		.list li{padding: 0px 0px 0.5em 0px;}
		</style>
		<div style="min-height: 400px;">	
		<form id="form1" name="form1" method="post" action="">
		<fieldset style="padding: 0.6em;" id="user" class="clearfix">
		<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('mycommunity');?></legend>	
		<div class="link-list" style="padding: 0.5em 1em;">
			<ul class="list">
				<li class="item"><a class="link" title="<?=get_string('cifachat');?>" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" target="_blank"><?=get_string('cifachat');?></a></li>
				<li class="item"><a class="link" title="<?=get_string('cifablog');?>" href="#"><?=get_string('cifablog');?></a></li>
				<li class="item"><a class="link" title="<?=get_string('youtube');?>" href="#"><?=get_string('youtube');?></a></li>
				<li class="item">
				<?php $socialnetwork=$CFG->wwwroot. '/mc_socialnetwork.php'; ?>
				<a class="link" title="<?=get_string('socialnetwork');?>" href="javascript:void(0);" onclick="popupwindow('<?=$socialnetwork;?>','googlePopup',1000,500);"><?=get_string('socialnetwork');?></a>
				</li>
				<li class="item"><a class="link" title="<?=get_string('feedbackreview');?>" href="<?php echo $CFG->wwwroot.'/mod/feedback/complete.php?id=128&courseid=&gopage=0';?>"><?=get_string('feedbackreview');?></a></li>
			</ul>
		</div>		
		</fieldset>
		<div style="padding:2px;text-align:center;"><center>			
		<input type="submit" name="back" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" />
		</center></div>		
		</form>
		</div>	
<?php }	?>		
<?php echo $OUTPUT->footer(); ?>