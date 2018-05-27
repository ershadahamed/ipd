<?php include('../config.php'); ?>
<style type="text/css">
#tablecontent{
	margin-left:auto; 
	margin-right:auto; 
	padding:3px; 
	width:100%;
	font-size:0.95em;
	float:left;
}
#boardblock-div{
	border: 2px solid #5DCBEB; 	
	border-radius: 8px;
	margin:0;
	padding:0px 0px 10px 0px;
	min-height: 90px;
	background-color:#fff;
	/*background:url('theme/base/pix/noticeBOARD.png') repeat-x;*/
	width: 200px;	
}
#board-div-title{
	border: 3px solid #5DCBEB; 	
	border-radius: 5px 5px 0px 0px;
	margin:0;
	padding: 4px 0px 0px 10px;
	min-height: 25px;
	background-color:#5DCBEB;<!--#3D91CB-->
	color: #fff;
	font-size: 1.1em;
}
.titlebox{
	text-shadow: 1px 1px 2px #000000;
	padding:5px;
	/*background:url('image/btbg.png') repeat-x;
	color:#fff;*/
	color:#fff;
	font-weight: bolder;
	font-size: 13px;
	border-radius: 8px;
}
#my1{
	width:100%; 
	/*border: 2px solid #3D91CB;*/
	/*height: 155px;
	min-height:110px;*/
	min-height:120px;
	padding:0;
	margin:0;
	border-collapse: collapse;
}
.list{
	list-style: none; 
	padding: 2px; margin: 0;
	color:#A4A4A4;
}
a {cursor:pointer;}
a:link {color:#3D91CB; text-decoration: none;}      /* unvisited link */
a:visited {color:#3D91CB;}  /* visited link */
a:hover {color:#ab381b;}  /* mouse over link */
a:active {color:#3D91CB;}  /* selected link */
</style>
<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td style="padding-right:5px;width: 20%;">
        <div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=ucwords(strtolower(get_string('administrationsite')));?></div>
        <table border="0" id="my1" cellpadding="0" cellspacing="0" style="width:100%;">
            <tr valign="top">
            <td>
                <ul class="list">				
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/admin/roles/assign.php?contextid=1';?>" title="<?=get_string('assignusersroles');?>">
					<?=get_string('assignusersroles');?></a> </li>	
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/admin-commpreference.php';?>" title="<?=get_string('communicationpreferences');?>">
					<?=get_string('communicationpreferences');?></a> </li>	
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>" title="<?=get_string('examresult');?>">
					<?=get_string('examresult');?></a></li>	
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/manualemail/manualsend_email.php?id='.$USER->id;?>" title="<?=get_string('manualemailconfig');?>">
					<?=get_string('manualemailconfig');?></a></li>						
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?=$CFG->wwwroot.'/config/uploadconfig.php';?>" title="Permission to upload users">
					Permission to Upload</a></li> 					
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/prospectstatus.php?id='.$USER->id;?>" title="<?=get_string('prospect');?>">
					<?=get_string('prospect');?></a></li>	
                    <li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
                    <a href="<?=$CFG->wwwroot.'/userfrontpage/resetpassword.php';?>" title="<?=get_string('resetpassword');?>">
                    <?=get_string('resetpassword');?></a></li>					
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/transaction_status.php?id='.$USER->id;?>" title="<?=get_string('transactionstatus');?>">
					<?=get_string('transactionstatus');?></a> </li>						
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?=$CFG->wwwroot.'/userfrontpage/updatecandidate_details.php';?>" title="<?=get_string('updatecandidateinfo');?>">
					<?=get_string('updatecandidateinfo');?></a></li>   					
                </ul>				
            </td>
            </tr>
        </table>
        </div>
		</td>
	</tr>
	<tr valign="top">
		<td style="padding-right:5px;width: 50%;">
        <div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=ucwords(strtolower(get_string('report')));?></div>
        <table border="0" id="my1" cellpadding="0" cellspacing="0" style="width:100%;">
            <tr valign="top">
            <td>
                <ul class="list">    					
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;?>" title="<?=get_string('candidateprogress');?>">
					<?=get_string('candidateprogress');?></a> </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot.'/course/report/log/index.php?id=1';?>" title="<?=get_string('activitylog');?>">
					<?=get_string('activitylog');?></a></li> 
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot.'/report/transaction_report.php';?>" title="<?=get_string('transactionreport');?>">
					<?=get_string('transactionreport');?></a></li> 	
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot.'/report/report_1.php';?>" title="report">
					Report</a></li> 						
                </ul>				
            </td>
            </tr>
        </table>
        </div>
		</td>        
	</tr>
</table>