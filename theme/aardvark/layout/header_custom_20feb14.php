<div id="main-header">
    <div class="container_2">
        <div id="main-logo-sm">
            <a href="#"><!--img src="ui/images/main-logo-sm.png" alt="CIFA"--><img src="<?php echo $PAGE->theme->settings->logo;?>" width="330px"/></a>
        </div><!-- #main-logo-sm -->
        <div id="main-topbar">
            <!--div id="main-menu" <?php //if (!isloggedin()) {?> style="width:100%" <?php //} ?>>
				<?php /*if (isloggedin()) { if($USER->id != '2'){?>
                <ul class="menu-list">
                    <li class="menu-item home">
                        <a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><img src="<?=$CFG->wwwroot.'/ui/images/topbar-btn__home.png';?>"/></a>
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
				<?php }}else{ ?>
                <ul class="menu-list">
                    <li class="menu-item home">
                        <a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><img src="<?=$CFG->wwwroot.'/ui/images/topbar-btn__home.png';?>"/></a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=$CFG->wwwroot.'/coursesindex.php';?>" class="menu-link"><?=get_string('enrollnow');?></a>
                    </li>
                </ul>	
				<?php }*/ ?>
                <div class="clearfix"></div><!-- .clearfix -->
            <!--/div--><!-- #main-menu -->
                        <div id="main-profile-bar">
                            <!--div class="thumbnail" style="background-image: url('../ui/images/sample-profile-pic.png')"-->
							
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
				<?php if (isloggedin()) { if($USER->id != '2'){?>
                <ul class="menu-list">
                    <li class="menu-item home">
                        <a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><img src="<?=$CFG->wwwroot.'/ui/images/topbar-btn__home.png';?>"/></a>
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
				<?php }}else{ ?>
                <ul class="menu-list">
                    <li class="menu-item home">
                        <a href="<?=$CFG->wwwroot.'/index.php'; ?>" class="menu-link"><img src="<?=$CFG->wwwroot.'/ui/images/topbar-btn__home.png';?>"/></a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=$CFG->wwwroot.'/coursesindex.php';?>" class="menu-link"><?=get_string('enrollnow');?></a>
                    </li>
                </ul>	
				<?php } ?>
            </div><!-- #main-menu -->						
                        </div><!-- #main-profile-bar -->				

        </div><!-- #main-topbar -->
        <div class="header-content">
            <div class="row">
                <div class="col-md-5">
                    <div id="main-breadcrumb">
                        <!--ul class="list">
                            <li class="item"><a class="link" href="#">Home</a></li>
                            <li class="item divider">//</li>
                            <li class="item"><a class="link" href="#">Category</a></li>
                            <li class="item divider">//</li>
                            <li class="item"><a class="link" href="#">Current Page Title</a></li>
                        </ul-->
                        <div class="clearfix"></div><!-- .clearfix -->
                    </div><!-- #main-breadcrumb -->
                    <div id="main-page-title"><?php if (isloggedin()) { ?>Become An Expert<?php } ?></div>
                </div><!-- .col-md-5 -->
                <div class="col-md-7">
                    <?php if ($page == 'page') { ?>
                        <div id="main-featured-button">
                            <div class="row">
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-1" href="#">
                                        <span class="lbl">CIFA Explained</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-2" href="#">
                                        <span class="lbl">Enroll</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-3 active" href="#">
                                        <span class="lbl">Why CIFA</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-4" href="#">
                                        <span class="lbl">CIFA Institution</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                            </div><!-- .row -->
                        </div><!-- #main-featured-button -->
                    <?php } /*else { ?>
                        <div id="main-profile-bar">
                            <!--div class="thumbnail" style="background-image: url('../ui/images/sample-profile-pic.png')"-->
							
							<?php 
								if (isloggedin()) { 
								$change_pic_link=$CFG->wwwroot.'/user/edit_picture.php?id='.$USER->id.'&course=1';
							?>
							<div class="thumbnail"><?php $linkimg=$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg'; ?>
							<a href="<?=$change_pic_link;?>" title="change picture"><img src="<?=$linkimg;?>" width="55%" alt="<?=$USER->firstname.' '.$USER->lastname;?>" /></a>
							<center><!--a href="<?//=$change_pic_link;?>" title="change picture">Change Picture</a--></center></div><?php } ?>
                            <div class="content"><?php if (isloggedin()) { ?>
                                <div class="item username"><?=$USER->firstname.' '.$USER->lastname;?></div>
                                <div class="item user-id margin-sm-bottom"><?php /*if($USER->id!='2'){ ?><span class="lbl">ID</span> <?=$USER->traineeid;?><?php }*//* ?></div>
                                <div class="item menu">
                                    <a class="btn theme-button theme-button-white theme-button-uppercase" href="<?=$CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>"><?=get_string('myaccount');?></a>
                                    <a class="btn theme-button theme-button-white theme-button-uppercase" href="<?=$CFG->wwwroot ."/login/logout.php?sesskey=".sesskey();?>">Logout</a>
                                </div><!-- .item --> <?php } ?>
                            </div><!-- .content -->
                            <div class="clearfix"></div><!-- .clearfix -->
                        </div><!-- #main-profile-bar -->
                    <?php }*/ ?>
                    <div class="clearfix"></div><!-- .clearfix -->
                </div><!-- .col-md-8 -->
            </div><!-- .row -->
        </div><!-- .header-content -->
    </div><!-- .container -->
</div><!-- #main-header -->