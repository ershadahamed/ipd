<style type="text/css">
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
#tablecontent{
	margin-left:auto; 
	margin-right:auto; 
	padding:10px; 
	width:94%;
}
.titlebox-noticeboard{
	text-shadow: 1px 1px 2px #000; 
	height: 10px; 
	vertical-align: middle;
	text-align: left;
	padding:5px;
	color:#fff;
	font-weight: bolder;
	border-top-left-radius: 8px 8px;
	border-top-right-radius: 8px 8px;
}
.titlebox{
	text-shadow: 1px 1px 2px #000; 
	/*background-color:#E8E8E8; */
	padding:5px;
	/*background:url('image/btbg.png') repeat-x;
	color:#fff;*/
	color:#fff;
	font-weight: bolder;
	border-radius: 10px 10px 10px 10px;
}
.titlebox2{
	text-shadow: 1px 1px 2px #000; 
	background-color:#ccc; 
	border-bottom: 1px solid #DDD;
	width: 260px; 
	height: 25px; 
	vertical-align: middle;
	padding:5px;
	background:#ececec url('image/titleH.png') repeat-x;
	color:#000;
	font-weight: bolder;
	border-top-left-radius: 5px 8px;
	border-top-right-radius: 8px 8px;
}
#board-div{
	border: 2px solid #5DCBEB; 	
	border-top-left-radius: 10px 10px;
	border-top-right-radius: 10px 10px;
	border-bottom-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 90px;
	height:160px;
	background-color:#fff; 
	/*background:url('theme/base/pix/noticeBOARD.png');	
	background-repeat:no-repeat; 
	background-position:center;	*/
}
#board-div3{
	border: 2px solid #5DCBEB; 	
	border-top-left-radius: 10px 10px;
	border-top-right-radius: 10px 10px;
	border-bottom-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	/*min-height: 560px;*/ /*ogos 2013*/
	background-color:#fff; 	
}

#board-div-title{
	border: 3px solid #5DCBEB; 	
	border-radius: 5px 5px 0px 0px;
	margin:0;
	padding: 2px 0px 0px 18px;
	min-height: 25px;
	background-color:#5DCBEB;
	font-size: 1.1em;
	
}
#board-div-noticeboard{
	border: 3px solid #5DCBEB; 	
	border-radius: 8px 8px 0px 0px;
	margin:0;
	padding: 4px 0px 0px 20px;
	min-height: 25px;
	background-color:#5DCBEB; 
	font-size: 1.1em;
	
}
#boardblock-div{
	border: 2px solid #5DCBEB; 	
	border-radius: 8px 8px 8px 8px;
	margin:0;
	padding:0px 0px 10px 0px;
	min-height: 165px;
	/*height:150px;*/
	background-color:#fff;
	/*background:url('theme/base/pix/noticeBOARD.png') repeat-x;	*/	
}
#boardblock-div2{
	border: 2px solid #5DCBEB; 	
	border-top-left-radius: 10px 10px;
	border-top-right-radius: 10px 10px;
	border-bottom-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 90px;
	height:198px;
	background-color:#fff; 
	/*background:url('theme/base/pix/noticeBOARD.png') repeat-x;	*/
}
#mynoticeboard{
	width:100%; 
}
.mynoticeboard-content{ 
	height:300px;
	padding:10px;
	overflow: hidden;
}

.hotmenu-content{ 
	padding:10px;
	margin-left: auto;
	margin-right:auto;
	color:#A4A4A4;	
}

