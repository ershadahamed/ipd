<?php
function get_value_of($name)
{
	$file='exam_software';
     //$lines = file($file);
	 $lines = file($file.'.txt');
     foreach (array_values($lines) AS $line)
     {
        list($key, $val) = explode('=', trim($line) );
        if (trim($key) == $name)
          {
            return $val;
          }
     }
     return false;
} 
	$quiz=get_value_of('quiz');
	$username=get_value_of('username');
	$grade=get_value_of('grade');
	$timemodified=get_value_of('timemodified');
	echo $quiz.'<br/>'.$username.'<br/>'.$grade.'<br/>'.$timemodified;
?>