<?php include('../config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style type="text/css">
#tablecontent{
	margin-left:auto; 
	margin-right:auto; 
	padding:10px; 
	width:100%;
}
#boardblock-div{
	border: 1px solid #3D91CB; 	
	border-radius: 8px 8px 8px 8px;
	margin:0;
	padding:0px 0px 10px 0px;
	min-height: 90px;
	height:150px;
	background-color:#fff;
	background:url('theme/base/pix/noticeBOARD.png') repeat-x;		
}
#board-div-title{
	border: 3px solid #3D91CB; 	
	border-radius: 8px 8px 8px 8px;
	margin:0;
	padding: 4px 0px 0px 10px;
	min-height: 25px;
	background-color:#fff; 
}
.titlebox{
	text-shadow: 1px 1px 2px #000; 
	padding:5px;
	/*background:url('image/btbg.png') repeat-x;
	color:#fff;*/
	color:#000;
	font-weight: bolder;
	font-size: 13px;
	border-radius: 10px 10px 10px 10px;
}
#my1{
	width:100%; 
	/*border: 2px solid #3D91CB;*/
	/*height: 155px;
	min-height:110px;*/
	height:120px;
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
<body>
<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td style="padding-right:5px;width: 50%;">
        <div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=ucwords(strtolower(get_string('administrationsite')));?></div>
        <table border="0" id="my1" cellpadding="0" cellspacing="0" style="width:100%;">
            <tr valign="top">
            <td>
                <ul class="list">
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/admin/roles/assign.php?contextid=1';?>" title="<?=get_string('assignusersroles');?>">
					<?=get_string('assignusersroles');?></a> </li>				
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;?>" title="<?=get_string('candidateprogress');?>">
					<?=get_string('candidateprogress');?></a> </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>" title="<?=get_string('examresult');?>">
					<?=get_string('examresult');?></a></li>
                    <li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
                    <a href="<?=$CFG->wwwroot.'/userfrontpage/resetpassword.php';?>" title="<?=get_string('resetpassword');?>">
                    <?=get_string('resetpassword');?></a></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
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
        <div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=ucwords(strtolower(get_string('myreport')));?></div>
        <table border="0" id="my1" cellpadding="0" cellspacing="0" style="width:100%;">
            <tr valign="top">
            <td>
                <ul class="list">
                    <!--li><img src="<?php //echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?//=get_string('scheduledreport');?></li>
                    <li><img src="<?php //echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?//=get_string('newreport');?></li-->                   					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot.'/course/report/log/index.php?id=1';?>" title="<?=get_string('activitylog');?>">
					<?=get_string('activitylog');?></a></li>            	
                </ul>				
            </td>
            </tr>
        </table>
        </div>
		</td>        
	</tr>
</table>
</body>
</html>