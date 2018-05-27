<?php
	// you will need your database connection string here
	if(isset($_GET['delete']))
	{
		$query = 'DELETE FROM my_table WHERE item_id = '.(int)$_GET['delete'];
		$result = mysql_query($query,$link);
	}
?>