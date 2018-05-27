<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $scheduling = get_string('schedulingreport');
    $listusertoken = get_string('myreport');
	$myadmin = get_string('myadmin');
	$url1=new moodle_url('/examcenter/myreport.php', array('id'=>$USER->id));  
	$url_currentpage=$CFG->wwwroot. '/examcenter/schedulling.php?id='.$USER->id.'&rid='.$_GET['rid'];
    $PAGE->navbar->add(ucwords(strtolower($myadmin)), $url1)->add(ucwords(strtolower($listusertoken)), $url1);	
	$PAGE->navbar->add(ucwords(strtolower($scheduling)), $url_currentpage);

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
?>

<script type="text/javascript">
function popupwindow(url, title, w, h) {//Center PopUp Window added by Izzat
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
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
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('schedulingreport');?></legend><div style="color:#F00;">
<?//=get_string('newnotice');?><br/>
<?//=get_string('editnotice');?></div><br/>

<form name="form1" id="form1" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">
          		<input type="submit" id="id_defaultbutton" name="backbutton" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php';?>', target='_parent'" value="Back" />
				<input type="submit" name="newschedule" id="newschedule" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/newscheduling.php?id='.$USER->id.'&rid='.$_GET['rid'].'&sid='.$_GET['sid'];?>', target='_blank'" value="<?=get_string('newschedule');?>" /></td>
		</tr>    
	</table>

  <?php		
	$statement="
	  mdl_cifareport_scheduling a Inner Join
	  mdl_cifareport_recipient b On a.id = b.scheduling_id Inner Join
	  mdl_cifauser c On b.recipient_id = c.id Inner Join
	  mdl_cifareport_menu d On a.rid = d.id
	";
	
	$csql="SELECT * FROM {$statement} WHERE a.rid='".$_GET['rid']."' GROUP BY a.id ORDER BY a.rid ASC";
	$sqlquery=mysql_query($csql);	
	?>	
	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th style="text-align:left;"><?=get_string('reportname');?></th>
		  <th style="text-align:left;" width="20%"><?=get_string('createdby');?></th>
		  <th width="8%"><?=get_string('recipient');?></th>
		  <th width="15%"><?=get_string('sendschedule');?></th>
		  <th width="5%"><?=get_string('edit');?></th>
		  <th width="5%"><?=get_string('delete');?> Schedule</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/examcenter/progressreport.php?id=".$USER->id;
	$linkeditscheduling=$CFG->wwwroot.'/examcenter/edit_scheduling.php?id='.$sqlrow['rid'].'&scheduling='.$sqlrow['scheduling'].'&scdid='.$sqlrow['scheduling_id'];
	$linkdelete=$CFG->wwwroot.'/examcenter/deletereport.php?scdid='.$sqlrow['scheduling_id'].'&sid='.$sqlrow['selectedreport'];
	$bil=$no++;
	
	$statement2="
	  mdl_cifareport_scheduling a Inner Join
	  mdl_cifareport_recipient b On a.id = b.scheduling_id Inner Join
	  mdl_cifauser c On b.recipient_id = c.id Inner Join
	  mdl_cifareport_menu d On a.rid = d.id
	";
	
	$csql2="SELECT * FROM {$statement2} WHERE b.scheduling_id='".$sqlrow['scheduling_id']."' AND a.rid='".$_GET['rid']."' AND a.scheduling='".$sqlrow['scheduling']."' ORDER BY a.rid ASC";
	$sqlquery2=mysql_query($csql2);	
	$mycount2=mysql_num_rows($sqlquery2);	
?>
<script language="javascript">
function ConfirmDelete()
{
	var result = confirm("Are you sure you want delete the report?\nDeleted report are not retrievable.");
	if (result==true) {
		//Logic to delete the item
		window.open('<?=$linkdelete;?>');
		window.close();
	}
}
</script>
		<tr>
		  <td scope="row">
			<?=strtoupper($sqlrow['reportname']);?>
			<input type="hidden" name="scheduling_id" value="<?=$sqlrow['scheduling_id'];?>" />
		 </td>
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
		  <td style="text-align:center;">
		  <a title="Click to view recipient" href="javascript:void(0);" onclick="popupwindow('recipientlist.php?id=<?=$sqlrow['rid'].'&scheduling='.$sqlrow['scheduling'].'&sid='.$sqlrow['scheduling_id'];?>','googlePopup',800,400);">		  
		  (<?=$mycount2;?>)</a></td>
		  <td style="text-align:center;">
			<?php
				if($sqlrow['scheduling']=='weekly'){ // weekly
					if($sqlrow['scheduling_value']=='1'){ echo ucwords(strtolower($sqlrow['scheduling'].', Monday'));
					}else if($sqlrow['scheduling_value']=='2'){ echo ucwords(strtolower($sqlrow['scheduling'].', Tuesday'));
					}else if($sqlrow['scheduling_value']=='3'){ echo ucwords(strtolower($sqlrow['scheduling'].', Wednesday'));
					}else if($sqlrow['scheduling_value']=='4'){ echo ucwords(strtolower($sqlrow['scheduling'].', Thursday'));
					}else if($sqlrow['scheduling_value']=='5'){ echo ucwords(strtolower($sqlrow['scheduling'].', Friday'));
					}else if($sqlrow['scheduling_value']=='6'){ echo ucwords(strtolower($sqlrow['scheduling'].', Saturday'));
					}else{ echo $sqlrow['scheduling'].', Sunday';}
				}else if($sqlrow['scheduling']=='daily'){
					echo ucwords(strtolower($sqlrow['scheduling'])); // daily
				}else{
					echo ucwords(strtolower($sqlrow['scheduling'].', '.$sqlrow['scheduling_value'])); // monthly
				}
			?>
		  </td>
		  <td style="text-align:center;">
		  <input onClick="this.form.action='<?=$linkeditscheduling;?>'" title="<?=get_string('edit');?>" type="image" src="<?=$CFG->wwwroot.'/image/edit_ico.png';?>" name="image" width="30"></td>
		  <td align="center">
		  <input Onclick="ConfirmDelete()" type="image" title="<?=get_string('delete');?>" src="<?=$CFG->wwwroot.'/image/delete_ico.png';?>" name="image" width="30">
		  </td>
		</tr>

<?php
	}
	
	}else{
?>
		<tr><td colspan="8" scope="row">Records not found</td></tr>
<?php } ?>
		</table></form></fieldset>
<?php 
	echo $OUTPUT->footer();
?>