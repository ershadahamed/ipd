<div id="main-header">
    <div class="container_2">
        <div id="main-topbar">
				<div id="main-menu" <?php if (!isloggedin()) {?> style="width:100%;" <?php } ?>>
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
							<li class="menu-item home">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><i><img class="glyphicon" style="width:23px;" src="<?=$CFG->wwwroot;?>/theme/aardvark/pix/glyphicons.png"></i></a>
								<!--a href="<?//=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><i class="glyphicon glyphicon-home"></i></a-->
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/examcenter/myreport.php?id='.$USER->id;?>" class="menu-link"><?=get_string('myadmin');?></a>
							</li>
							<li class="menu-item">
								<a target="_blank" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" class="menu-link"><?=get_string('cifachat');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/contactus/upload_index.php'; ?>" class="menu-link"><?=get_string('contactus');?></a>
							</li>				
						</ul>
                    <?php }else if($groupuserid=='12'){ // Business Partner ?> 
						<ul class="menu-list">
							<li class="menu-item home">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><i><img class="glyphicon" style="width:23px;" src="<?=$CFG->wwwroot;?>/theme/aardvark/pix/glyphicons.png"></i></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/candidatemanagement/cifacandidatemanagement.php?id='.$USER->id;?>" class="menu-link"><?=get_string('mycandidate');?></a>
							</li>
							<li class="menu-item">
								<a target="_blank" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" class="menu-link"><?=get_string('cifachat');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/contactus/upload_index.php'; ?>" class="menu-link"><?=get_string('contactus');?></a>
							</li>				
						</ul>                       
					<?php }else if($groupuserid=='10'){ // exam center ?>
						<ul class="menu-list">
							<li class="menu-item home">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><i><img class="glyphicon" style="width:23px;" src="<?=$CFG->wwwroot;?>/theme/aardvark/pix/glyphicons.png"></i></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/offlineexam/multi_token_download.php?id='.$USER->id;?>" class="menu-link"><?=get_string('myexamcenter');?></a>
							</li>
							<!--li class="menu-item">
								<a href="<?php //echo $CFG->wwwroot.'/mod/feedback/view.php?id=207';?>" class="menu-link"><?//=get_string('feedback');?></a>
							</li-->
							<li class="menu-item">
								<a target="_blank" href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4'; ?>" class="menu-link"><?=get_string('cifachat');?></a>
							</li>
							<li class="menu-item">
								<a href="<?php echo $CFG->wwwroot.'/contactus/upload_index.php'; ?>" class="menu-link"><?=get_string('contactus');?></a>
							</li>				
						</ul>						
						
					<?php	}else{ //Active Candidate
					?>
					<ul class="menu-list">
						<li class="menu-item">
							<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><i><img class="glyphicon" style="width:23px;" src="<?=$CFG->wwwroot;?>/theme/aardvark/pix/glyphicons.png"></i></a>
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
							<li class="menu-item home">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><img class="glyphicon" style="width:23px;" src="<?=$CFG->wwwroot;?>/theme/aardvark/pix/glyphicons.png"></a>
							</li>
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
					}else{  // Jika tak loggin // not loggin user here //
					?>
					<ul class="menu-list">
						<li class="menu-item home">
								<a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><img class="glyphicon" style="width:23px;" src="<?=$CFG->wwwroot;?>/theme/aardvark/pix/glyphicons.png"></a>
						</li>
						<li class="menu-item">
							<a href="<?=$CFG->wwwroot.'/coursesindex.php';?>" class="menu-link"><?=get_string('enrollnow');?></a>
						</li>
					</ul>
					<?php } ?>
				</div><!-- #main-menu -->
            <div class="clearfix"></div><!-- .clearfix -->
        </div><!-- #main-topbar -->
        
        
        <div class="header-content">
        <div id="main-logo-sm">
            <a href="#"><img src="<?php echo $PAGE->theme->settings->logo;?>" width="158px"/></a>
        </div><!-- #main-logo-sm -->		
            <div class="row">
                <div class="col-md-5"></div><!-- .col-md-5 -->
                <div class="col-md-7">
                <div id="main-profile-bar">
				<?php 
					if (isloggedin()) { 
					$change_pic_link=$CFG->wwwroot.'/user/edit_picture.php?id='.$USER->id.'&course=1';
				?>
				<div class="thumbnail">
				<?php 
					if($USER->picture=='0'){
						$linkimg=$CFG->wwwroot.'/image/f1.png'; ?>
						<a href="<?=$change_pic_link;?>" title="change picture"><img src="<?=$linkimg;?>" width="90px" alt="<?=$USER->firstname.' '.$USER->lastname;?>" /></a>
                <?php
					}else{ 
						$linkimg=$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg'; ?>
						<a href="<?=$change_pic_link;?>" title="change picture"><img src="<?=$linkimg;?>" width="90px" alt="<?=$USER->firstname.' '.$USER->lastname;?>" /></a>
				<?php } ?>
				</div><?php } ?>
				<div class="content" style="float:right;"><?php if (isloggedin()) { ?>
					<div class="item username"><?=ucwords(strtolower($USER->firstname));?></div>
					<div class="item user-id margin-sm-bottom"></div>
					<div class="item menu">
						<a class="theme-button" style="color:#FFFFFF;" href="<?=$CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('myaccount');?></a>
						<a class="theme-button" style="color:#FFFFFF;" href="<?=$CFG->wwwroot ."/login/logout.php?sesskey=".sesskey();?>">Logout</a>
					</div><!-- .item --> <?php } ?>
				</div><!-- .content -->
				<div class="clearfix"></div><!-- .clearfix -->
                        </div><!-- #main-profile-bar -->
                    <div class="clearfix"></div><!-- .clearfix -->
                </div><!-- .col-md-8 -->
            </div><!-- .row -->
        </div><!-- .header-content -->
    </div><!-- .container -->
</div><!-- #main-header -->