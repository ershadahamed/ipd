<?php
// this page only process a POST from paypal website
// so make sure that the one requesting this page comes
// from paypal. we can do this by checking the remote address
// the IP must begin with 66.135.197.
if (strpos($_SERVER['REMOTE_ADDR'], '66.135.197.') === false) {
	echo"no files";
	exit;
}

require_once 'paypal.inc.php';

// repost the variables we get to paypal site
// for validation purpose

$result = fsockPost($paypal['url'], $_POST); 

//check the ipn result received back from paypal
if (eregi("VERIFIED", $result)) { 
	
        //require_once '../../library/config.php';
            
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
                
                //$subTotal = $row['subtotal'];
                //$total    = $subTotal + $shopConfig['shippingCost'];
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

						if($orderView['payment_status']=='Paid'){
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

} else { 
	exit;
} 


?>

