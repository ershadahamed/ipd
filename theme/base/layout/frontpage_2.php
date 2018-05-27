<?php

//$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
//$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

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
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">
    <div id="page-header" style="background:url('<?php echo $CFG->wwwroot. '/image/header.png';?>'); background-repeat:repeat-x; background-color: #8B3A62;"> 
        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
        <div class="headermenu"><?php
                echo $OUTPUT->login_info();
                echo $OUTPUT->lang_menu();

            echo $PAGE->headingmenu;
        ?></div>
        <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } ?>
        <?php //if ($hasnavbar) { ?>
			<?php /********************************************************************************************************************/ ?>
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

				<ul>
					<li <?php echo checkCurrentPage('home');?> ><a href="<?php echo $CFG->wwwroot.'/index.php';?>">Home</a></li>
					<li <?php echo checkCurrentPage('courses'); ?> ><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>">Courses</a></li>
					<li <?php echo checkCurrentPage('exams'); ?> ><a href="<?php echo $CFG->wwwroot.'/examsindex.php';?>">Exams</a></li>
					<li <?php echo checkCurrentPage('online users'); ?>>
						<?php if (isloggedin()) { 
						add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);?>
						<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=1';?>" target="_blank">Online Users</a>
						<?php }else{ ?>
						<a>Online Users</a>
						<?php } ?>
					</li>
					<li <?php echo checkCurrentPage('survey'); ?> ><a>Survey</a></li>
					<li <?php echo checkCurrentPage('reports'); ?> ><a>Reports</a></li>
				</ul>
				<ul class="account">
					<li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Account</a></li>
				</ul>
				<?php /********************************************************************************************************************/ ?>
				
				
				
            </div>
        <?php //} ?>
    </div>
<!-- END OF HEADER -->

    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content" style="width: 95%;margin: 8px auto;">
                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                        </div>
                    </div>
                </div>

                <?php/* if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } */?>

                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
						<table width="100%" border="0" style="padding:0; margin:0;">
						<tr><td align="right">
						<?php if ($PAGE->user_is_editing()){ ?>
							<a href="<?php echo $CFG->wwwroot. '/course/view.php?id=1&sesskey=Pau7yUjOIn&edit=off';?>"><img src="<?php echo $CFG->wwwroot. '/image/Profile.png'; ?>"></a>&nbsp;
							<?php }else{ ?>
							<a href="<?php echo $CFG->wwwroot. '/course/view.php?id=1&sesskey=Pau7yUjOIn&edit=on';?>"><img src="<?php echo $CFG->wwwroot. '/image/Save.png'; ?>"></a>&nbsp;
							<?php } ?>
							<a><img src="<?php echo $CFG->wwwroot. '/image/Profile.png'; ?>"></a>&nbsp;
							<a><img src="<?php echo $CFG->wwwroot. '/image/Info.png'; ?>"></a>&nbsp;
						</td></tr>
						</table>					
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>

<!-- START OF FOOTER -->
	<div id="page-footer" class="clearfix" style="background:url('<?php echo $CFG->wwwroot. '/image/header.png';?>'); background-repeat:repeat-x; background-color: #8B3A62; padding:20px 0 20px;">
				<strong>CIFA - Certified Islamic Financial Analyst Program<sup>TM</sup></strong><br/>
				Offered by SHAPE Financial Corp. and supported by Islamic Finance Training(IFT) Red Money Group<br/>
				SHAPE<sup>TM</sup> now offers a comprehensive there level certification program to develop financial service professionals with a deep and on-going knowlegde of Islamic finance. The elements of the program are meant to assure that users understand and retain the islamic rules applied to finance, banking and investment. The program addresses the global islamic financial markets.
	</div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>