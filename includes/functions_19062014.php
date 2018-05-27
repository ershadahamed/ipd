<?php
	function get_product_name($pid){
		//$result=mysql_query("select fullname from mdl_cifacourse where id=$pid") or die("select fullname from mdl_cifacourse where id=$pid"."<br/><br/>".mysql_error());
		
	$result=mysql_query("Select *, b.id as enrolid
    From
        mdl_cifacourse a,
        mdl_cifaenrol b
    Where
        a.id='".$pid."' AND
		a.id = b.courseid And
        (a.category = '1' And
        b.enrol = 'manual' And
        a.visible = '1' And
        b.status = '0')	") or die("select fullname from mdl_cifacourse where id=$pid"."<br/><br/>".mysql_error());;
		
		$row=mysql_fetch_array($result);
		return $row['fullname'];
	}
	function get_product_code($pid){
	$result=mysql_query("
	Select *, b.id as enrolid
    From
        mdl_cifacourse a,
        mdl_cifaenrol b
    Where
        a.id='".$pid."' AND
		a.id = b.courseid And
        (a.category = '1' And
        b.enrol = 'manual' And
        a.visible = '1' And
        b.status = '0')	") or die("select fullname from mdl_cifacourse where id=$pid"."<br/><br/>".mysql_error());;
		
		$row=mysql_fetch_array($result);
		return $row['shortname'];
	}	
	function get_price($pid){
		$result=mysql_query("Select *, b.id as enrolid
    From
        mdl_cifacourse a,
        mdl_cifaenrol b
    Where
        a.id='".$pid."' AND
		a.id = b.courseid And
        (a.category = '1' And
        b.enrol = 'manual' And
        a.visible = '1' And
        b.status = '0')	") or die("select fullname from mdl_cifacourse where id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['cost'];
	}
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	function get_order_total(){
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
			$price=get_price($pid);
			$sum+=$price*$q;
		}
		return $sum;
	}
	function addtocart($pid,$q){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['productid']=$pid;
			$_SESSION['cart'][$max]['qty']=$q;
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['productid']=$pid;
			$_SESSION['cart'][0]['qty']=$q;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}
?>