<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));

$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">
<?php if ($hasheading || $hasnavbar) { ?>
	<div id="page-header" style="min-height: 108px;background:url('<?php echo $CFG->wwwroot. '/image/logo.png';?>'); background-repeat:no-repeat; background-color: #5386bd;">    
        <?php if ($hasheading) { ?>
        <h1 class="headermain"><?php //echo $PAGE->heading ?></h1>
        <div class="headermenu"><?php
            if ($haslogininfo) {
                echo $OUTPUT->login_info();
            }
            if (!empty($PAGE->layout_options['langmenu'])) {
                echo $OUTPUT->lang_menu();
            }
            echo $PAGE->headingmenu;
        ?></div><?php } ?>
        <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } ?>
        <?php //if ($hasnavbar) { ?>
			<?php /********************************************************************************************************************/ ?>
        <?php //} ?>
    </div>
	<div class="breadcrumb">
		<?php if (isloggedin()) { ?>
		<?php //echo $OUTPUT->navbar(); ?>
		<?php } ?>
	</div>	
	<div class="navbar clearfix">
		<div class="navbutton"> <?php //echo $PAGE->button; ?></div>
		
		
		<?php 
			session_start();
			$_SESSION['page_ul'] = 'home';
		?>
		
		<?php
		function checkCurrentPage($thisPage){
			session_start();
			if($_SESSION['page_ul'] == $thisPage){
				return "class='check'";
			}
		}

		?>
		<?php
		include '../manualdbconfig.php';
		$sql=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='".$USER->id."'");
		$rs=mysql_fetch_array($sql);
		?>
		<ul>
			<li <?php echo checkCurrentPage('home');?> ><b><a href="<?php echo $CFG->wwwroot.'/index.php';?>"><?=get_string('home');?></a></b></li>
			<?php if($rs['roleid']!='10'){ ?>
				<?php 
					if (isloggedin()) { 
						if($USER->id == '2'){
				?>
				<li <?php echo checkCurrentPage('courses'); ?> >
					<b><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>"><?=get_string('adminmodules');?></a></b></li>
				<?php }else{ ?>
				<li <?php echo checkCurrentPage('courses'); ?> >
					<b><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>"><?=get_string('mytrainingprogram');?></a></b></li>					
			<?php }}else{ ?>
				<li <?php echo checkCurrentPage('courses'); ?> >
					<b><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>"><?=get_string('enrollnow');?></a></b></li>
			<?php }} ?>
			<?php if (isloggedin()) { if($USER->id == '2'){ ?>
			<li>
				<b><a href="<?php echo $CFG->wwwroot.'/examsindex.php';?>"><?=get_string('adminexams');?></a></b>
			</li>
			<?php }else{ ?>
			<li>
				<b><a href="<?php echo $CFG->wwwroot.'/examsindex.php';?>"><?=get_string('myexams');?></a></b>
			</li>
			<?php } ?>
			<li <?php echo checkCurrentPage('online users'); ?>>
				<b><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank"><?=get_string('cifachat');?></a></b>
			</li>
			<li <?php echo checkCurrentPage('survey'); ?> ><b><a><?=get_string('feedback');?></a></b></li>
			<?php if($USER->id =='2'){ ?>
			<li <?php echo checkCurrentPage('reports'); ?> ><b><a href="<?php echo $CFG->wwwroot.'/#';?>"><?=get_string('reports');?></a></b></li>
			<?php }} ?>
			<?php if (isloggedin()) { ?>
			<li><b><a href="<?=$CFG->wwwroot ."/login/logout.php?sesskey=".sesskey();?>" title="<?=get_string('logout');?>">Logout</a></b></li>
			<?php } ?>
		</ul>	
		<?php /********************************************************************************************************************/ ?>	
	</div>				
<?php } ?>
<!-- END OF HEADER -->

	<div id="page-content" style="min-height: 467px;background:url('<?php echo $CFG->wwwroot. '/theme/base/pix/bground.png';?>'); background-color:#eaf4f6; background-repeat:no-repeat; background-position:center;">
        <div id="region-main-box" style="min-height: 467px;background:url('<?php echo $CFG->wwwroot. '/theme/base/pix/bground.png';?>'); background-color:#eaf4f6; background-repeat:no-repeat;">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content" style="width: 95%;margin: 8px auto;">
							<?php if (isloggedin()) { ?>
							<a rel="nofollow" style="border-bottom-left-radius: 5px 5px;border-bottom-right-radius: 5px 5px;display:scroll;position:fixed;top:50%;" href="#" onclick="window.scrollTo(0,document.body.scrollHeight);return false;">
								<img src="<?php echo $CFG->wwwroot.'/image/arrow_down.png'; ?>" width="25" title="Go to Bottom"></a>							
							<a rel="nofollow" style="border-top-left-radius: 5px 5px;border-top-right-radius: 5px 5px;display:scroll;position:fixed;bottom:50%;" href="#" onclick="window.scrollTo(0,0); return false">
							<img src="<?php echo $CFG->wwwroot.'/image/arrow_up.png'; ?>" width="25" title="Back to Top"></a>						
							<?php } ?>
                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                        </div>
                    </div>
                </div>

                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
						<table width="100%" border="0" style="padding:0; margin:0;">
						<tr><td align="right"> 
							<?php if(($USER->id == '2') || ($rs['roleid']=='3')){ ?>	
							<?php if ($PAGE->user_is_editing()){ ?>
							<a href="<?php echo $CFG->wwwroot. '/course/view.php?id='.$COURSE->id.'&sesskey='.sesskey().'&edit=off';?>"><img src="<?php echo $CFG->wwwroot. '/image/Settings-off.png'; ?>" width="32" title="Turn off editing"></a>&nbsp;
							<?php }else{ ?>
							<a href="<?php echo $CFG->wwwroot. '/course/view.php?id='.$COURSE->id.'&sesskey='.sesskey().'&edit=on';?>"><img src="<?php echo $CFG->wwwroot. '/image/Settings-on.png'; ?>" width="32" title="Turn on editing"></a>&nbsp;
							<?php } ?>	
							<?php } ?>
							<a href=""><img src="<?php echo $CFG->wwwroot. '/image/Save.png'; ?>"></a>&nbsp;
							<a href=""><img src="<?php echo $CFG->wwwroot. '/image/Profile.png'; ?>"></a>&nbsp;
							<a href=""><img src="<?php echo $CFG->wwwroot. '/image/Info.png'; ?>"></a>&nbsp;
						</td></tr>
						</table>					
						<?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
	<div id="page-footer" class="clearfix" style="background:url('<?php echo $CFG->wwwroot. '/image/header.png';?>'); background-repeat:repeat-x; background-color: #8B3A62; padding:20px 0 20px;">
				<strong>CIFA - Certified Islamic Financial Analyst Program<sup>TM</sup></strong><br/>
				Offered by SHAPE Financial Corp. and supported by Islamic Finance Training(IFT) Red Money Group<br/>
				SHAPE<sup>TM</sup> now offers a comprehensive there level certification program to develop financial service professionals with a deep and on-going knowlegde of Islamic finance. The elements of the program are meant to assure that users understand and retain the islamic rules applied to finance, banking and investment. The program addresses the global islamic financial markets.
	</div>
    <?php } ?>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>