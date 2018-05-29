<!--/* 
 * Author : Ershad Ahamed
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */-->

<table id="availablecourse2" width="100%">
    <?php
	if(is_array($_SESSION['cart'])){
            echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
                    <th width="1%" align="center">No.</th>
                    <th width="45%">Course Name</th>
                    <th width="10%" style="text-align:center;">Price</th>
                    <th width="10%" style="text-align:center;">Amount</th></tr>';
            
            $max=count($_SESSION['cart']);
            
            for($i=0;$i<$max;$i++){
                
                $pid=$_SESSION['cart'][$i]['productid'];
                
                $q=$_SESSION['cart'][$i]['qty']; // Quantitiy kot
                    
                $pname=get_product_name($pid);
                
                if($q==0) continue;
    ?>
                    <tr bgcolor="#FFFFFF">
                    				
                        <td class="adjacent" style="text-align:center;"><?php echo $i+1?></td>
                        <td class="adjacent" style="text-align:left;"><?php echo $pname?></td>
                        
                        <td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>
                        <td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
                    </tr>
    <?php					
            }
            
            if($max>0){
    ?>
                <tr style="height:30px;">
                    <td class="adjacent" colspan="2" width="70%">&nbsp;</td>
                    <td class="adjacent" style="text-align:center;"><b>Order Total</b></td>
                    <td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
                </tr>
    <?php
            }else{
                echo "<tr bgColor='#FFFFFF'><td class='adjacent' colspan='7'>There are no items in your shopping cart!</td>";
            }
	}
	else{
            echo "<tr bgColor='#FFFFFF'><td class='adjacent'>There are no items in your shopping cart!</td>";
        }
    ?>
</table>



