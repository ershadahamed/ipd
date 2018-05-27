<?php	
    require_once('../config.php');
	include('../manualdbconfig.php'); 
	include_once ('../pagingfunction.php');
	
	
	$site = get_site();
	
	$heading='List of report';
	$title="$SITE->shortname: ".$heading;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	
	$PAGE->navbar->add($heading);	
	$PAGE->set_pagelayout('course');
	
	echo $OUTPUT->header();
	
	if (isloggedin()) {
	echo $OUTPUT->heading($heading, 2, 'headingblock header');
?>
    <table width="100%" border="0">
      <tr>
        <td><a href="<?=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;?>" title="<?=get_string('candidateprogress');?>">
		<?=get_string('candidateprogress');?></a>&nbsp;</td>
      </tr>
      <tr>
        <td><a href="<?=$CFG->wwwroot.'/course/report/log/index.php?id=1';?>" title="<?=get_string('activitylog');?>">
		<?=get_string('activitylog');?></a>&nbsp;</td>
      </tr>
      <tr>
        <td><a href="<?=$CFG->wwwroot.'/report/transaction_report.php';?>" title="<?=get_string('transactionreport');?>">
		<?=get_string('transactionreport');?></a></td>
      </tr>
      <tr>
        <td><a href="<?=$CFG->wwwroot.'/report/report_1.php';?>" title="report">
		Sample Report</a></td>
      </tr>
    </table>
<?php	
	}
	echo $OUTPUT->footer();	
?>