<?php
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

splash_check_colourswitch();
splash_initialise_colourswitcher($PAGE);

$bodyclasses = array();
$bodyclasses[] = 'splash-'.splash_get_colour();
if ($hassidepre && !$hassidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($hassidepost && !$hassidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$hassidepost && !$hassidepre) {
    $bodyclasses[] = 'content-only';
}

$haslogo = (!empty($PAGE->theme->settings->logo));
$hasfootnote = (!empty($PAGE->theme->settings->footnote));
$hidetagline = (!empty($PAGE->theme->settings->hide_tagline) && $PAGE->theme->settings->hide_tagline == 1);

if (!empty($PAGE->theme->settings->tagline)) {
    $tagline = $PAGE->theme->settings->tagline;
} else {
    $tagline = get_string('defaulttagline', 'theme_splash');
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
    <?php echo $OUTPUT->standard_top_of_body_html() ?>
    <div id="page" style="width:90%;">
        <?php if ($hasheading || $hasnavbar) { ?>
        <div id="page-header">
            <div id="page-header-wrapper" class="wrapper clearfix">
                <?php if ($hasheading) { ?>
                <div id="headermenu">
                    <?php if (isloggedin()) { $ufirstname=ucwords(strtolower($USER->firstname));
                        echo html_writer::start_tag('div', array('id'=>'userdetails'));
                        echo html_writer::tag('h1', get_string('usergreeting', 'theme_splash', $ufirstname));
                        echo html_writer::start_tag('p', array('class'=>'prolog'));
                        echo html_writer::link(new moodle_url('/user/profile.php', array('id'=>$USER->id)), get_string('myaccount')).' | ';
                        echo html_writer::link(new moodle_url('/login/logout.php', array('sesskey'=>sesskey())), get_string('logout'));
                        echo html_writer::end_tag('p');
                        echo html_writer::end_tag('div');
                        echo html_writer::tag('div', $OUTPUT->user_picture($USER, array('size'=>55)), array('class'=>'userimg'));
                    } else {
                        echo html_writer::start_tag('div', array('id'=>'userdetails_loggedout'));
                        $loginlink = html_writer::link(new moodle_url('/login/'), get_string('loginhere', 'theme_splash'));
                        echo html_writer::tag('h1', get_string('welcome', 'theme_splash', $loginlink));
                        echo html_writer::end_tag('div');;
                    } ?>
                    <div class="clearer"></div>
                    <!-- <div id="colourswitcher">
                        <ul>
                            <li><img src="<?php //echo $OUTPUT->pix_url('colour', 'theme'); ?>" alt="colour" /></li>
                            <li><a href="<?php //echo new moodle_url($PAGE->url, array('splashcolour'=>'blue')); ?>" class="styleswitch colour-blue"><img src="<?php //echo $OUTPUT->pix_url('blue-theme2', 'theme'); ?>" alt="blue" /></a></li>
                            <li><a href="<?php// echo new moodle_url($PAGE->url, array('splashcolour'=>'green')); ?>" class="styleswitch colour-green"><img src="<?php //echo $OUTPUT->pix_url('green-theme2', 'theme'); ?>" alt="green" /></a></li>
							<li><a href="<?php //echo new moodle_url($PAGE->url, array('splashcolour'=>'red')); ?>" class="styleswitch colour-red"><img src="<?php //echo $OUTPUT->pix_url('red-theme2', 'theme'); ?>" alt="red" /></a></li>
                            <li><a href="<?php //echo new moodle_url($PAGE->url, array('splashcolour'=>'orange')); ?>" class="styleswitch colour-orange"><img src="<?php //echo $OUTPUT->pix_url('orange-theme2', 'theme'); ?>" alt="orange" /></a></li>
                        </ul>
                    </div> -->
                    <?php echo $OUTPUT->lang_menu();?>
                </div>
                <div id="logobox">
                    <?php if ($haslogo) {
                        echo html_writer::link(new moodle_url('/'), "<img src='".$PAGE->theme->settings->logo."' alt='logo' />");
                    } else {
                        echo html_writer::link(new moodle_url('/'), $PAGE->heading, array('class'=>'nologoimage'));
                    } ?>
                    <?php if (!$hidetagline) { ?>
                        <h4><?php echo $tagline ?></h4>
                    <?php } ?>
                </div>
                <div class="clearer"></div>
                <?php if ($haslogo) { ?>
                <!--h4 class="headermain inside">&nbsp;</h4-->
                <?php } else { ?>
                <h4 class="headermain inside"><?php echo $PAGE->heading ?></h4>
                <?php } ?>
            <?php } // End of if ($hasheading)?>
                <!-- DROP DOWN MENU -->
                <div class="clearer"></div>
                <div id="dropdownmenu" style="margin-top:1em;">
                    <?php if ($hascustommenu) { ?>
                    <div id="custommenu">
					<?php if (isloggedin()) { ?>
						<?php 
							include 'manualdbconfig.php';
							$sql=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE userid='".$USER->id."'");
							$rs=mysql_fetch_array($sql);
							//echo $rs['roleid'];
							if($USER->id != '2'){
								$groupuserid=$rs['roleid'];
								if($groupuserid=='13'){
									//echo $custommenu;
									echo html_writer::start_tag('div', array('style'=>'float: right;'));
									echo html_writer::start_tag('div', array('id'=>'custom_menu_1', 'role'=>'menu', 'class'=>'yui3-menu yui3-menu-horizontal javascript-disabled'));
									echo html_writer::start_tag('div', array('class'=>'yui3-menu-content', 'role'=>'presentation'));
									echo html_writer::start_tag('ul', array('class'=>'first-of-type', 'role'=>'presentation'));
									echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;','class'=>'yui3-menuitem', 'role'=>'presentation'));
									echo html_writer::link(new moodle_url('/index.php', array('id'=>$USER->id)), get_string('home'));
									echo html_writer::end_tag('li');
									echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
									echo html_writer::link(new moodle_url('/user/profile.php', array('id'=>$USER->id)), get_string('myprofile'));
									echo html_writer::end_tag('li');									
									echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
									echo html_writer::link(new moodle_url('/coursesindex.php', array('id'=>$USER->id)), get_string('mytrainingprogram'));
									echo html_writer::end_tag('li');									
									echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
									echo html_writer::link(new moodle_url('/mod/chat/gui_ajax/index.php', array('id'=>'4')), get_string('cifachat'));
									echo html_writer::end_tag('li');
									echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
									echo html_writer::link(new moodle_url('/login/logout.php', array('sesskey'=>sesskey())), get_string('logout'));
									echo html_writer::end_tag('li');
									echo html_writer::end_tag('ul');
									echo html_writer::end_tag('div');
									echo html_writer::end_tag('div');	
									echo html_writer::end_tag('div');
								}else{
									echo html_writer::start_tag('div', array('style'=>'float: right;'));
									echo $custommenu;
									echo html_writer::end_tag('div');
								}						
							}else{ 
						?>
						
						<?php 
							echo html_writer::start_tag('div', array('style'=>'float: right;'));
							echo html_writer::start_tag('div', array('id'=>'custom_menu_1', 'role'=>'menu', 'class'=>'yui3-menu yui3-menu-horizontal javascript-disabled'));
							echo html_writer::start_tag('div', array('class'=>'yui3-menu-content', 'role'=>'presentation'));
							echo html_writer::start_tag('ul', array('class'=>'first-of-type', 'role'=>'presentation'));
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;','class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/index.php', array('id'=>$USER->id)), get_string('home'));
							echo html_writer::end_tag('li');
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/coursesindex.php', array('id'=>$USER->id)), get_string('adminmodules'));
							echo html_writer::end_tag('li');
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/examsindex.php', array('id'=>$USER->id)), get_string('adminexams'));
							echo html_writer::end_tag('li');
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/mod/chat/gui_ajax/index.php', array('id'=>'4')), get_string('cifachat'));
							echo html_writer::end_tag('li');
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/course/view.php', array('id'=>'57')), get_string('feedback').' &nbsp;');
							echo html_writer::end_tag('li');							
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/report/allreport.php', array('id'=>$USER->id)), get_string('reports').' &nbsp;');							
							echo html_writer::end_tag('li');
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/login/logout.php', array('sesskey'=>sesskey())), get_string('logout'));
							echo html_writer::end_tag('li');
							echo html_writer::end_tag('ul');
							echo html_writer::end_tag('div');
							echo html_writer::end_tag('div');
							echo html_writer::end_tag('div');
						}
						}else{
							echo html_writer::start_tag('div', array('style'=>'float: right;'));
							echo html_writer::start_tag('div', array('id'=>'custom_menu_1', 'role'=>'menu', 'class'=>'yui3-menu yui3-menu-horizontal javascript-disabled'));
							echo html_writer::start_tag('div', array('class'=>'yui3-menu-content', 'role'=>'presentation'));
							echo html_writer::start_tag('ul', array('class'=>'first-of-type', 'role'=>'presentation'));
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/index.php', array('id'=>$USER->id)), get_string('home'));
							echo html_writer::end_tag('li');
							echo html_writer::start_tag('li', array('style'=>'padding: 0 10px;', 'class'=>'yui3-menuitem', 'role'=>'presentation'));
							echo html_writer::link(new moodle_url('/coursesindex.php'), get_string('enrollnow'));
							echo html_writer::end_tag('li');
							echo html_writer::end_tag('ul');
							echo html_writer::end_tag('div');
							echo html_writer::end_tag('div');	
							echo html_writer::end_tag('div');
					
					} ?>
					</div>
                    <?php } ?>
                    <div class="navbar">
                        <div class="wrapper clearfix">
                            <div class="breadcrumb"><?php if ($hasnavbar) echo $OUTPUT->navbar(); ?></div>
                            <div class="navbutton"> <b>Become an Expert</b> <?php echo $PAGE->button; ?></div>
                        </div>
                    </div>
                </div>
                <!-- END DROP DOWN MENU -->
            </div>
        </div>
    <?php } // if ($hasheading || $hasnavbar) ?>
        <!-- END OF HEADER -->
        <!-- START OF CONTENT -->
        <div id="page-content">
            <div id="region-main-box">
                <div id="region-post-box">
                    <div id="region-main-wrap">
                        <div id="region-main">
                            <div class="region-content">
                                <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($hassidepre) { ?>
                    <div id="region-pre" class="block-region">
                        <div class="region-content">
                            <?php //echo $OUTPUT->blocks_for_region('side-pre');?>
							<?php 
								require_once($CFG->dirroot .'/userfrontpage/adminhotmenu.php');
							?>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($hassidepost) { ?>
                    <div id="region-post" class="block-region">
                        <div class="region-content">					
                            <?php //echo $OUTPUT->blocks_for_region('side-post'); ?>
							<?php 
								require_once($CFG->dirroot .'/userfrontpage/adminhotmenu.php');
							?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- END OF CONTENT -->
        <div class="clearfix"></div>
    <!-- END OF #Page -->
    </div>
    <!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer">
	<div id="footer-wrapper">
            <?php if ($hasfootnote) { ?>
            <div id="footnote"><?php echo $PAGE->theme->settings->footnote; ?></div>
            <?php } ?>
            <p class="helplink"><?php //echo page_doc_link(get_string('moodledocslink')) ?></p>
            <?php
            echo $OUTPUT->login_info();
            //echo $OUTPUT->home_link();
            echo $OUTPUT->standard_footer_html();
			echo get_string('footertextcifa').'<br/><br/>';
            ?>
        </div>
    </div>
    <?php } ?>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>