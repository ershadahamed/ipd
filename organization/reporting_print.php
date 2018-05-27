<body onLoad="window.print()">
    <style>
        table {
            margin-bottom: 1em;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 1em;
            width: 90%;
            margin: 1em auto;
        }
        .formtable tbody th, .generaltable th.header {
            vertical-align: top;
            font-size: 12px;
            font-weight: bolder;
        }

        .cell {
            vertical-align: top;
        }
        th, td {
            border: 1px solid #000;
            padding: .5em;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        td.maincalendar table.calendartable th, table.rolecap .header, .generaltable .header, .forumheaderlist .header, .files .header, .editcourse .header, .logtable .header, #attempts .header, table#categoryquestions th {
            background: #f9f9f9 !important;
            font-size: 11px;
            font-weight: 200;
            text-decoration: none;
            color: #333 !important;
            border-top: 1px solid #ccc !important;
        }
        #page-admin-course-category .generalbox th, .editcourse .header, .results .header, #attempts .header, .generaltable .header, .environmenttable th, .forumheaderlist th {
            background: #f3f3f3;
            border-bottom-width: 2px;
        }
        .editcourse th, .editcourse td, .generaltable th, .generaltable td, #page-admin-course-category .generalbox th, #page-admin-course-category .generalbox td, #attempts th, #attempts td, .environmenttable th, .environmenttable td, .forumheaderlist td, .forumheaderlist th {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        html, body {
            font-family: Verdana,Geneva,sans-serif!important;
        }
        body {
            font: 13px/1.231 arial,helvetica,clean,sans-serif;
        }
        h2{
            width: 90%;
            margin: 1em auto;        
        }
    </style>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/datalib.php');
require_once($CFG->dirroot . '/lib.php');
require_once('lib.php');
require_once('lib_organization.php');
require_once('communication_lib.php');
require_once('userrole_lib.php');
require_once('report_lib.php');

$whichsupportbutton = optional_param('type', '', PARAM_MULTILANG);

echo '<h2>' . get_string('reporting') . '</h2>';

// report_lib.php
reporting_main($whichsupportbutton, $searchtitle, $searchdate, $searchcreatedby);