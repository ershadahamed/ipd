<?php
/*    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php');

	function report_download_csv($fields, $data, $filename) {
		global $CFG;
		require_once($CFG->dirroot.'/user/profile/lib.php');

		$filename = clean_filename($filename.'-'.date('Y-m-d').'.csv');
		header("Content-Type: application/download\n");
		header("Content-Disposition: attachment; filename=$filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate,post-check=0,pre-check=0");
		header("Pragma: public");
		

		$row = array(); 
			$date_field = array('id');
			$totalrow = count($fields);
			$row[] = implode(',',$fields)."\n";

			foreach($data as $d){
				for($i=0;$i<$totalrow;$i++){
						$row_d[] = $d->$fields[$i];
				}
				$row[] = implode(',',$row_d);
				$row_d = array();
			}
			echo implode($row, "\n");
			
		die;
	}
?>

<?php
$list = array (
    array('aaa', 'bbb', 'ccc', 'dddd'),
    array('123', '456', '789'),
    array('"aaa"', '"bbb"')
);

$fields = array();

for ($k = 0;$k != ($num+1);$k++) {
	echo $fields[$k];
}

$filename='teester';
$filenamefull = clean_filename($filename.'-'.date('Ymd').'.csv');
//header('Content-type: text/csv');
header("Content-Type: application/download\n");
header("Content-Disposition: attachment;filename=$filenamefull");
header("Expires: 0");
header("Cache-Control: must-revalidate,post-check=0,pre-check=0");
header("Pragma: public");

// stream
$f  =   fopen('php://output', 'a');
foreach ($list as $fields) {
    fputcsv($f, $fields);
}
*/
?>

<?php
	require_once('config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php');

	$filename="ePay";
	//$csv_filename = $filename."_".date("Y-m-d_H-i",time()).".csv";
	$csv_filename = clean_filename($filename.'-'.date('Ymd').'.csv');

	header("Content-Type: application/vnd.ms-excel");

	$sql = "SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b WHERE a.userid = b.id AND a.userid='".$_GET['tokenid']."'";
	
	//$sql=mysql_query("SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b WHERE a.userid = b.id AND a.userid='".$_GET['tokenid']."'");
	//$rs=mysql_fetch_array($sql);
	//$tokenid=$rs['user_accesstoken'];
	//$username=$rs['username'];	

	$result=mysql_query($sql);

	if(mysql_num_rows($result)>0){

	$fileContent="Username,Firstname,Lastname,Email,Traineeid,Country,City,Courseid,Accesstoken\n";
		while($data=mysql_fetch_array($result))
		{
		$fileContent.= "".$data['traineeid'].",".$data['firstname'].",".$data['lastname'].",".$data['email']." ".$data['traineeid'].",".$data['country'].",".$data['city'].",".$data['courseid'].",".$data['user_accesstoken']."\n";
	}


	$fileContent=str_replace("\n\n","\n",$fileContent);
		echo $fileContent;
	}
	header("content-disposition: attachment;filename=$csv_filename"); 
?> 