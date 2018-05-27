<div id="main-header">
    <div class="container_2">
        <div id="main-logo-sm">
            <a href="#"><img src="<?php echo $PAGE->theme->settings->logo;?>" width="330px"/></a>
        </div><!-- #main-logo-sm -->
        <div id="main-topbar">
            <!-- #main-menu -->
			<div id="main-profile-bar">			
				<?php 
					if (isloggedin()) { 
					$change_pic_link=$CFG->wwwroot.'/user/edit_picture.php?id='.$USER->id.'&course=1';
				?>
				<div class="thumbnail"><?php $linkimg=$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg'; ?>
				<a href="<?=$change_pic_link;?>" title="change picture"><img src="<?=$linkimg;?>" width="55%" alt="<?=$USER->firstname.' '.$USER->lastname;?>" /></a>
				<center><!--a href="<?//=$change_pic_link;?>" title="change picture">Change Picture</a--></center></div><?php } ?>
				<div class="content"><?php if (isloggedin()) { ?>
					<div class="item username"><?=ucwords(strtolower($USER->firstname));?></div>
					<div class="item user-id margin-sm-bottom"><?php /*if($USER->id!='2'){ ?><span class="lbl">ID</span> <?=$USER->traineeid;?><?php }*/ ?></div>
					<div class="item menu">
						<a class="btn theme-button theme-button-white theme-button-uppercase" style="color:#000;" href="<?=$CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('myaccount');?></a>
						<a class="btn theme-button theme-button-white theme-button-uppercase" href="<?=$CFG->wwwroot ."/login/logout.php?sesskey=".sesskey();?>">Logout</a>
					</div><!-- .item --> <?php } ?>
				</div><!-- .content -->
				<div class="clearfix"></div><!-- .clearfix -->
				
				<div id="main-menu" <?php if (!isloggedin()) {?> style="width:100%" <?php } ?>>
					<?php 
					//is loggin
					if (isloggedin()) { 
					if($USER->id != '2'){ //if not administartor
						include 'manualdbconfig.php';
						$sql=mysql_query("SELECT * FROM mdl_cifarole_assignments WHERE contextid='1' AND userid='".$USER->id."'");
						$rs=mysql_fetch_array($sql);						
						$groupuserid=$rs['roleid'];
						if($groupuserid=='13'){ // HR admin?>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><?=get_string('home');?></a>							
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" class="menu-link"><?=get_string('mycourses');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/mod/feedback/view.php?id=207';?>" class="menu-link"><?=get_string('feedback');?></a>
							</li>
							<li class="menu-item">
								<a target="_blank" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" class="menu-link"><?=get_string('cifachat');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/contactus/upload_index.php'; ?>" class="menu-link"><?=get_string('contactus');?></a>
							</li>				
						</ul>
					<?php
						}else{ //Active Candidate
					?>
					<ul class="menu-list">
						<li class="menu-item">
							<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><?=get_string('home');?></a>
						</li>
						<li class="menu-item">
							<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" class="menu-link"><?=get_string('mycourses');?></a>
						</li>
						<li class="menu-item">
							<a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id;?>" class="menu-link"><?=get_string('buyacifa');?></a>
						</li>
						<li class="menu-item">
							<a target="_blank" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" class="menu-link"><?=get_string('cifachat');?></a>
						</li>
						<li class="menu-item">
							<a href="<?php echo $CFG->wwwroot.'/contactus/upload_index.php'; ?>" class="menu-link"><?=get_string('contactus');?></a>
						</li>				
					</ul>
					<?php 
						}}else{ //administartor 
					?>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><?=get_string('home');?></a> 
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>" class="menu-link"><?=get_string('adminmodules');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/examsindex.php?id='.$USER->id;?>" class="menu-link"><?=get_string('adminexams');?></a>
							</li>
							<li class="menu-item">
								<a target="_blank" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" class="menu-link"><?=get_string('cifachat');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/course/view.php?id=57'; ?>" class="menu-link"><?=get_string('feedback');?></a>
							</li>				
						</ul>
					<?php 
						}
					}else{ 
					?>
					<ul class="menu-list">
						<li class="menu-item">
							<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><?=get_string('home');?></a>
						</li>
						<li class="menu-item">
							<a href="<?=$CFG->wwwroot.'/coursesindex.php';?>" class="menu-link"><?=get_string('enrollnow');?></a>
						</li>
					</ul>	
					<?php } ?>
				</div><!-- #main-menu -->						
			</div><!-- #main-profile-bar -->				

        </div><!-- #main-topbar -->
    </div><!-- .container -->
</div><!-- #main-header -->