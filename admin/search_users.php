<?php
	$id=$_POST['searchusers'];
	if($id != ''){

			$sql="SELECT * FROM mdl_cifauser WHERE traineeid like '%$id%' OR firstname like '%$id%' OR lastname like '%$id%' OR city like '%$id%' OR country like '%$id%' OR usertype like '%$id%'";
			$query=mysql_query($sql, $conn) or die("Gagal SQL.".mysql_error());
			
			echo "<br/><br/>Result for <strong>" . ucwords(strtolower($id)) . "</strong> is: <br/><br/>";
			echo "<table width='95%' border='1'>";?>
				<tr bgcolor="#fff3bf">
					<th style="text-align:left">Name</td>
					<th style="text-align:left">Email Address</td>
					<th style="text-align:left">Trainee ID</td>
					<th style="text-align:left">User Type</td>
					<th style="text-align:left">City</td>
					<th style="text-align:left">Country</td>
				</tr>
			<?php
			while($papar=mysql_fetch_array($query))
			{
				?>
				<tr>
					<td><?php echo ucwords(strtolower($papar['firstname'] . '&nbsp;'. $papar['lastname'])); ?></td>
					<td><?php echo $papar['email']; ?></td>
					<td><?php echo $papar['traineeid']; ?></td>
					<td><?php echo $papar['usertype']; ?></td>
					<td><?php echo $papar['city']; ?></td>
					<td>
						<?php 
							$scountry=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$papar['country']."'");
							$country=mysql_fetch_array($scountry);
							echo $country['countryname']; 
						?>
					</td>
				</tr>
				<?php
			}
		echo '</table>';
	}else{
		echo "<br/><br/>";
		echo "Please fill the blank, before enter the button.";
	}
?>