.list{
	list-style: none; 
	padding: 2px; margin: 0;
	color:#A4A4A4;
}
a {
	cursor:pointer;
}
a:link {color:#0036ff; text-decoration: none;
/*font-weight:bolder;*/}      /* unvisited link */
a:visited {color:#0036ff;}  /* visited link */
a:hover {color:#ab381b;}  /* mouse over link */
a:active {color:#0036ff;}  /* selected link */

</style>
		<!--h2><?//=get_string('welcomenote');?></h2-->
		<!-------box for noticeboard----------->
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
		<tr valign="top"><td style="width:70%">
		<?php
		/***********add by arizan 22/02/2012**************************************************/
		$queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
			foreach($queryrole as $qrole){ }
		/************************************************************/	
		//echo $qrole->roleid. 'test '.$USER->id;
		?>
		<!-----Hot menu----->
		<?php 
			//if($qrole->roleid!='9' && $qrole->roleid!='14'){ 	
			if($qrole->roleid=='10'){ 			
			$iconwidth="60"; //active candidates
		?>
		<table border="0" style="padding:0; margin:0">
		<tr>
			<td colspan="4">
			<!--div id="board-div"-->
			<table border="0" id="mynoticeboard" cellpadding="0" cellspacing="0" style="padding:0; margin:0; margin-bottom: 0px;">
				<!--tr><td class="titlebox2">Hot menu</td></tr-->
				<tr valign="top">
					<td class="hotmenu-content">  
					<?php if(($qrole->roleid) != '16' && ($qrole->roleid) != '10' && $qrole->roleid != '9' && $qrole->roleid != '13'){ //active candidates?>
					<?php
						//sql to count module on CIFAONLINE
						$statement="mdl_cifacourse a, mdl_cifaenrol b, mdl_cifauser_enrolments c, mdl_cifauser d";
						$statement.=" WHERE a.id = b.courseid And b.id = c.enrolid And c.userid = d.id And (a.category = '1' And c.userid = '".$USER->id."' And a.visible = '1')";
						$sql=mysql_query("SELECT * FROM {$statement}");
						$qcount=mysql_num_rows($sql);		
					?>
					<table width="100%">
					<tr>
						<td width="15%" align="center" valign="top">
						<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?php echo get_string('personaldetails');?>">
						<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('personaldetails');?>"></a></td>
						<td width="14%" align="center" valign="top">
						<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
						<img src="<?php echo $CFG->wwwroot.'/image/changepwd.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('changepassword');?>">
						</a></td>						
						<td width="14%" align="center" valign="top">
						<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
						<img src="<?php echo $CFG->wwwroot.'/image/modules.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('mytrainingprogram');?>">
						</a></td>
						
						<td width="14%" align="center" valign="top">
						<a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>">
						<img src="<?php echo $CFG->wwwroot.'/image/full-shopping-cart-icon.png?id='.$USER->id;?>" width="48" border="0" title="<?=get_string('purchaseprogram');?>"></a></td>
						<td width="14%" align="center" valign="top"><img src="<?php echo $CFG->wwwroot.'/image/financial.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('financialstatement');?>"></td>
						<td width="14%" align="center" valign="top">
						<a href="<?=$CFG->wwwroot.'/mod/feedback/view.php?id=205';?>" title="<?=get_string('feedback');?>">
						<img src="<?php echo $CFG->wwwroot.'/image/people_online.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('feedback');?>">
						</a></td>
						<td width="15%" align="center" valign="top">
						<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank" title="<?=get_string('cifachat');?>">
						<img src="<?php echo $CFG->wwwroot.'/image/chat-icon.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('cifachat');?>"></a></td>
					</tr>
					<tr>
						<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?php echo get_string('personaldetails');?>"><?=get_string('personaldetails');?></a></td>
						<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
							<?=get_string('changepassword');?></a></td>
						<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
						<?=get_string('mytrainingprogram');?></a></td>
						<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>">
						<?=get_string('purchaseprogram');?></a></td>
						<td align="center" valign="top"><?=get_string('financialstatement');?></td>
						<td align="center" valign="top"><a href="<?=$CFG->wwwroot.'/mod/feedback/view.php?id=205';?>" title="<?=get_string('feedback');?>">
						<?=get_string('feedback');?></a></td>
						<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank" title="<?=get_string('cifachat');?>"><?=get_string('cifachat');?></a></td>
					</tr>
					</table>
					<?php } ?>                                          
                                            
					<?php if(($qrole->roleid) == '10'){ // exam centre admin?>	
					<table width="100%" border="0">
					<tr align="center" valign="top">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?><?php //echo $CFG->wwwroot.'/manage_exam_index.php?id='.$USER->id; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/office-building-icon.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('examcentre');?>">
							<br/><?=get_string('examcentre').' Details';?></a></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/offlineexam/examregistration_home.php?id='.$USER->id; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/manage-registrations.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('candidatemanagement');?>">
							<br/><?=get_string('candidatemanagement');?></a></div></td>								
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/course/view.php?id=12'; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/User-Group-icon-upload.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('downloadexamsoftware');?>">
							<br/><?=get_string('downloadexamsoftware');?></a></div></td>									
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/upload_software.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/upload-examanswer.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('uploadexamresult');?>">
						<br/><?=get_string('uploadexamresult');?></a></div></td>							
						<td><div style="padding:3px;">
							<img src="<?php echo $CFG->wwwroot.'/image/Invoice-icon.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('paymentrecords');?>">
						<br/><?=get_string('paymentrecords');?></div></td>	
						<td><div style="padding:3px;"><img src="<?php echo $CFG->wwwroot.'/image/cifaBlog.png?id='.$USER->id;?>" width="48" border="0" title="<?=get_string('cifablog');?>">
						<br/><?=get_string('cifablog');?></div></td>						
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank">
							<img src="<?php echo $CFG->wwwroot.'/image/chat-icon.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('cifachat');?>">
						<br/><?=get_string('cifachat');?></a></div></td>							
					</tr></table>					
					<?php } ?>
					
					<?php if(($qrole->roleid) == '13'){ // Institutional Client //HR Admin 
					
						$sql1=mysql_query("Select * from mdl_cifaassign_site WHERE active='1'");
						$sp1=mysql_num_rows($sql1);				
					?>					
					<table style="padding:0px; margin:0px; border-collapse:collapse; border:0px;" width="100%">
					<tr valign="bottom">
					<td width="15%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?=get_string('personaldetails');?>">
					<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('personaldetails');?>"></a></td>
					<td width="14%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
					<img src="<?php echo $CFG->wwwroot.'/image/changepwd.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('changepassword');?>"></a></td>
					<td width="14%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
					<img src="<?php echo $CFG->wwwroot.'/image/modules.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('mytrainingprogram');?>"></a></td>
					<?php if($sp1=='1'){?>
					<td width="14%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/bulkusersupload.php'; ?>">
					<img src="<?php echo $CFG->wwwroot.'/image/manage-registrations.png?id='.$USER->id;?>" width="48" border="0" title="<?=get_string('candidatemanagement');?>"></a></td>
					<?php } ?>
					</tr>
					<tr valign="top">
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?php echo get_string('personaldetails');?>"><?=get_string('personaldetails');?></a></td>
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
							<?=get_string('changepassword');?></a></td>
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
						<?=get_string('mytrainingprogram');?></a></td>
					<?php if($sp1=='1'){?>
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/bulkusersupload.php'; ?>" title="<?=get_string('uploadusers','admin');?>">
						<?=get_string('uploadusers','admin');?></a></td>	<?php } ?>					
					</tr>
					</table>					
					
					
					<?php } ?>
					
					<?php if(($qrole->roleid) == '16'){ // Prospect ?>
					<table border="0" style="text-align:center;">
					<tr>
					<td width="15%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?php echo get_string('personaldetails');?>"><img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('personaldetails');?>"></a></td>
					<td width="14%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>"><img src="<?php echo $CFG->wwwroot.'/image/changepwd.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('changepassword');?>"></a></td>
					<td width="14%" align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>"><img src="<?php echo $CFG->wwwroot.'/image/full-shopping-cart-icon.png?id='.$USER->id;?>" width="48" border="0" title="<?=get_string('purchaseprogram');?>"></a></td>
					</tr>
					<tr>
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?php echo get_string('personaldetails');?>"><?=get_string('personaldetails');?></a></td>
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
							<?=get_string('changepassword');?></a></td>
					<td align="center" valign="top"><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>">
						<?=get_string('purchaseprogram');?></a></td>
					</tr>
					</table>
					<?php } ?>					
					</td>
				</tr>
			</table>	
			<!--/div-->			
			</td>
		</tr></table><?php } ?>
		
		<!----box for menu---->
        <?php //IPD candidate 
			$IPDstatement=" mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='".$USER->id."'";
			$selIPD=mysql_query("SELECT * FROM {$IPDstatement}");
			$cIPD=mysql_num_rows($selIPD); 
			
			//echo $cIPD;
		?>
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr valign="top">
		
		<?php if(($qrole->roleid) == '9'){ //Inactive candidates ?>
		<!--My training-->
		<td style="padding-right:5px;width: 50%;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mytraining');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>
						<ul class="list">
							<?php /*SHAPE IPD*/ if($cIPD!='0'){?>
								<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newcourse');?></li>
							<?php }else{ ?>	
								<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newcurriculum');?></li>
							<?php } ?>
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>	
		
		<!--My training-->
		<td style="padding-right:5px;width: 50%;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mydetails');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>
					<ul class="list">
						<!---------available on inactive candidates--------->
						<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
							<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">&nbsp;Employment&Educational Background</li>			
					</ul>		
				</td>
				</tr>
			</table>
			</div>
		</td>		
		<?php } ?>
		
		<?php if($qrole->roleid!= '16' && $qrole->roleid != '9' && $qrole->roleid != '13' && $qrole->roleid!='14'){ //active candidates ?>
		<tr valign="top">
			<td style="padding-right:5px; width: 33%;">
			<?php if($qrole->roleid!= '10' && $qrole->roleid != '9' && $qrole->roleid != '12' && $qrole->roleid != '13'){  ?>
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myaccount');?></div><?php }else{ ?>
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myaccount');?></div><?php } ?>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">	
					<td>
						<?php if($qrole->roleid!= '10' && $qrole->roleid != '9'){ //active candidates ?>
						<?php 
							$selectstatement=mysql_query("SELECT * FROM mdl_cifacommunication_reference WHERE candidateid='".$USER->id."'");
							$ssql=mysql_num_rows($selectstatement);
							
							$selectstatement2=mysql_query("SELECT * FROM mdl_cifacandidates WHERE traineeid='".$USER->traineeid."'");
							$ssql2=mysql_num_rows($selectstatement2);							
						?>							
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
								<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('profile');?></a></li>
							<!--li><img src="<?php //echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
								<a href="<?php //echo $CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&course=1';?>" title="<?//=get_string('editmyprofile');?>"><?//=ucwords(strtolower(get_string('editmyprofile')));?></a></li-->								
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
								<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>"><?=get_string('changepassword');?></a></li>	
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">&nbsp;<?=get_string('financialstatement');?></li>
							<?php if($ssql2!='0'){ ?>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
								<a href="<?php echo $CFG->wwwroot.'/userfrontpage/listofnameenrolment.php'; ?>"><?=get_string('enrolmentconfirmation');?></a></li>
							<?php }else{ ?>
								<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" title="<?=get_string('enrolmentconfirmation');?>" width="15"> 							
								<?=get_string('enrolmentconfirmation');?></li>								
							<?php } ?>
						</ul>
						<?php }?>

						<!---------available for exam centre admin--------->
						<?php if(($qrole->roleid) == '10'){ ?>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
							<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('examcentre').' Details';?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
							<a href="<?php echo $CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&course=1';?>" title="<?=get_string('editmyprofile');?>">
							<?//=get_string('editmyprofile');?><?=ucwords(strtolower(get_string('editmyprofile')));?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
							<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>"><?=get_string('changepassword');?></a></li>								
						</ul>
						<?php } ?>						
					</td>
				</tr>
			</table>
			</div>
		</td>
		<?php } ?>
		
		
		<?php if($qrole->roleid!= '16' && $qrole->roleid!= '10' && $qrole->roleid != '9' && $qrole->roleid != '12' && $qrole->roleid != '13' && $qrole->roleid!='14'){ //active candidates ?>
		<!--My training-->
		<td style="padding-right:5px;width: 35%;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mytraining');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">							
							<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>"> <?=get_string('activetrainings');?></a></li>
							<?php /*SHAPE IPD*/ if($cIPD!='0'){ 
								if($start <= $current && $current <= $ex){ //if ada new course available
							?>
								<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
								<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>"> <?=get_string('newtrainings');?></a></li>
							<?php }else{ ?>
								<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newtrainings');?></li>
							<?php } ?>	
								<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
								<a href="<?=$CFG->wwwroot. '/userfrontpage/viewuserresult.php?id='.$USER->id;?>" title="<?=get_string('examresultcifa');?><?//=get_string('testresults');?>">
								<?=get_string('examresultcifa');?></a></li>
							<?php }else{ ?>
							
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newcurriculum');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('examstatement');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
							<a href="<?=$CFG->wwwroot. '/userfrontpage/viewuserresult.php?id='.$USER->id;?>" title="<?=get_string('examresultcifa');?>">
							<?=get_string('examresultcifa');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('examregulation');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('examguide');?></li>
							<?php } ?>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
							<a href="<?=$CFG->wwwroot .'/SHAPEpolicy.pdf';?>" target="_blank">
							<?=get_string('cifaonlinepolicy');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('onlineportal');?></li-->
						</ul>
				</td>
				</tr>
			</table>
			</div>
		</td>	<!--/tr-->
		
		<!--My Financial>
        <tr-->		
		<!--My Community-->
		<td style="padding-right:5px;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mycommunity');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
								<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" target="_blank"><?=get_string('cifachat');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('cifablog');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('ifforums');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('youtube');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('socialnetwork');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('feedbackreview');?></li>							
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td></tr>		
		<?php } ?>
                
        <?php if(($qrole->roleid) == '9'){ //Inactive candidates ?>
        <tr><td colspan="2" style="padding-right:5px;width: 100%;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myfinancial');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>
					<ul class="list">
						<li><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>">
						<img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('reactivemembership');?></a> </li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('paynow');?> </li>
					</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td></tr>
        <?php } ?>
                
		<!---------my students- available on intitutional client--------->
		<td style="padding-right:5px; display:none;width: 50%;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mystudents');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<!--tr><td class="titlebox"><?//=get_string('mystudents');?></td></tr-->
				<tr valign="top">
				<td>
						<ul class="list">
							<li><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>">My Modules (Report on students study status) </a></li>
							<li><a href="">Statistic on passing rate (by module)</a></li>
							<li><b>Module available</b></li>
							<li><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>">In development</a></li>
							<li><a href="">Available for purchase</a></li>
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>
<?php if($qrole->roleid == '10' OR $qrole->roleid == '12'){ //active business partner / exam center admin?>
<!--My candidate-->
<td style="padding-right:5px;width: 50%;">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mycandidates');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('mycandidates');?></td></tr-->
		<tr valign="top">
		<td>
				<ul class="list">
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/mytrainingprogram.php?='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
					<?=get_string('mytrainingprogram');?></a> </li>				
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">					
					<?=get_string('newcurriculum');?> / course
					</li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;?>" title="<?=get_string('candidateprogress');?>">
					<?=get_string('candidateprogress');?></a> </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>" title="<?=get_string('examresult');?>">
					<?=get_string('examresult');?></a></li>
				</ul>				
		</td>
		</tr>
	</table>
	</div>
</td>

<!--My reports-->
<tr><td style="padding-right:5px;">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myreport');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('myreport');?></td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('scheduledreport');?></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newreport');?></li>
			</ul>				
		</td>
		</tr>
	</table>
	</div>
</td>
<!--My Admin Roles-->
<td style="padding-right:5px;">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myadminroles');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('myadminroles');?></td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('onlineportalguide');?></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
				<a href="<?=$CFG->wwwroot.'/userfrontpage/resetpassword.php';?>" title="<?=get_string('resetpassword');?>">
				<?=get_string('resetpassword');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
				<a href="<?=$CFG->wwwroot.'/userfrontpage/updatecandidate_details.php';?>" title="<?=get_string('updatecandidateinfo');?>">
				<?=get_string('updatecandidateinfo');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('cifaexamportal');?></li>
			</ul>				
		</td>
		</tr>
	</table>
	</div>
</td></tr>		
<?php } ?>

<?php if($qrole->roleid == '13'){ //active institution client ?>

<!--My Details-->
<tr>
<td style="padding-right:5px;" width="50%">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mydetails');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('mydetails');?></td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
				<a href="<?php echo $CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&course=1';?>" title="<?=get_string('editmyprofile');?>">
				<?=ucwords(strtolower(get_string('editmyprofile')));?></a></li>					
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>"><?=get_string('changepassword');?></a></li>
			</ul>
		</td>
		</tr>
	</table>
	</div>
</td>

<!--My candidate-->
<td style="padding-right:5px;">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mycandidates');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td>
				<ul class="list">
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('mytrainingprogram');?> </li>					
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> Online Portal navigation guide</li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newcurriculum');?> / course </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> Candidate progress </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>" title="<?=get_string('examresult');?>">
					<?=get_string('examresult');?></a></li>
				</ul>				
		</td>
		</tr>
	</table>
	</div>
</td></tr>
<!--My reports-->
<tr><td style="padding-right:5px;">
	<div id="boardblock-div2"><div id="board-div-title" class="titlebox"><?=get_string('myreport');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('myreport');?></td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('scheduledreport');?></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newreport');?></li>
			</ul>				
		</td>
		</tr>
	</table>
	</div>
</td>	
<!--My Community-->
<td style="padding-right:5px;">
	<div id="boardblock-div2" style="height:198px;"><div id="board-div-title" class="titlebox"><?=get_string('mycommunity');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('mycommunity');?></td></tr-->
		<tr valign="top">
		<td>Linked to LearnCifa.com except (*)</td></tr>
		<tr valign="top">
		<td>
				<ul class="list">
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
						<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" target="_blank"><?=get_string('cifachat');?> * </a></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('cifablog');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('ifforums');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('youtube');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('socialnetwork');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('feedbackreview');?> *</li>								
				</ul>
		</td>
		</tr>
	</table>
	</div>
</td>	</tr>
<?php } ?>

<?php if($qrole->roleid == '14'){ //inactive institutional client ?>
<!--My details-->
<td style="padding-right:5px;">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mydetails');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('mydetails');?></td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> 
				<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>						
			</ul>
		</td>
		</tr>
	</table>
	</div>
</td>

<!--My candidates-->
<td style="padding-right:5px;">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mycandidates');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('mycandidates');?> </td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15"> <?=get_string('newcurriculum');?></li>						
			</ul>
		</td>
		</tr>
	</table>
	</div>
</td>
<?php } ?>

<?php if(($qrole->roleid == '16')){ //active institution client ?>

<!--My Details-->
<tr>
<td style="padding-right:5px;" width="50%">
	<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mydetails');?></div>
	<table border="0" id="my1" cellpadding="0" cellspacing="0">
		<!--tr><td class="titlebox"><?//=get_string('mydetails');?></td></tr-->
		<tr valign="top">
		<td>
			<ul class="list">
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?php echo $CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&course=1';?>" title="<?=get_string('editmyprofile');?>">
					<?=ucwords(strtolower(get_string('editmyprofile')));?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
					<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>"><?=get_string('changepassword');?></a></li>
			</ul>
		</td>
		</tr>
	</table>
	</div>
</td>

<!-- My financial -->
<td style="padding-right:5px;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myfinancial');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>
					<ul class="list">
						<!--li><img src="<?php //echo $CFG->wwwroot. '/image/system1.png';?>" width="15">&nbsp;<?//=get_string('financialstatement');?></li-->
						<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
						<a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>"><?=get_string('purchaseprogram');?></a></li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system1.png';?>" width="15">
						<a href="<?php echo $CFG->wwwroot.'/userfrontpage/continuepurchases/continuemypurchases_first.php'; ?>" title="<?=get_string('continuemypurchases');?>"><?=get_string('continuemypurchases');?></a></li>
						<!--li><img src="<?php //echo $CFG->wwwroot. '/image/system1.png';?>" width="15">&nbsp;Pay now </li-->						
					</ul>				
				</td>
				</tr>
			</table>
			</div>
</td></tr>
<?php } ?>
		
		</tr>
		</table><br/><?php //} ?><td>
<td style="width:40%">	
		
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td colspan="4">
			
			<div id="board-div3">
			<div id="board-div-noticeboard" class="titlebox-noticeboard">Noticeboard</div>
			<table border="0" id="mynoticeboard" cellpadding="0" cellspacing="0">
				<!--tr><td class="titlebox"><div id="board-div-title">Noticeboard</div></td></tr-->
				<tr valign="top">
					<td class="mynoticeboard-content">
					<?php 
						$sqlN=mysql_query("SELECT id, course, forum, name FROM mdl_cifaforum_discussions WHERE course='1'");
						//$rsN=mysql_fetch_array($sqlN);
						$rsN=mysql_num_rows($sqlN);
						if($rsN>'1'){
							$rs2=mysql_fetch_array($sqlN);
								echo $rs2['name'].'<br/>';
						}else{						
							//to select enrol id
							$sqlE=mysql_query("Select
								  *, b.id as enrolid
								From
								  mdl_cifacourse a,
								  mdl_cifaenrol b
								Where
								  a.id = b.courseid And
								  (a.id = '53' And b.status='0' And b.enrol='manual') ");
							$qs=mysql_fetch_array($sqlE);
							$senrolid=$qs['enrolid'];	
							
							//which user able to sit Aptitude test...
							$s_enrol=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE userid='".$USER->id."' AND enrolid='".$senrolid."'");
							$s_count=mysql_num_rows($s_enrol);
							if($s_count!='0'){
								$link=$CFG->wwwroot. '/mod/quiz/view.php?id=114';
								echo 'You have aptitude test, ';
								echo "<a href='".$link."'>Click here to enter..</a><br/>";
							}/*else{
								echo 'No records to display.';
							}*/
						}
						
						//new curiculum/ipd course
						$today=date('d-m-Y H:i:s',strtotime('now'));
						
						$selectnew=mysql_query("SELECT * FROM mdl_cifacourse WHERE visible='1' AND (category!='0' OR category!='3' OR category!='6') ORDER BY id DESC");
						while($serow=mysql_fetch_array($selectnew)){
							$createdate=date('d-m-Y H:i:s',$serow['timecreated']);
							$expireddate=date('d-m-Y H:i:s',strtotime($createdate . " + 1 month"));
							
							$current=strtotime('now');
							$start=strtotime($createdate);
							$ex=strtotime($expireddate);
							
							if($start <= $current && $current <= $ex){
								$sc=mysql_query("SELECT * FROM mdl_cifacourse_categories WHERE id='".$serow['category']."'");
								$rws=mysql_fetch_array($sc);
								$newlink=$CFG->wwwroot.'/image/new_animated.gif';
								echo 'New available: - '.$serow['fullname'].'('.$rws['name'].')'.'&nbsp;<img src="'.$newlink.'" width="23"><br/>';
								//echo '<div style="padding-left:15px;">'.$serow['fullname'].'</div>';
							}
							//echo $expireddate.'<br/> '.$today;
							//echo $createdate.'-'.$current.'-'.$expireddate.'<br/> ';timemodified
						}
						//END new curiculum/ipd course
						
						//news untuk FEEDBACK/SURVEY
						$sqlfeedback=mysql_query("SELECT * FROM mdl_cifafeedback WHERE course='57' ORDER BY id DESC");
						while($feedback=mysql_fetch_array($sqlfeedback)){
							$cdate=date('d-m-Y H:i:s',$feedback['timemodified']);
							$exdate=date('d-m-Y H:i:s',strtotime($cdate . " + 1 month"));
							
							$now=strtotime('now');
							$startsurvey=strtotime($cdate);
							$exfeedback=strtotime($exdate);	
							
							if($startsurvey <= $now && $now <= $exfeedback){	
								$selectmo=mysql_query("SELECT * FROM mdl_cifacourse_modules WHERE visible!='0' AND course='57' AND instance='".$feedback['id']."'");
								$smodule=mysql_fetch_array($selectmo);
								$scount_1=mysql_num_rows($selectmo);
								if($scount_1 >0){
								$newlink=$CFG->wwwroot.'/image/new_animated.gif';
								$linkm=$CFG->wwwroot.'/mod/feedback/view.php?id='.$smodule['id'];
								echo '<a href="'.$linkm.'">'.$feedback['name'].'</a>&nbsp;<img src="'.$newlink.'" width="23"><br/>';								}
							}
						}
						//END news untuk FEEDBACK/SURVEY
					?>
					</td>
				</tr>
			</table>	
			</div>			
			</td>
		</tr></table></td>		
		<tr></table>