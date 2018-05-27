<style>
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12{
        /* padding-left: 15px; */
        padding-right: 15px; 
    }

    .widget-app .link-list {
        margin: 0px;
    }

</style>
<script type="text/javascript">
    function popupwindow(url, title, w, h) {//Center PopUp Window added by Arizan
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>
<?php
//new curiculum/ipd course
$today = date('d-m-Y H:i:s', strtotime('now'));

//IPD candidate 
$IPDstatement = " mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='" . $USER->id . "'";
$selIPD = mysql_query("SELECT * FROM {$IPDstatement}");
$cIPD = mysql_num_rows($selIPD);

//header menu//
if ($USER->id != '1') {  // NOT A GUEST
    $link_myaccount = '<a class="link" href="' . $CFG->wwwroot . '/user/profile.php?id=' . $USER->id . '">';
    $link_mytraining = '<a class="link" href="' . $CFG->wwwroot . '/coursesindex.php?id=' . $USER->id . '">';
    $link_mycommunity = '<a class="link" href="' . $CFG->wwwroot . '/userfrontpage/mycommunitypage.php?id=' . $USER->id . '">';
    $link_mocktest = '<a class="blockbar" href="' . $CFG->wwwroot . '/course/mock_test.php?id=' . $USER->id . '">';
    $link_finaltest = '<a class="blockbar" href="' . $CFG->wwwroot . '/course/finaltest.php?id=' . $USER->id . '">';
} else { // GUEST
    $link_myaccount = '<a class="link" href="#">';
    $link_mytraining = '<a class="link" href="#">';
    $link_mycommunity = '<a class="link" href="#">';
    $link_mocktest = '<a class="blockbar" href="#">';
    $link_finaltest = '<a class="blockbar" href="#">';
}
$ahref_close = '</a>';

//link
$financiallink = $CFG->wwwroot . '/financialstatement/candidateview.php?id=' . $USER->id;
$ipdonlinefaq = $CFG->wwwroot . '/ipdfaq.php?id=' . $USER->id;
$utube = $PAGE->theme->settings->youtube;
?>
<p style="font-size:20px;font-weight:bolder;margin-bottom:1.3em;"><?= get_string('welcomenote'); ?></p>
<div id="main-app-body">
    <div class="container">

        <div class="row">
            <div class="col-md-9"> 
                <?php
                $selectstatement2 = mysql_query("SELECT * FROM mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid WHERE a.traineeid='" . $USER->traineeid . "' AND b.paystatus='paid'");
                $ssql2 = mysql_num_rows($selectstatement2);
                ?>				
                <div class="row margin-lg-bottom">
                    <div class="col-md-4">

                        <div class="widget-app-header">
                            <div class="title"><?= $link_myaccount . get_string('myaccount') . $ahref_close; ?></div>
                        </div><!-- .widget-app-header -->
                        <!--div class="widget-app" style="padding:0px;"-->
                            <div class="widget-app-body">
                                <div class="link-list">
                                    <?php if ($USER->id != '1') {  // NOT A GUEST ?>
                                        <a class="blockbar" href="<?php echo $CFG->wwwroot . '/user/profile.php?id=' . $USER->id; ?>">
                                            <?= get_string('profile'); ?></a>
                                        <a class="blockbar" href="<?php echo $CFG->wwwroot . '/login/change_password.php?id=1'; ?>">
                                            <?= get_string('changepassword'); ?></a>
                                        <a class="blockbar" href="<?= $financiallink; ?>"><?= get_string('financialstatement'); ?></a>											
                                    <?php } else { // GUEST USER  ?>
                                        <a class="link" href="#"><?= get_string('profile'); ?></a>
                                        <a class="link" href="#"><?= get_string('changepassword'); ?></a>
                                        <a class="link" href="#"><?= get_string('financialstatement'); ?></a>
                                    <?php } ?>

                                    <?php if ($ssql2 != '0') { ?>
                                        <a class="blockbar" href="<?php echo $CFG->wwwroot . '/userfrontpage/listofnameenrolment.php'; ?>">
                                            <?= get_string('enrolmentconfirmation'); ?></a>
                                    <?php } else { ?>
                                        <a class="blockbar" href="#"><?= get_string('enrolmentconfirmation'); ?></a>		
                                    <?php } ?>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                        <!--/div--><!-- .widget-app -->
                    </div><!-- .col-md-4 -->
                    <div class="col-md-4"><!-- .MY TRAINING. -->

                        <div class="widget-app-header">
                            <div class="title"><?= $link_mytraining . get_string('mytraining') . $ahref_close; ?></div>
                        </div><!-- .widget-app-header -->
                            <div class="widget-app-body">
                                <div class="link-list">
                                    <?php
                                    if ($USER->id != '1') { // NOT A GUEST 
                                        $policy = $CFG->wwwroot . '/userpolicy.php';
                                        ?>
                                        <a class="blockbar" href="<?php echo $CFG->wwwroot . '/coursesindex.php?id=' . $USER->id; ?>"><?= get_string('activetrainings'); ?></a>
                                        <?= $link_mocktest; ?><?= get_string('mocktest'); ?></a>
                                        <?= $link_finaltest; ?><?= get_string('finaltest'); ?></a>
                                        <a class="blockbar" href="<?= $CFG->wwwroot . '/userfrontpage/viewuserresult.php?id=' . $USER->id; ?>"><?= get_string('testresult'); ?></a>
                                        <a class="blockbar" onclick="window.open('<?= $policy; ?>', 'Window2', 'width=880,height=630,resizable = 1,scrollbars=1');" href="#">
                                        <?= get_string('cifaonlinepolicy'); ?></a>
                                        <a class="blockbar" title="<?= get_string('ipdonlinefaq'); ?>" href="javascript:void(0);" onclick="popupwindow('<?php echo $CFG->wwwroot . '/ipdfaq.php?id=' . $USER->id; ?>', 'googlePopup', 880, 630);"><?= get_string('ipdonlinefaq'); ?></a>
                                        <a class="blockbar" href="#"><?= get_string('ipddemo'); ?></a>

                                    <?php } else { // GUEST ?>
                                        <a class="blockbar" href="<?= $CFG->wwwroot . '/course/view.php?id=32'; ?>"><?= get_string('activetrainings'); ?></a>
                                        <?= $link_mocktest; ?><?= get_string('mocktest'); ?></a>
                                        <?= $link_finaltest; ?><?= get_string('finaltest'); ?></a>
                                        <a class="blockbar" href="#"><?= get_string('testresult'); ?></a>
                                        <a class="blockbar" href="#"><?= get_string('cifaonlinepolicy'); ?></a>
                                        <a class="blockbar" href="#" title="<?= get_string('ipdonlinefaq'); ?>" ><?= get_string('ipdonlinefaq'); ?></a>
                                        <a class="blockbar" href="#"><?= get_string('ipddemo'); ?></a>
                                    <?php } ?>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                    </div><!-- .col-md-4 -->
                    <div class="col-md-4">

                        <div class="widget-app-header">
                            <div class="title"><?= $link_mycommunity . get_string('mycommunity') . $ahref_close; ?></div>
                        </div><!-- .widget-app-header -->
                            <div class="widget-app-body">
                                <div class="link-list">
                                        <?php if ($USER->id != '1') { // NOT A GUEST  ?>
                                        <?php $popupchat = $CFG->wwwroot . "/mod/chat/gui_ajax/index.php?id=4"; 
                                        $socialnetwork = $CFG->wwwroot . '/mc_socialnetwork.php';
                                        ?>
                                        <a class="blockbar" title="CIFAChat" onclick="window.open('<?php echo $popupchat; ?>', 'Window2', 'width=880,height=630, scrollbars=1');" href="#"><?= get_string('cifachat'); ?></a>
                                        <?php } else { ?>
                                            <a class="blockbar" title="CIFAChat" href="#"><?= get_string('cifachat'); ?></a>										
                                        <?php } ?>
                                        <a class="blockbar" href="#"><?= get_string('cifablog'); ?></a> 
                                        <a class="blockbar" href="<?= $utube; ?>" target="_blank"><?= get_string('youtube'); ?></a>
                                        <a class="blockbar" title="<?= get_string('socialnetwork'); ?>" href="javascript:void(0);" onclick="popupwindow('<?= $socialnetwork; ?>', 'googlePopup', 880, 630);"><?= get_string('socialnetwork'); ?></a>
                                        <?php if ($USER->id != '1') { // NOT A GUEST  ?>
                                        <a class="blockbar" href="<?php echo $CFG->wwwroot . '/mod/feedback/complete.php?id=128&courseid=&gopage=0'; ?>"><?= get_string('feedbackreview'); ?></a>
                                        <?php } else { // GUEST ?>
                                            <a class="blockbar" href="#"><?= get_string('feedbackreview'); ?></a>										
                                        <?php } ?>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                    </div><!-- .col-md-4 -->
                </div><!-- .row -->
            </div><!-- .col-md-9 -->
            <div class="col-md-3"><div class="widget-app-header">
                    <div class="title">News & Update</div>
                </div><!-- .widget-app-header -->
                <div class="widget-app" style="padding:0px;">
                    <!--div class="widget-app-header">
                        <div class="title" style="display:none;">News & Update</div>
                    </div--><!-- .widget-app-header -->
                    <div class="widget-app-body"  style="padding:5px 12px 12px;">
                        <div class="post-list margin-md-top" style="margin-top:0px;">
                            <div class="post"> 
                                <!--div class="header"></div-->
                                <div class="excerpt">
                                    <?php
                                    $newlink = $CFG->wwwroot . '/image/new_animated.gif';
                                    $snews = mysql_query("SELECT * FROM {$CFG->prefix}news_update WHERE status='0'");
                                    while ($news = mysql_fetch_array($snews)) {
                                        echo $news['title'] . '&nbsp;<img src="' . $newlink . '" width="23"><br/>';
                                    }

                                    $selectnew = mysql_query("SELECT * FROM mdl_cifacourse WHERE visible='1' AND (category!='0' AND category!='3' AND category!='6') ORDER BY id DESC");
                                    $n = '0';
                                    $ab = '0';
                                    while ($serow = mysql_fetch_array($selectnew)) {
                                        $n++;
                                        $ab++;
                                        $createdate = date('d-m-Y H:i:s', $serow['timecreated']);
                                        $expireddate = date('d-m-Y H:i:s', strtotime($createdate . " + 1 month"));

                                        $current = strtotime('now');
                                        $start = strtotime($createdate);
                                        $ex = strtotime($expireddate);

                                        if ($start <= $current && $current <= $ex) {
                                            $sc = mysql_query("SELECT * FROM mdl_cifacourse_categories WHERE id!='3' AND id='" . $serow['category'] . "'");
                                            $rws = mysql_fetch_array($sc);
                                            $newlink = $CFG->wwwroot . '/image/new_animated.gif';
                                            $link_to_course = $CFG->wwwroot . '/course/view.php?id=' . $serow['id'];
                                            $link_open = "<a href='" . $link_to_course . "' title='Click to open " . $serow['fullname'] . "'>";
                                            $link_close = "</a>";

                                            $sql_cek = mysql_query("
													Select
													  *
													From
													  mdl_cifaenrol a Inner Join
													  mdl_cifauser_enrolments b On a.id = b.enrolid
													Where
													  b.userid = '" . $USER->id . "' And
													  a.courseid = '" . $serow['id'] . "'												
												");
                                            $c_even = mysql_num_rows($sql_cek);
                                            // echo $link_open.$serow['fullname'].'&nbsp;<img src="'.$newlink.'" width="23">'.$link_close.'<br/>';
                                        }

                                        //quiz//exam//mockexam
                                        $query_mock = mysql_query("SELECT * FROM mdl_cifaquiz WHERE course='" . $serow['id'] . "'");
                                        $s_mock = mysql_fetch_array($query_mock);
                                        $mock_createdate = date('d-m-Y H:i:s', $s_mock['timemodified']);
                                        $mock_expireddate = date('d-m-Y H:i:s', strtotime($mock_createdate . " + 1 month"));

                                        $m_current = strtotime('now');
                                        $m_start = strtotime($mock_createdate);
                                        $m_ex = strtotime($mock_expireddate);

                                        if ($m_start <= $m_current && $m_current <= $m_ex) {
                                            $m_sc = mysql_query("SELECT * FROM mdl_cifacourse_modules WHERE course='" . $s_mock['course'] . "' AND instance='" . $s_mock['id'] . "'");
                                            $m_rws = mysql_fetch_array($m_sc);
                                            $newlink = $CFG->wwwroot . '/image/new_animated.gif';
                                            $link_to_mock = $CFG->wwwroot . '/mod/quiz/view.php?id=' . $m_rws['id'];
                                            $m_link_open = "<a href='" . $link_to_mock . "' title='Click to start " . $s_mock['name'] . "'>";
                                            $link_close = "</a>";

                                            $sql_cek = mysql_query("
													Select
													  *
													From
													  mdl_cifaenrol a Inner Join
													  mdl_cifauser_enrolments b On a.id = b.enrolid
													Where
													  b.userid = '" . $USER->id . "' And
													  a.courseid = '" . $serow['id'] . "'
													Order By
													  b.id
												");
                                            $c_even = mysql_num_rows($sql_cek);
                                            //echo $m_link_open.$s_mock['name'].'&nbsp;<img src="'.$newlink.'" width="23">'.$link_close.'<br/>';
                                        }
                                    }
                                    ?>
                                </div><!-- .excerpt -->
                                <!--div class="date">July 22, 2013</div-->
                            </div><!-- .post -->
                        </div><!-- .post-list -->
                    </div><!-- .widget-app-body -->
                </div><!-- .widget-app -->
            </div><!-- .col-md-3 -->
        </div><!-- .row -->

    </div><!-- .container -->
</div><!-- #main-app-body -->