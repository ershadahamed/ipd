<?php
    require_once('config.php');
	include('manualdbconfig.php'); 
	include_once ('pagingfunction.php');
	include('function/emailfunction.php');
	
	
	//$s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE id='208' ORDER BY id DESC");
	// $s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE ((id='197') OR (id='198')  OR (id='199') OR (id='200') OR (id='201') OR (id='202') OR (id='203') OR (id='204') OR (id='205') OR (id='206')) AND deleted!='1' AND (country='AE') AND usertype='Active candidate' ORDER BY id DESC");
	// $s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE id='196'");
	$s=mysql_query("SELECT timecreated,firstaccess,orgtype,id, firstname, lastname, username, traineeid, country, email FROM mdl_cifauser WHERE deleted!='1' AND (country='AE' OR country='IQ') AND firstaccess='0' AND usertype='Active candidate' AND orgtype='7' ORDER BY firstaccess DESC");
	while($se=mysql_fetch_array($s)){
		echo $se['id'].' / '.$se['firstname'].' / '.$se['lastname'].' / '.$se['username'].' / '.$se['traineeid'].' / '.$se['country'];
		echo ' / '.$se['orgtype'];
		echo ' / '.date('d-m-Y', $se['firstaccess']);
		echo ' / '.date('d-m-Y', $se['timecreated']);
		
		if ($se['firstaccess']) {
               echo ' / '.$strlastaccess = format_time(time() - $se['firstaccess']);
            } else {
               echo ' / '.$strlastaccess = get_string('never');
            }
		echo "<br/>";
	}
?>