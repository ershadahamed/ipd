<?php
			$my['host'] = "localhost";
			$my['user'] = "moodle";
			$my['pass'] = "moodle";
			$my['database'] = "ipdonline";

			$conn = mysql_connect($my['host'], $my['user'], $my['pass']);

			if(!$conn)
			{
				echo"Tidak dapat sambung ke MYSQL.<br/>"; 
				mysql_error();
			}
			mysql_select_db($my['database']) or die("Tiada database".mysql_error());
	?>
