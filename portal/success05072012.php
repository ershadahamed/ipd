<?php
    require_once('../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php'); 

	$site = get_site();
	
	$purchase='Purchase modules';
	$title="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('courses');

	echo $OUTPUT->header();		
	?>

<?php
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';

$tx_token = $_GET['tx'];

$auth_token = "FRyP-hdWhtYfoc9c64krTpIWiQS-ANeYz2NsSjBJKXv81eQStdkPdOGdMs0";

$req .= "&tx=$tx_token&at=$auth_token";


// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
// If possible, securely post back to paypal using HTTPS
// Your PHP server will need to be SSL enabled
// $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
// read the body data
$res = '';
$headerdone = false;
while (!feof($fp)) {
$line = fgets ($fp, 1024);
if (strcmp($line, "\r\n") == 0) {
// read the header
$headerdone = true;
}
else if ($headerdone)
{
// header has been read. now read the contents
$res .= $line;
}
}

// parse the data
$lines = explode("\n", $res);
$keyarray = array();
if (strcmp ($lines[0], "SUCCESS") == 0) {
for ($i=1; $i<count($lines);$i++){
list($key,$val) = explode("=", $lines[$i]);
$keyarray[urldecode($key)] = urldecode($val);
}

// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct

// process payment
$firstname = $keyarray['first_name'];
$lastname = $keyarray['last_name'];
$itemname = $keyarray['item_name'];
$amount = $keyarray['mc_gross'];
$payment_status = $keyarray['payment_status'];
$mc_currency = $keyarray['mc_currency'];
$payer_email = $keyarray['payer_email'];
$txn_id = $keyarray['txn_id'];
$invoice = $keyarray['invoice'];

$business = $keyarray['business'];
$receiver_email = $keyarray['receiver_email'];
$receiver_id = $keyarray['receiver_id'];
$memo = $keyarray['memo'];

$option_name1 = $keyarray['option_name1'];
$option_name2 = $keyarray['option_name2'];
$option_selection1 = $keyarray['option_selection1'];
$option_selection2 = $keyarray['option_selection2'];
$tax = $keyarray['tax'];
$pending_reason = $keyarray['pending_reason'];
$reason_code = $keyarray['reason_code'];
$payment_type = $keyarray['payment_type'];
$lc=$keyarray['mc_currency'];


// check the payment_status is Completed
if($payment_status != 'Completed'){
	echo 'Please refer to administration for registration. Thank you.';
	exit;
}else{
	include('../manualdbconfig.php');
	include('../config.php');
	
	// check that the invoice has not been previously processed	
	$sqls = "SELECT payment_status
			FROM mdl_cifa_modulesubscribe
			WHERE invoiceno = '".$invoice."'";

	$results = mysql_query($sqls);

	// if no invoice with such number is found, exit
	if (mysql_fetch_array($results) == 0) {
		echo 'Invoice no. with such number '.$invoice. ' is not found.';
		exit;
	}else{
		$rows = mysql_fetch_array($results);
			
			// check that the buyer sent the right amount of money
			$sql = "SELECT cost
					FROM mdl_cifa_modulesubscribe
					WHERE invoiceno = '".$invoice."'";
			$result = mysql_query($sql);
			$row    = mysql_fetch_array($result);		
			
			$total = $row['cost'];	
			
			if($amount != $total){
				echo'The amount '.$amount.' '.ucwords(strtoupper($lc)).' is not the right amount';
				exit;
			}else{
				if (!get_magic_quotes_gpc()) {
					$memo = addslashes($memo);
				}			
	//SQL for update infomation on mdl_cifa_modulesubscribe
	//update payment_status
	$sql = mysql_query("UPDATE mdl_cifa_modulesubscribe
						SET payment_status = 'Paid' WHERE invoiceno = '".$invoice."'");	
										
	if($sql){		
	//SQL for enrol user to a course******************************************************************//
           if (!isloggedin()) {
               $sqlUser = "SELECT *
                                FROM mdl_cifa_modulesubscribe
                                WHERE invoiceno = '".$invoice."'";               
               $queryUser=mysql_query($sqlUser);
               $rowsU=mysql_fetch_array($queryUser);
               
			   $pword_text='Password01$';
               $password=md5($pword_text);
               $timecreated = strtotime('now');
               $lastcreated = strtotime("now" . " + 1 year");
               $dob2=$rowsU['dob'];
               $addressUser=$rowsU['address1'];
               $phoneUser=$rowsU['phone_no'];
               $countryUser=$rowsU['country'];
               
               //echo $dob2.''.$rowsU['city'];
               //insert new candidate to system
               $sqlReg="INSERT INTO mdl_cifauser
                          SET username='".$option_selection2."', password='".$password."', firstname='".$rowsU['firstname']."', lastname='".$rowsU['lastname']."', 
                              email='".$rowsU['email']."', traineeid='".$option_selection2."', dob='".$dob2."', mnethostid='1', confirmed='1', usercategoryid='1', 
                              timecreated='".$timecreated."', lasttimecreated='".$lastcreated."', usertype='Active trainee', phone1='". $phoneUser."', address='".$addressUser."', country='".$countryUser."', city='".$rowsU['city']."'";
               $sqlRegQ=mysql_query($sqlReg) or die("sql gagal<br/>" .mysql_error());
               
            }
            $sqlOrder="
			Select
				a.courseid,
				a.email,
				a.coursename,
				a.invoiceno,
				b.enrol,
				b.id,
				a.traineeid,
				a.payment_status,
				c.id As userid
			From
				mdl_cifa_modulesubscribe a,
				mdl_cifaenrol b,
				mdl_cifauser c
			Where
				a.courseid = b.courseid And
				a.traineeid = c.traineeid And
				(a.invoiceno = '".$invoice."' And
				b.enrol = 'paypal' And b.status='0')
			";
			
			$orderQuery=mysql_query($sqlOrder);
			$orderView=mysql_fetch_array($orderQuery) or die("Insert Query Fail.<br/>" .mysql_error());

			if($orderView['payment_status'] == 'Paid'){
				$courseid=$orderView['courseid']; //14
				$enrolid=$orderView['id']; //59
				$userid=$orderView['userid']; //4
				
				//enrol new user to mdl_cifauser_enrolments
				$today = strtotime('now');
				$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments 
										SET enrolid='".$enrolid."', userid='".$userid."',
										timecreated='".$today."', timemodified='".$today."',
										modifierid='2', emailsent='1'");
				if(!$sqlInsert){
					echo"Problem with your payment, please contact administration.";
					exit;
				}
				else{					
					//if all transaction is Success - save to database
					$sqltransaction=mysql_query("INSERT INTO mdl_cifaenrol_paypal
						SET business='".$business."', receiver_email='".$receiver_email."', receiver_id='".$receiver_id."', item_name='".$itemname."', courseid='".$courseid."',
							userid='".$userid."', instanceid='".$enrolid."', memo='".$memo."', tax='".$tax."', option_name1='".$option_name1."', option_selection1_x='".$option_selection1."',
							option_name2='".$option_name2."', option_selection2_x='".$option_selection2."', payment_status='".$payment_status."', pending_reason='".$pending_reason."',
							reason_code='".$reason_code."', txn_id='".$txn_id."', parent_txn_id='".$txn_id."', payment_type='".$payment_type."', timeupdated='".$today."'");	
				}
                            //send email to user
                            if (!isloggedin()) {
                                include('subscribe/email-function.php');
                            }else{						
                                include('email-function.php');
                            }
			}
			//****************************************************************///
		}	//end update payment status
		}	//end check payment amount
		}	//end check invoice number
	}
	//end if payment frm paypal Completed

		echo ("<p><h3>Thank you for your purchase!</h3></p>");

		/*echo ("<b>Payment Details</b><br>\n");
		echo ("<li>Paypal name: $firstname $lastname</li>\n");
		echo ("<li>Item: $itemname</li>\n");
		echo ("<li>Amount: $amount</li>\n");
		echo ("<li>Payment_status: $payment_status</li>\n");
		echo ("<li>Mc_currency: $mc_currency</li>\n");
		echo ("<li>Payer_email: $payer_email</li>\n");
		echo ("<li>Txn_id: $txn_id</li>\n");		
		
		echo ("<li>invoice: $invoice</li>\n");
		echo ("<li>business: $business</li>\n");
		echo ("<li>receiver_email: $receiver_email</li>\n");
		echo ("<li>receiver_id: $receiver_id</li>\n");
		echo ("<li>memo: $memo</li>\n");
		echo ("<li>option_name1: $option_name1</li>\n");
		echo ("<li>option_name2: $option_name2</li>\n");
		echo ("<li>option_selection1: $option_selection1</li>\n");
		echo ("<li>option_selection2: $option_selection2</li>\n");
		echo ("<li>tax: $tax</li>\n");		
		echo ("<li>payment_type: $payment_type</li>\n");
		echo ("<br/>");*/
                
                //send email to user
                //if (!isloggedin()) {
                //include('subscribe/email-function.php');
               // }
                
}
else if (strcmp ($lines[0], "FAIL") == 0) {
// log for manual investigation
}

}

fclose ($fp);

?>

Your transaction has been completed, and a receipt for your purchase has been emailed to you.<br>You may log into your paypal account at <a href='https://www.paypal.com'>www.paypal.com</a> to view details of this transaction.<br>

<?php if (!isloggedin()) { ?>
Or you can enter you course at <a href="<?php $CFG->wwwroot. '/cifa'; ?>">CIFA ONLINE</a>
<br/><br/>
Please Check your email to get the login ID and temporary password. Thank you.
<?php }else{ ?>
<br/>Please Check your email. Thank you.<br/><?php } ?>
<?php echo $OUTPUT->footer();	?>