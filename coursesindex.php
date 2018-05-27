<?php
require_once('config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/filelib.php');
include('function/emailfunction.php');

$site = get_site();

$activetrainings = get_string('activetrainings');
$mytraining = get_string('mytraining');
$home_enroll = get_string('enrollnow');
$select_programme = 'Select Program';
$title = "$SITE->shortname: Courses";
$PAGE->set_title($title);
$PAGE->set_heading($site->fullname);

$activetrainings_link = new moodle_url('/coursesindex.php?id=', array('id' => $USER->id)); //added by arizan

if (isloggedin()) {
    $PAGE->navbar->add($mytraining, $activetrainings_link)->add($activetrainings, $activetrainings_link);
} else {
    $PAGE->navbar->add($home_enroll)->add($select_programme);
}
echo $OUTPUT->header();

if (isloggedin()) {
    if ($USER->id != '2') {
        // redirect if poassword not change
        $rselect = mysql_query("SELECT * FROM {$CFG->prefix}user_preferences WHERE userid='" . $USER->id . "' AND name='auth_forcepasswordchange' AND value='1'");
        $srows = mysql_num_rows($rselect);
        if ($srows != '0') {
            ?>
            <script language="javascript">
                window.location.href = '<?= $CFG->wwwroot . '/login/change_password.php'; ?>';
            </script>
            <?php
        }

        // redirect if profile not updated
        $rsc = mysql_query("SELECT * FROM {$CFG->prefix}user WHERE id='" . $USER->id . "' AND (email='' OR college_edu='' OR highesteducation='' OR yearcomplete_edu='0')");
        $srows2 = mysql_num_rows($rsc);
        if ($srows2 != '0') {
            ?>
            <script language="javascript">
                window.location.href = '<?= $CFG->wwwroot . '/user/edit.php?id=' . $USER->id . '&course=1'; ?>';
            </script>
            <?php
        }
    }
}
?>
<?php
include("includes/functions.php");

if ($_REQUEST['command'] == 'add' && $_REQUEST['productid'] > 0) {
    $pid = $_REQUEST['productid'];
    //echo $pid;
    addtocart($pid, 1);
    //header("location:shoppingcart.php?pid=$pid");
    //exit();
}
?>

<script language="javascript">
    function addtocart(pid) {
        document.formcart.productid.value = pid;
        document.formcart.command.value = 'add';
        document.formcart.submit();
    }
</script>

<form name="formcart">
    <input type="hidden" name="productid" />
    <input type="hidden" name="command" />
</form>


<?php
$priceid = $_GET['priceid'];
include_once('courses.php');
echo $OUTPUT->footer();
?>
