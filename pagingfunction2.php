<?php

/**
 * @link: http://www.Awcore.com/dev
 */
 
   function pagination2($query, $per_page = 10,$page = 1, $url = '?'){        
    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
    	$row = mysql_fetch_array(mysql_query($query));
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination2 = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination2 .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination2.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination2.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination2.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination2.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination2.= "<li class='dot'>...</li>";
    				$pagination2.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination2.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination2.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination2.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination2.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination2.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination2.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination2.= "<li class='dot'>..</li>";
    				$pagination2.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination2.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination2.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination2.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination2.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination2.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination2.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination2.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination2.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination2.= "<li><a class='current'>Next</a></li>";
                $pagination2.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination2.= "</ul>\n";		
    	}
    
    
        return $pagination2;
    } 
?>    