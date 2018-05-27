/*  jQuery ready function. Specify a function to execute when the DOM is fully loaded.  */
$(document).ready(
        /* This is the function that will get executed after the DOM is fully loaded ({ dateFormat: "yy-mm-dd" }) */
                function () {
                    $("#startdatepicker").datepicker({
                        dateFormat: "dd/mm/yy",
                        changeMonth: true, //this option for allowing user to select month
                        changeYear: true, //this option for allowing user to select from year range
                        minDate: 0 // this option to disable past date
                    });
                }

        );

        /*  jQuery ready function. Specify a function to execute when the DOM is fully loaded.  */
        $(document).ready(
                /* This is the function that will get executed after the DOM is fully loaded */
                        function () {
                            $("#enddatepicker").datepicker({
                                dateFormat: "dd/mm/yy",
                                changeMonth: true, //this option for allowing user to select month
                                changeYear: true, //this option for allowing user to select from year range
                                minDate: 0 // this option to disable past date
                            });
                        }

                );
// dob
                $(function () {
                    $('#datepicker').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });

// studiesstartdate
                $(function () {
                    $('#studiesstartdate').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });

// studies completion date
                $(function () {
                    $('#studiescompletiondate').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });

// registrationdate
                $(function () {
                    $('#registrationdate').datepicker({
                        dateFormat: 'dd-mm-yy',//,
                        changeMonth: true, //this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range
                                //minDate: 0 // this option to disable past date
                    });
                });
                
// date joined organization 
                $(function () {
                    $('#datejoinorganization').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });
                
 // date joined organization completiondate               
                $(function () {
                    $('#completiondate').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });
                
                
 // date for search in financial history               
                $(function () {
                    $('#datetimesearchfinance').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });
                
                $(function () {
                    $('#searchdatetimefinance').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });                
                
                $(function () {
                    $('#subscriptionstartdate').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });                
                
                $(function () {
                    $('#subscriptionenddate').datepicker({
                        dateFormat: 'dd-mm-yy'
                    });
                });
                
                $(function () {
                    $('#orgregistrationdate').datepicker({
                        dateFormat: 'dd-mm-yy',
                         changeMonth: true, //this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range                       
                    });
                });
                
                 $(function () {
                    $('#dobdatepicker').datepicker({
                        dateFormat: 'dd-mm-yy',
                         changeMonth: true, //this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range                       
                    });
                });    
                             
                 $(function () {
                    $('#creationdatetime').datepicker({
                        dateFormat: 'dd-mm-yy',
                         changeMonth: true, //this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range                       
                    });
                }); 
                
                 $(function () {
                    $('#creationdatedisplay').datepicker({
                        dateFormat: 'dd-mm-yy',
                         changeMonth: true, //this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range                       
                    });
                });    
                 $(function () {
                    $('#specificdate').datepicker({
                        dateFormat: 'dd-mm-yy',
                         changeMonth: true, //this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range                       
                    });
                });                 
                
/* $(document).ready(
        /* This is the function that will get executed after the DOM is fully loaded ({ dateFormat: "yy-mm-dd" }) */
                /*function () {
                    $("#orgregistrationdate").datepicker({
                        dateFormat: "dd/mm/yy",
                        changeMonth: true, //this option for allowing user to select month
                        changeYear: true, //this option for allowing user to select from year range
                        minDate: 0 // this option to disable past date
                    });
                }

        );  */              