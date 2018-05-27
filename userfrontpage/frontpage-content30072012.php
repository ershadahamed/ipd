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
.titlebox{
	text-shadow: 1px 1px 2px #000; 
	background-color:#E8E8E8; 
	width: 260px; 
	height: 10px; 
	vertical-align: middle;
	padding:5px;
	background:url('image/btbg.png') repeat-x;
	color:#fff;
	font-weight: bolder;
	border-top-left-radius: 8px 8px;
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
}
#board-div{
	border: 1px solid #3D91CB; 	
	border-top-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 90px;
	height:160px;
}
#boardblock-div{
	border: 1px solid #3D91CB; 	
	border-top-left-radius: 10px 10px;
	border-bottom-right-radius: 10px 10px;
	margin:0;
	padding:0;
	min-height: 90px;
	height:120px;
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
}

.list{
	list-style: none; 
	padding: 2px; margin: 0;
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
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td colspan="4">
			<div id="board-div">
			<table border="0" id="mynoticeboard" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">Noticeboard</td></tr>
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
							
							//which user able to sit...
							$s_enrol=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE userid='".$USER->id."' AND enrolid='".$senrolid."'");
							$s_count=mysql_num_rows($s_enrol);
							if($s_count!='0'){
								$link=$CFG->wwwroot. '/mod/quiz/view.php?id=114';
								echo 'You have aptitude test, ';
								echo "<a href='".$link."'>Click here to enter..</a>";
							}else{
								echo 'No records to display.';
							}
						}
					?>
					</td>
				</tr>
			</table>	
			</div>			
			</td>
		</tr></table>
		<?php
		/***********add by arizan 22/02/2012**************************************************/
		$queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
			foreach($queryrole as $qrole){ }
		/************************************************************/	
		?>
		<!-----Hot menu----->
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="4">
			<div id="board-div">
			<table border="0" id="mynoticeboard" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">Hot menu</td></tr>
				<tr valign="top">
					<td class="hotmenu-content">  
					<?php if(($qrole->roleid) != '10' && $qrole->roleid != '9'){ //active candidates?>
					<?php
						//sql to count module on CIFAONLINE
						$statement="mdl_cifacourse a, mdl_cifaenrol b, mdl_cifauser_enrolments c, mdl_cifauser d";
						$statement.=" WHERE a.id = b.courseid And b.id = c.enrolid And c.userid = d.id And (a.category = '1' And c.userid = '".$USER->id."' And a.visible = '1')";
						$sql=mysql_query("SELECT * FROM {$statement}");
						$qcount=mysql_num_rows($sql);		
					?>
					<table width="100%" border="0">
					<tr align="center" valign="top">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="Personal detail">
							<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="60" border="0" title="Personal detail">
						<br/>Personal detail</a></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>" title="Change password">
							<img src="<?php echo $CFG->wwwroot.'/image/changepwd.png?id='.$USER->id;?>" width="60" border="0" title="Change password">
							<br/>Change password</a></div></td>
						<!---mock test -->	
						<!---if user already enrol 10 module -->
						<?php if($qcount>='10'){ ?>
						<?php 
							$statement_enrol="{$CFG->prefix}enrol WHERE status='0' AND courseid='54'";
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
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/course/view.php?id=54';?>" title="Mock test">
							<img src="<?php echo $CFG->wwwroot.'/image/mock_test.png?id='.$USER->id;?>" width="60" border="0" title="Mock test">
						<br/>Mock test</a></div></td><?php } ?>							
						<!---end mock test -->	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" title="My modules">
							<img src="<?php echo $CFG->wwwroot.'/image/modules.png?id='.$USER->id;?>" width="60" border="0" title="My modules">
						<br/>My modules</a></div></td>
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>" title="Purchase a curriculum">
							<img src="<?php echo $CFG->wwwroot.'/image/full-shopping-cart-icon.png?id='.$USER->id;?>" width="60" border="0" title="Purchase module">
						<br/>Purchase a curriculum</a></div></td>
						<td><div style="padding:3px;"><a href="<?php //echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="Financial statement">
							<img src="<?php echo $CFG->wwwroot.'/image/financial.png?id='.$USER->id;?>" width="60" border="0" title="Financial statement">
						<br/>Financial statement</a></div></td>							
						<td><div style="padding:3px;"><a href="<?php //echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>" title="Online survey">
							<img src="<?php echo $CFG->wwwroot.'/image/people_online.png?id='.$USER->id;?>" width="60" border="0" title="Online survey">
						<br/>Feedback</a></div></td>	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank" title="Communication preference">
							<img src="<?php echo $CFG->wwwroot.'/image/chat-icon.png?id='.$USER->id;?>" width="60" border="0" title="Communication preference">
						<br/>CIFA chat</a></div></td>							
					</tr></table>
					<?php } ?>
                                            
                                            
                                        <!-- Inactive Candidate/trainee -->    
					<?php if($qrole->roleid == '9'){ //Inactive candidates ?>
					<table width="100%" border="0">
					<tr align="center" valign="top">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="60" border="0" title="Personal detail">
						<br/>Personal detail</a></div></td>
						<td><div style="padding:3px;"><a href="<?php //echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/financial.png?id='.$USER->id;?>" width="60" border="0" title="Financial statement">
						<br/>Financial statement</a></div></td>
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank">
							<img src="<?php echo $CFG->wwwroot.'/image/chat-icon.png?id='.$USER->id;?>" width="60" border="0" title="Communication preference">
						<br/>CIFA chat</a></div></td>							
					</tr></table>
					<?php } ?>                                            
                                            
					<?php if(($qrole->roleid) == '10'){ // exam centre admin?>	
					<table width="100%" border="0">
					<tr align="center" valign="top">
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/users.png?id='.$USER->id;?>" width="60" border="0" title="Personal detail">
						<br/>Personal detail</a></div></td>
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/manage_exam_index.php?id='.$USER->id; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/office-building-icon.png?id='.$USER->id;?>" width="60" border="0" title="Manage exam centre">
							<br/>Exam centre</a></div></td>
						<!--td><div style="padding:3px;"><a href="<?php //echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>">
							<img src="<?php //echo $CFG->wwwroot.'/image/full-shopping-cart-icon.png?id='.$USER->id;?>" width="60" border="0" title="Purchase module">
							<br/>Purchase a module</a></div></td-->	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/offlineexam/examregistration_home.php?id='.$USER->id; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/manage-registrations.png?id='.$USER->id;?>" width="60" border="0" title="Manage exam registration">
							<br/>Manage exam registration</a></div></td>								
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/course/view.php?id=12'; ?>">
							<img src="<?php echo $CFG->wwwroot.'/image/User-Group-icon-upload.png?id='.$USER->id;?>" width="60" border="0" title="Download exam software">
							<br/>Download exam software</a></div></td>								
						<!--td><div style="padding:3px;"><a href="<?php //echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
							<img src="<?php //echo $CFG->wwwroot.'/image/financial.png?id='.$USER->id;?>" width="60" border="0" title="Financial statement">
						<br/>Financial statement</a></div></td-->	
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/upload_software.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/upload-examanswer.png?id='.$USER->id;?>" width="60" border="0" title="Upload exam answer software">
						<br/>Upload exam answer software</a></div></td>							
						<td><div style="padding:3px;"><a href="<?php //echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
							<img src="<?php echo $CFG->wwwroot.'/image/Invoice-icon.png?id='.$USER->id;?>" width="60" border="0" title="Manage payment records">
						<br/>Manage payment records</a></div></td>							
						<td><div style="padding:3px;"><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank">
							<img src="<?php echo $CFG->wwwroot.'/image/chat-icon.png?id='.$USER->id;?>" width="60" border="0" title="Communication preference">
						<br/>CIFA chat</a></div></td>							
					</tr></table>					
					<?php } ?>
					</td>
				</tr>
			</table>	
			</div>			
			</td>
		</tr></table>
		
		<!----box for menu---->
                <?php if(($qrole->roleid) != '10'){ ?>
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td style="padding-right:5px;">
			<div id="boardblock-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My details</td></tr>
				<tr valign="top">	
					<td>
						<?php if($qrole->roleid!= '10' && $qrole->roleid != '9'){ //active candidates ?>
						<ul class="list">
							<li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Personal detail</a></li>
							<li><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>">Change password</a></li>
							<li><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>">CIFA chat</a></li>	
						</ul>
						<?php }?>
						
						<?php if(($qrole->roleid) == '9'){ //Inactive candidates ?>
						<ul class="list">
							<!---------available on inactive candidates--------->
							<li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Personal detail</a></li>
							<li><a href="<?php //echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id='.$USER->id; ?>">Re-register as CIFA Candidate (for inactive candidate ONLY)  </a></li>
						</ul>	
						<?php } ?>	

						<!---------available for exam centre admin--------->
						<?php //if(($qrole->roleid) == '10'){ ?>
						<!--ul class="list">
							<li><a href="<?php// echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Personal detail</a></li>
							<li><a href="<?php //echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>">Change password</a></li>	
						</ul-->
						<?php// }?>						
					</td>
				</tr>
			</table>
			</div>
		</td>
		<?php if($qrole->roleid!= '10' && $qrole->roleid != '9'){ //active candidates ?>
		<td style="padding-right:5px;">
			<div id="boardblock-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My studies</td></tr>
				<tr valign="top">
				<td>
						<ul class="list">
							<li><a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>">My modules</a></li>
							<li><a href="">Module record/result</a></li>
							<li><a href="">Continue my studies</a></li>
							<li><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>">Purchase a curriculum</a></li>
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>	
		<?php } ?>
                
                <?php if(($qrole->roleid) == '9'){ //Inactive candidates ?>
                <td style="padding-right:5px;">
			<div id="boardblock-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My Financial</td></tr>
				<tr valign="top">
				<td>
                                    <ul class="list">
                                        <li><a href="<?php //echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>">Financial statement </a></li>
                                    </ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>
                <?php } ?>
                
		<!---------my students- available on intitutional client--------->
		<td style="padding-right:5px; display:none;">
			<div id="boardblock-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My students</td></tr>
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
		</tr>
		</table><br/><?php } ?>