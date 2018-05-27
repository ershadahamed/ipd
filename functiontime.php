<?php
//add by arizan abdullah
		function unix_timestamp_to_human ($timestamp = "", /*$format = 'D d M Y - H:i:s'*/ $format = 'd-m-Y')
		{
			if (empty($timestamp) || ! is_numeric($timestamp)) $timestamp = time();
			return ($timestamp) ? date($format, $timestamp) : date($format, $timestamp);
		}
?>