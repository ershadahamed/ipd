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
	width:100%;
}
.titlebox-noticeboard{
	text-shadow: 1px 1px 2px #000; 
	/*background-color:#E8E8E8; */
	width: 260px; 
	height: 10px; 
	vertical-align: middle;
	padding:5px;
	/*background:url('image/btbg.png') repeat-x;
	color:#fff;*/
	color:#000;
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
	color:#000;
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
	border-top-left-radius: 8px 8px;
	border-top-right-radius: 8px 8px;
}
#board-div{
	border: 1px solid #3D91CB; 	
	border-top-left-radius: 10px 10px;
	border-top-right-radius: 10px 10px;
	border-bottom-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 90px;
	height:160px;
	background-color:#fff; 
	background:url('theme/base/pix/noticeBOARD.png') repeat-x;		
}
#board-div3{
	border: 1px solid #3D91CB; 	
	border-top-left-radius: 10px 10px;
	border-top-right-radius: 10px 10px;
	border-bottom-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 460px;
	/*height:160px;*/
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
#board-div-noticeboard{
	border: 3px solid #3D91CB; 	
	border-radius: 8px 8px 8px 8px;
	margin:0;
	padding: 4px 0px 0px 10px;
	min-height: 25px;
	background-color:#fff; 
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
#boardblock-div2{
	border: 1px solid #3D91CB; 	
	border-top-left-radius: 10px 10px;
	border-top-right-radius: 10px 10px;
	border-bottom-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 90px;
	height:198px;
	background-color:#fff; 
	background:url('theme/base/pix/noticeBOARD.png') repeat-x;	
}
#mynoticeboard{
	width:100%; 
	/*border: 2px solid #3D91CB;*/
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
a:link {color:#3D91CB; text-decoration: none;}      /* unvisited link */
a:visited {color:#3D91CB;}  /* visited link */
a:hover {color:#ab381b;}  /* mouse over link */
a:active {color:#3D91CB;}  /* selected link */

</style>
		<!-------box for noticeboard----------->
		<table border="0" cellpadding="0" cellspacing="0">
		<tr valign="top"><td style="width:40%">	
		
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td colspan="4">
			<div id="board-div-noticeboard" class="titlebox-noticeboard">Noticeboard</div>
			<div id="board-div3">
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
								echo $rsN['name'].'<br/>';
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
								echo 'New available: - '.ucwords(strtolower($rws['name'])).'&nbsp;<img src="'.$newlink.'" width="23"><br/>';
							}
							//echo $expireddate.'<br/> '.$today;
						}
					?>
					</td>
				</tr>
			</table>	
			</div>			
			</td>
		</tr></table></td><td style="width:60%">
		<?php
		/***********add by arizan 22/02/2012**************************************************/
		$queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
			foreach($queryrole as $qrole){ }
		/************************************************************/	
		?>
		<!-----Hot menu----->
		<?php 
			if($qrole->roleid!='9' && $qrole->roleid!='14'){ 		
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
					<?php if(($qrole->roleid) != '10' && $qrole->roleid != '9' && $qrole->roleid != '13'){ //active candidates?>
					<?php
						//sql to count module on CIFAONLINE
						$statement="mdl_cifacourse a, mdl_cifaenrol b, mdl_cifauser_enrolments c, mdl_cifauser d";
						$statement.=" WHERE a.id = b.courseid And b.id = c.enrolid And c.userid = d.id And (a.category = '1' And c.userid = '".$USER->id."' And a.visible = '1')";
						$sql=mysql_query("SELECT * FROM {$statement}");
						$qcount=mysql_num_rows($sql);		
					?>
					<table width="100%" border="0">
					<tr align="center" valign="top">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?=get_string('personaldetails');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('personaldetails');?>">
						<br/><?=get_string('personaldetails');?></a></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/changepwd.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('changepassword');?>">
							<br/><?=get_string('changepassword');?></a></div></td>
						<!---mock test -->	
						<!---if user already enrol 10 module -->
						<?php if($qcount>='10'){ ?>
						<?php 
							$statement_enrol="mdl_cifaenrol WHERE status='0' AND courseid='54'";
							$sqlenrol=mysql_query("SELECT id FROM {$statement_enrol}");
							$qenrol=mysql_fetch_array($sqlenrol);
							
							//enrol user to mdl_cifauser_enrolments
							$today = strtotime('now');
							$enrolid=$qenrol['id'];
							$userid=$USER->id;
							$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
													SET enrolid='".$enrolid."', userid='".$userid."',
													timecreated='".$today."', timemodified='".$today."',
													modifierid='2', emailsent='1' WHERE (userid!='".$userid."' AND enrolid='".$enrolid."')");														
						?>
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/course/view.php?id=54';?>" title="<?=get_string('mocktest');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/mock_test.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('mocktest');?>">
						<br/><?=get_string('mocktest');?></a></div></td><?php } ?>							
						<!---end mock test -->	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/modules.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('mytrainingprogram');?>">
						<br/><?=get_string('mytrainingprogram');?></a></div></td>
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/full-shopping-cart-icon.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('purchaseprogram');?>">
						<br/><?=get_string('purchaseprogram');?></a></div></td>
						<td><div style="padding:3px;">
							<img src="<?php echo $CFG->wwwroot.'/image/financial.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('financialstatement');?>">
						<br/><?=get_string('financialstatement');?></div></td>							
						<td><div style="padding:3px;">
							<img src="<?php echo $CFG->wwwroot.'/image/people_online.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('feedback');?>">
						<br/><?=get_string('feedback');?></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank" title="<?=get_string('cifachat');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/chat-icon.png?id='.$USER->id;?>" width="<?=$iconwidth;?>" border="0" title="<?=get_string('cifachat');?>">
						<br/><?=get_string('cifachat');?></a></div></td>							
					</tr></table>
					<?php } ?>                                          
                                            
					<?php if(($qrole->roleid) == '10'){ // exam centre admin?>	
					<table width="100%" border="0">
					<tr align="center" valign="top">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('personaldetails');?>">
						<br/><?=get_string('personaldetails');?></a></div></td>
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/manage_exam_index.php?id='.$USER->id; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/office-building-icon.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('examcentre');?>">
							<br/><?=get_string('examcentre');?></a></div></td>	
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
					
					<?php if(($qrole->roleid) == '13'){ // Institutional Client?>
					<table border="0">
					<tr align="center">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="<?=get_string('personaldetails');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="40" border="0" title="<?=get_string('personaldetails');?>">
						<br/><?=get_string('personaldetails');?></a></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="<?=get_string('changepassword');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/changepwd.png?id='.$USER->id;?>" width="43" border="0" title="<?=get_string('changepassword');?>">
							<br/><?=get_string('changepassword');?></a></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
							<img src="<?php echo $CFG->wwwroot.'/image/modules.png?id='.$USER->id;?>" width="43" border="0" title="<?=get_string('mytrainingprogram');?>">
						<br/><?=get_string('mytrainingprogram');?></a></div></td>							
					</tr></table>
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
								<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newcourse');?></li>
							<?php }else{ ?>	
								<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newcurriculum');?></li>
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
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
							<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">&nbsp;Employment&Educational Background</li>			
					</ul>		
				</td>
				</tr>
			</table>
			</div>
		</td>		
		<?php } ?>
		
		<?php if($qrole->roleid != '9' && $qrole->roleid != '13' && $qrole->roleid!='14'){ //active candidates ?>
		<tr>
			<td style="padding-right:5px; width: 50%;">
			<?php if($qrole->roleid!= '10' && $qrole->roleid != '9' && $qrole->roleid != '12' && $qrole->roleid != '13'){  ?>
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mydetails');?></div><?php }else{ ?>
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mydetails');?></div><?php } ?>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr valign="top">	
					<td>
						<?php if($qrole->roleid!= '10' && $qrole->roleid != '9'){ //active candidates ?>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
								<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
								<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>"><?=get_string('changepassword');?></a></li>	
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
								<!--a href="<?php //echo $CFG->wwwroot.'#'; ?>"--><?=get_string('enrolmentconfirmation');?><!--/a--></li>	
						</ul>
						<?php }?>
						
						<?php /*if(($qrole->roleid) == '9'){ //Inactive candidates ?>
						<ul class="list">
							<!---------available on inactive candidates--------->
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
								<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">&nbsp;Employment&Educational Background</li>			
						</ul>	
						<?php }*/ ?>	

						<!---------available for exam centre admin--------->
						<?php if(($qrole->roleid) == '10'){ ?>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
							<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
							<a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>"><?=get_string('changepassword');?></a></li>								
						</ul>
						<?php }?>						
					</td>
				</tr>
			</table>
			</div>
		</td>
		<?php } ?>
		
		
		<?php if($qrole->roleid!= '10' && $qrole->roleid != '9' && $qrole->roleid != '12' && $qrole->roleid != '13' && $qrole->roleid!='14'){ //active candidates ?>
		<!--My training-->
		<td style="padding-right:5px;width: 50%;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mytraining');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<!--tr><td class="titlebox"><?//=get_string('mytraining');?></td></tr-->
				<tr valign="top">
				<td>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
							<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>"> <?=get_string('mytrainingprogram');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('onlineportal');?></li>
							
							<?php /*SHAPE IPD*/ if($cIPD!='0'){ ?>
								<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newcourse');?></li>
								<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
								<a href="<?=$CFG->wwwroot. '/userfrontpage/viewuserresult.php?id='.$USER->id;?>" title="<?=get_string('testresults');?>">
								<?=get_string('testresults');?></a></li>
							<?php }else{ ?>
							
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newcurriculum');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('examstatement');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
							<a href="<?=$CFG->wwwroot. '/userfrontpage/viewuserresult.php?id='.$USER->id;?>" title="<?=get_string('examresultcifa');?>">
							<?=get_string('examresultcifa');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('examregulation');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('examguide');?></li>
							<?php } ?>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
							<a href="<?=$CFG->wwwroot .'/pluginfile.php/132/block_html/content/SHAPE%20Online%20Training%20Program%20User%20policy.pdf';?>" target="_blank">
							<?=get_string('cifaonlinepolicy');?></a></li>
						</ul>
				</td>
				</tr>
			</table>
			</div>
		</td>	</tr>
		
		<!--My Financial-->
        <tr><td style="padding-right:5px;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('myfinancial');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<!--tr><td class="titlebox"><?//=get_string('myfinancial');?></td></tr-->
				<tr valign="top">
				<td>
					<ul class="list">
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">&nbsp;<?=get_string('financialstatement');?></li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
						<a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>"><?=get_string('purchaseprogram');?></a></li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">&nbsp;Continue My Purchase </li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">&nbsp;Pay now </li>						
					</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>		
		
		<!--My Community-->
		<td style="padding-right:5px;">
			<div id="boardblock-div"><div id="board-div-title" class="titlebox"><?=get_string('mycommunity');?></div>
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<!--tr><td class="titlebox"><?//=get_string('mycommunity');?></td></tr-->
				<tr valign="top">
				<td>
						<ul class="list">
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
								<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" target="_blank"><?=get_string('cifachat');?></a></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('cifablog');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('ifforums');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('youtube');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('socialnetwork');?></li>
							<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('feedbackreview');?></li>							
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
				<!--tr><td class="titlebox"><?//=get_string('myfinancial');?></td></tr-->
				<tr valign="top">
				<td>
					<ul class="list">
						<li><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="<?=get_string('purchaseprogram');?>">
						<img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('reactivemembership');?></a> </li>
						<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('paynow');?> </li>
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
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/userfrontpage/mytrainingprogram.php?='.$USER->id;?>" title="<?=get_string('mytrainingprogram');?>">
					<?=get_string('mytrainingprogram');?></a> </li>				
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">					
					<?=get_string('newcurriculum');?> / course
					</li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
					<a href="<?=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;?>" title="<?=get_string('candidateprogress');?>">
					<?=get_string('candidateprogress');?></a> </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
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
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('scheduledreport');?></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newreport');?></li>
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
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('onlineportalguide');?></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
				<a href="<?=$CFG->wwwroot.'/userfrontpage/resetpassword.php';?>" title="<?=get_string('resetpassword');?>">
				<?=get_string('resetpassword');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
				<a href="<?=$CFG->wwwroot.'/userfrontpage/updatecandidate_details.php';?>" title="<?=get_string('updatecandidateinfo');?>">
				<?=get_string('updatecandidateinfo');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('cifaexamportal');?></li>
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
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
					<a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('personaldetails');?></a></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15">
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
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('mytrainingprogram');?> </li>					
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> Online Portal navigation guide</li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newcurriculum');?> / course </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> Candidate progress </li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> Exam / test results </li>
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
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('scheduledreport');?></li>
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newreport');?></li>
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
		<td>Linked to CIFAOnline website except (*)</td></tr>
		<tr valign="top">
		<td>
				<ul class="list">
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
						<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" target="_blank"><?=get_string('cifachat');?> * </a></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('cifablog');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('ifforums');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('youtube');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('socialnetwork');?></li>
					<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('feedbackreview');?> *</li>								
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
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> 
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
				<li><img src="<?php echo $CFG->wwwroot. '/image/system.png';?>" width="15"> <?=get_string('newcurriculum');?></li>						
			</ul>
		</td>
		</tr>
	</table>
	</div>
</td>
<?php } ?>
		
		</tr>
		</table><br/><?php //} ?><td><tr></table>