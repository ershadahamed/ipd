<?php

	/*$sqlAll=mysql_query("Select * From mdl_cifa_modulesubscribe Order by DESC");	
	$result_query=mysql_fetch_array($sqlAll);*/
	
	//$invoice=$subscribeid;
	$invoice='8';
	$memo = 'none';
	
						// ok, so this order looks perfectly okay
						// now we can update the order status to 'Paid'
						// update the memo too
						$sql = "UPDATE mdl_cifa_modulesubscribe
								SET payment_status = 'Paid', memo = '$memo', last_update = NOW()
								WHERE id = '$invoice'";
						$result = mysql_query($sql);
						
						//add by arizanabdullah***********************//
						if($result){
						
							//enrol user to course******************************************************************//
							$sqlOrder="
										Select
										  a.courseid,
										  a.email,
										  a.coursename,
										  a.payment_status,
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

?>