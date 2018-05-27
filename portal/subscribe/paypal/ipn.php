<?php
require_once 'paypal.inc.php';

include('../../../manualdbconfig.php');

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

//$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";  

/*$paypaladdr = empty($CFG->usepaypalsandbox) ? 'www.paypal.com' : 'www.sandbox.paypal.com';
$fp = fsockopen ($paypaladdr, 80, $errno, $errstr, 30);*/


// assign posted variables to local variables
/*$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];*/


if (!$fp) {
	// HTTP ERROR
    echo "<p>Error: could not access paypal.com</p>";
	die;
} else {

	/// Connection is OK, so now we post the data to validate it
	fputs ($fp, $header . $req);

	/// Now read the response and check if everything is OK.
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
		
			// PAYMENT VALIDATED & VERIFIED!

			// check that the invoice has not been previously processed	
			$sql = "SELECT payment_status
					FROM mdl_cifa_modulesubscribe
					WHERE id = {$_POST['invoice']}";

			$result = mysql_query($sql);

			// if no invoice with such number is found, exit
			if (mysql_fetch_array($result) == 0) {
				exit;
			} else {
			
				$row = mysql_fetch_array($result);
				
				// process this order only if the status is still 'New'
				if ($row['payment_status'] != 'New') {
					exit;
				} else {

					// check that the buyer sent the right amount of money
					$sql = "SELECT cost
							FROM mdl_cifa_modulesubscribe
							WHERE id = {$_POST['invoice']}";
					$result = mysql_query($sql);
					$row    = mysql_fetch_array($result);		
					
					$total = $row['cost'];
								
					if ($_POST['payment_gross'] != $total) {
						exit;
					} else {
					   
						$invoice = $_POST['invoice'];
						$memo    = $_POST['memo'];
						if (!get_magic_quotes_gpc()) {
							$memo = addslashes($memo);
						}
						
						// ok, so this order looks perfectly okay
						// now we can update the order status to 'Paid'
						// update the memo too
						$sql = "UPDATE mdl_cifa_modulesubscribe
								SET payment_status = 'Paid', memo = '$memo', last_update = NOW()
								WHERE id = $invoice";
						$result = mysql_query($sql);
						
						//add by arizanabdullah***********************//
						if($result){
						
							//enrol user to course******************************************************************//
							$sqlOrder="
										Select
										  a.courseid,
										  a.email,
										  a.coursename,
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
										  (a.id = '$invoice' And
										  b.enrol = 'paypal')
										";
							$orderQuery=mysql_query($sqlOrder);
							$orderView=mysql_fetch_array($orderQuery);

							if($orderView['payment_status'] == 'Paid'){
								$courseid=$orderView['courseid']; //14
								$enrolid=$orderView['id']; //59
								$userid=$orderView['userid']; //4
								
								//enrol new user to mdl_cifauser_enrolments
								$sqlInsert=mysql_query("INSERT INTO mdl_cifauser_enrolments SET enrolid='$enrolid', userid='$userid'");
								if(!$sqlInsert){
									echo"Problem with your payment, please contact administration.";
								}
								else{
									include('../email-function.php');
								}
							}					
							//****************************************************************///
						
						}
					}
				}
			}
		}
		else if (strcmp ($res, "INVALID") == 0) {
			// PAYMENT INVALID & INVESTIGATE MANUALY!
			echo"invalid payment";

		}
	}
		fclose ($fp);
} else { 
	exit;
} 
?>