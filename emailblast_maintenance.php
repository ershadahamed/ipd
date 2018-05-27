<?php
// define('CLI_SCRIPT', true);
require_once('config.php');
require_once($CFG->libdir . '/logactivity_lib.php');
//require_once($CFG->libdir . '/moodlelib.php');
//require_once($CFG->dirroot . '/lib.php');

// $recipientusers = $DB->get_recordset_sql("SELECT * FROM {user} WHERE id='391'"); // 172 309 148
$recipientusers = $DB->get_recordset_sql("SELECT * FROM {user} WHERE id='391' OR id='172' OR id='309' OR id='148'");
// $recipientusers = $DB->get_records_sql("SELECT * FROM {user} WHERE deleted='0' And confirmed='1' And id>'407' And id!='545'");
$no='1';
$table = new html_table();
$table->width = "100%";
$table->head = array('No', 'Candidate ID', 'Candidate Name', get_string('email'));
$table->align = array("center", "center", "left", "left");
foreach ($recipientusers as $rusers) {
        /*if (lms_schedule_maintenance($rusers)) {
            $fullname = $rusers->firstname.' '.$rusers->lastname;
            $table->data[] = array(
                $no++, strtoupper($rusers->traineeid),$fullname, $rusers->email
            );           
        }else{
            $fullname = $rusers->firstname.' '.$rusers->lastname;
            $table->data[] = array(
                '---->'.$no++, strtoupper($rusers->traineeid),$fullname, $rusers->email
            );            
        }*/
	// email user
        //lms_schedule_maintenance($rusers);
	// lms_welcome_email($rusers);
    $fullname = $rusers->firstname.' '.$rusers->lastname;
    if(!manual_sendingmail($rusers)){ echo $fullname; }else{ echo $no++; }
}  
$recipientusers->close();
if (!empty($table)) {
    echo html_writer::table($table);
}