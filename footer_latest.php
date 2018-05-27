		</div>
	</td>
	<td class="sidebar">
		<div style="height:100%; min-height: 630px; box-shadow: 0px 0px 10px #000; background-color:#fff;">
		<?php include_once('sidebar.php');?>
		<style type="text/css">
		#my1{
			width:100%; 
			/*border: 2px solid #3D91CB; */
			height: 160px;
		}

		.titlebox2{
			text-shadow: 1px 1px 2px #666; 
			background-color:#ccc; 
			border-bottom: 1px solid #DDD;
			width: 260px; 
			height: 25px; 
			vertical-align: middle;
			padding:5px;
			background:#ececec url('image/titleH.png') repeat-x;
			color:#000;
			font-weight: bolder;
		}
		</style>		
		<?php //if(($USER->id)!='2'){  ?>
			<!---Calendar---->
			<div style="padding:5px;">
			<table border="0" id="my1" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #DDD;border: 1px solid #ccc; margin-bottom: 1em;">
				<tr><td class="titlebox2">Calendar</td></tr>
				<tr>
				<td>
				
				</td>
				</tr>
			</table>
			</div>			
		
			<!----Contact us----->
			<div style="padding:5px;">
			<table border="0" id="my1" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #DDD;border: 1px solid #ccc; margin-bottom: 1em;">
				<tr><td class="titlebox2">Contact us</td></tr>
				<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0">
					<tr><td>
						<div style="padding: 8px;">
						Munther Tower 9th Floor<br/> Soor St. Sathiya 13159<br/> Kuwait City, Kuwait<br/>
						<br/>Tel: +965.2298.0599 <br/> Fax: +965.2245.1967</div>
					</td></tr>
					</table>
				</td>
				</tr>
			</table>
			</div>
		<?php
		if (isloggedin()) {
				add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
				if(($USER->id)!='2'){
		?>			
			<!---Download FAQ----->
			<div style="padding:5px 5px 0px 5px;">
			<table border="0" id="my1" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #DDD;border: 1px solid #ccc; margin-bottom: 1em;">
				<tr><td class="titlebox2">Download FAQ</td></tr>
				<tr>
				<td>
			
				</td>
				</tr>
			</table>
			</div>				
			
		<?php }} ?>
		</div>
	</td>
</tr>
</table>
<div style="clear:both;"></div>
</div>

<div id="footer">
            <?php //echo $OUTPUT->login_info();?>
			<strong>CIFA - Certified Islamic Financial Analyst Program<sup>TM</sup></strong><br/>
			Offered by SHAPE Financial Corp. and supported by Islamic Finance Training(IFT) Red Money Group<br/>
			SHAPE<sup>TM</sup> now offers a comprehensive there level certification program to develop financial service professionals with a deep and on-going knowlegde of Islamic finance. The elements of the program are meant to assure that users understand and retain the islamic rules applied to finance, banking and investment. The program addresses the global islamic financial markets.
</div> <?php //end wrapper ?> 

</div> <?php //end wrapper ?> 
</body>
</html>