<?php
//if($USER->id =='2'){ 
//$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
//}
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
//if($USER->id =='2'){ 
//$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);
//}
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
    <!--div id="page-header" style="background:url('<?php //echo $CFG->wwwroot. '/image/header.png';?>'); background-repeat:repeat-x; background-color: #8B3A62;"--> 
	<!--div id="page-header" style="min-height: 108px;background:url('<?php //echo $CFG->wwwroot. '/image/logo-learning.png';?>'); background-repeat:no-repeat; background-color: #5386bd;"-->        
	<div id="page-header" style="background-size: 100% Auto; min-height: 168px;height: 100%;background-image:url('<?php echo $CFG->wwwroot. '/image/logo-learning-shape.png';?>'); background-repeat:no-repeat; background-color: #eaf4f6;">        
		<h1 class="headermain"><?php //echo $PAGE->heading ?></h1>
        <div class="headermenu"><?php
                //echo $OUTPUT->login_info();
                echo $OUTPUT->lang_menu();

            echo $PAGE->headingmenu;
        ?></div>
        <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } ?>
        <?php //if ($hasnavbar) { ?>
			<?php /********************************************************************************************************************/ ?>

        <?php //} ?>
    </div>
	<!--div class="breadcrumb">
		<?php /*if (isloggedin()) { ?>
		<?php echo $OUTPUT->navbar(); ?>
		<?php } */?>
	</div-->	
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
		include 'manualdbconfig.php';
		$sql=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='".$USER->id."'");
		$rs=mysql_fetch_array($sql);

		?>
		<ul>
			<li <?php echo checkCurrentPage('home');?> ><a href="<?php echo $CFG->wwwroot.'/index.php';?>">Home</a></li>
			<?php if($rs['roleid']!='10'){ ?>
			<li <?php echo checkCurrentPage('courses'); ?> ><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>">Modules</a></li>
			<?php } ?>
			<li <?php echo checkCurrentPage('exams'); ?> ><a href="<?php echo $CFG->wwwroot.'/examsindex.php';?>">Exams</a></li>
			<li <?php echo checkCurrentPage('online users'); ?>>
				<?php if (isloggedin()) { 
				add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);?>
				<a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id=4';?>" target="_blank">Online Users</a>
				<?php }else{ ?>
				<a>Online Users</a>
				<?php } ?>
			</li>
			<li <?php echo checkCurrentPage('survey'); ?> ><a href="<?php echo $CFG->wwwroot.'/course/view.php?id=57';?>">Survey</a></li>
			<?php if($USER->id =='2'){ ?>
			<li <?php echo checkCurrentPage('reports'); ?> ><a href="<?php echo $CFG->wwwroot.'/purchase_transaction.php';?>">Reports</a></li>
			<?php } ?>
			<li><a href="<?=$CFG->wwwroot ."/login/logout.php?sesskey=".sesskey();?>" title="<?=get_string('logout');?>">Logout</a></li>
		</ul>
		<!--div style="float:right; padding-top:5px; font-weight: bolder;">
		<?php //echo $OUTPUT->login_info();  ?></div-->
	</div>
<!-- END OF HEADER -->

    <!--div id="page-content"-->
	<div id="page-content" style="background:url('<?php echo $CFG->wwwroot. '/theme/base/pix/bground_frontpage.png';?>'); background-repeat:no-repeat; background-position:center;background-color:#eaf4f6;">	
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content" style="width: 95%;margin: 8px auto;">
                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                        </div>
                    </div>
                </div>

				<?php /*if($USER->id =='2'){ ?>
                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
						<table width="100%" border="0" style="padding:0; margin:0;">
						<tr><td align="right">
							<?php if(($USER->id == '2') || ($rs['roleid']=='3')){ ?>
							<?php if ($PAGE->user_is_editing()){ ?>
							<a href="<?php echo $CFG->wwwroot. '/course/view.php?id=1&sesskey='.sesskey().'&edit=off';?>"><img src="<?php echo $CFG->wwwroot. '/image/Settings-off.png'; ?>" width="32" title="Turn off editing"></a>&nbsp;
							<?php }else{ ?>
							<a href="<?php echo $CFG->wwwroot. '/course/view.php?id=1&sesskey='.sesskey().'&edit=on';?>"><img src="<?php echo $CFG->wwwroot. '/image/Settings-on.png'; ?>" width="32" title="Turn on editing"></a>&nbsp;
							<?php } ?>
							<?php } ?>
							<a href="<?php echo $CFG->wwwroot ;?>"><img src="<?php echo $CFG->wwwroot. '/image/Save.png'; ?>"></a>&nbsp;
							<a><img src="<?php echo $CFG->wwwroot. '/image/Profile.png'; ?>"></a>&nbsp;
							<a><img src="<?php echo $CFG->wwwroot. '/image/Info.png'; ?>"></a>&nbsp;
						</td></tr>
						</table>					
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php }}*/ ?>

            </div>
        </div>
    </div>

<!-- START OF FOOTER -->
	<!--div id="page-footer" class="clearfix" style="background:url('<?php //echo $CFG->wwwroot. '/image/header.png';?>'); background-repeat:repeat-x; background-color: #8B3A62; padding:20px 0 20px;"-->
	<div id="page-footer" class="clearfix" style="background-color: #5386bd; padding:20px 0 20px;">
				<strong>SHAPE<sup>TM</sup> IPD - Islamic Professional Development</strong><br/>
				Developed by SHAPE for Economic Consulting, W.L.L<br/>
	</div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>