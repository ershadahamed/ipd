<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('myreport');
	$myadmin = get_string('myadmin');
	$url1=new moodle_url('/examcenter/myreport.php', array('id'=>$USER->id));  
    $PAGE->navbar->add(ucwords(strtolower($myadmin)), $url1)->add(ucwords(strtolower($listusertoken)), $url1);	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
?>

<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
</style>


<br/>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('myreport');?></legend>
<div style="color:#F00; margin-bottom:1em;">
<?//=get_string('reportdeletedsuccessfully');?></div>

<form name="form1" id="form1" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">
				<input type="submit" name="creatednewreport" id="creatednewreport" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu.php?id='.$USER->id;?>'" value="<?=get_string('creatednewreport');?>" /></td>
		</tr>    
	</table>
  <?php		
	$statement="
		  mdl_cifareport_menu a Inner Join
		  mdl_cifareport_option b On b.reportid = a.id Inner Join
		  mdl_cifareport_users c On b.reportid = c.reportid
	";
	
	// $statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate'";
	$statement.=" WHERE a.reportcreator = '".$USER->id."'";
	$csql="SELECT * FROM {$statement} GROUP BY b.reportid ORDER BY b.reportid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th><?=get_string('reportname');?></th>
		  <th width="20%"><?=get_string('createdby');?></th>
		  <th width="20%"><?=get_string('creationdate');?></th>
		  <th width="5%"><?=get_string('view');?></th>
		  <th width="5%"><?=get_string('schedule');?></th>
		  <th width="5%"><?=get_string('edit');?></th>
		  <th width="5%"><?=get_string('delete');?></th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){ 
	$linkto=$CFG->wwwroot. '/examcenter/progressreport.php?id='.$sqlrow['reportid'].'&sid='.$sqlrow['selectedreport'];
	$linkschedule=$CFG->wwwroot. '/examcenter/schedulling.php?id='.$USER->id.'&rid='.$sqlrow['reportid'].'&sid='.$sqlrow['selectedreport'];
	$linkeditreport=$CFG->wwwroot.'/examcenter/editreport.php?id='.$sqlrow['reportid'].'&sid='.$sqlrow['selectedreport'];
	$linkdelete=$CFG->wwwroot.'/examcenter/deletemyreport.php?rid='.$sqlrow['reportid'].'&sid='.$sqlrow['selectedreport'];
	$bil=$no++;
?>
<script language="javascript">
function ConfirmDelete()
{
	var result = confirm("Are you sure you want delete the report?\nDeleted report are not retrievable.");
	if (result==true) {
		//Logic to delete the item
		// window.location.href="<?=$linkdelete;?>";
		// window.open("<?=$linkdelete;?>", "DescriptiveWindowName");
		// window.close();
		return href;
	}
}
</script>
		<tr>
		  <td scope="row"><?=strtoupper($sqlrow['reportname']);?></td>
		  <td>
            <?php
				$sm=mysql_query("
					Select
					  *
					From
					  mdl_cifarole a Inner Join
					  mdl_cifarole_assignments b On a.id = b.roleid
					Where
					  b.userid = '".$sqlrow['reportcreator']."' And
					  b.contextid = '1'				
				");
				$ssm=mysql_fetch_array($sm);
				echo $ssm['name'];
			?>
          </td>
		  <td style="text-align:center;"><?=date('d/m/Y H:i:s', $sqlrow['timecreated']);?></td>
		  <td style="text-align:center;">
		  <!--a title="<?//=get_string('viewprogress');?>" href="<?//=$linkto;?>"><?//=get_string('view');?></a-->
		  <input onClick="this.form.action='<?=$linkto;?>'" title="<?=get_string('view');?>" type="image" src="<?=$CFG->wwwroot.'/image/view_ico.png';?>" name="image" width="40">
		  </td>
		  <td style="text-align:center;">
		  <!--a title="<?//=get_string('viewprogress');?>" href="<?//=$linkschedule;?>" target="_blank">
		  <?//=get_string('schedule');?></a-->
		  <input onClick="this.form.action='<?=$linkschedule;?>'" title="<?=get_string('schedule');?>" type="image" src="<?=$CFG->wwwroot.'/image/schedule_ico.png';?>" name="image" width="25">
		  </td>
		  <td style="text-align:center;"><input onClick="this.form.action='<?=$linkeditreport;?>'" title="<?=get_string('edit');?>" type="image" src="<?=$CFG->wwwroot.'/image/edit_ico.png';?>" name="image" width="30"></td>
		  <td align="center">
          <a href="<?=$linkdelete;?>" Onclick="ConfirmDelete()"  title="<?=get_string('delete');?>"><?=get_string('delete');?></a>
		  <!--input Onclick="ConfirmDelete()" type="image" title="<?=get_string('delete');?>" src="<?=$CFG->wwwroot.'/image/delete_ico.png';?>" name="image" width="30"-->
		  </td>		  
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="8" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form></fieldset>

<?php 
	echo $OUTPUT->footer();
?>