<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/datalib.php');
require_once($CFG->dirroot . '/lib.php');
require_once('../lib.php');
require_once('../lib_organization.php');
require_once('../userrole_lib.php');
require_once('userrole_editoptionform.php');

$id = optional_param('roleid', '', PARAM_INT);       // course id
$formtype = optional_param('formtype', '', PARAM_MULTILANG);       // course id
$returnto = optional_param('returnto', 0, PARAM_ALPHANUM); // generic navigation return page switch

// echo $id . $formtype;
/*$sql="Select * FROM {$CFG->prefix}role Where id='".$id."'";
$data = $DB->get_record_sql($sql);

echo $data->name.''.$data->id;*/

// Delete records from table role
$DB->delete_records('role', array('id'=>$id));
$DB->delete_records('role_assignments', array('roleid'=>$id));
?>

<script language="javascript">
    window.alert("Delete successful.");
    window.opener.location.reload(true);
</script>
<?php
close_window();
