<style type="text/css">
#my1{
	width:100%; 
	/*border: 2px solid #3D91CB; */
	height: 160px;
}
#tablecontent{
	margin-left:auto; 
	margin-right:auto; 
	padding:10px; 
	width:100%;
}
.titlebox{
	text-shadow: 1px 1px 2px #000; 
	background-color:#E8E8E8; 
	width: 260px; 
	height: 25px; 
	vertical-align: middle;
	padding:5px;
	background:url('image/btbg.png') repeat-x;
	color:#fff;
	font-weight: bolder;
	border-top-left-radius: 8px 8px;
}
#board-div{border: 1px solid #3D91CB; 	border-top-left-radius: 10px 10px;border-bottom-right-radius: 10px 10px;}
#mynoticeboard{
	width:100%; 
	/*border: 2px solid #3D91CB;*/
}
.mynoticeboard-content{ 
	height:200px;
	padding:10px;
}
.list{
	list-style: none; 
	padding: 10px; margin: 0;
}
a {
	cursor:pointer;
}
a:link {color:#3D91CB; text-decoration: none;}      /* unvisited link */
a:visited {color:#3D91CB;}  /* visited link */
a:hover {color:#ab381b; font-weight:bolder;}  /* mouse over link */
a:active {color:#3D91CB;}  /* selected link */

</style>

		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="4">
			<div id="board-div">
			<table border="0" id="mynoticeboard" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">Noticeboard</td></tr>
				<tr><td class="mynoticeboard-content">sdfsdfsd</td></tr>
			</table>	
			</div>			
			</td>
		</tr></table>
		<table border="0" id="tablecontent" cellpadding="0" cellspacing="0">
		<tr valign="bottom">
		<td style="padding-right:15px;">
			<div id="board-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My details</td></tr>
				<tr>	
					<td>
						<ul class="list">
							<li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">Personal detail</a></li>
							<li><a href="">Specialized study route</a></li>
							<li><a href="">Change security Q&A</a></li>
							<li><a href="<?php echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>">Change password</a></li>
							<li><a href="<?php echo $CFG->wwwroot.'/mod/chat/gui_ajax/index.php?id='.$USER->id; ?>">Communication preference</a></li>
						</ul>
					</td>
				</tr>
			</table>
			</div>
		</td>
		<td style="padding-right:15px;">
			<div id="board-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My studies</td></tr>
				<tr>
				<td>
						<ul class="list">
							<li><a href="<?php echo $CFG->wwwroot.'/coursesindex.php';?>">My modules</a></li>
							<li><a href="">Module record/result</a></li>
							<li><a href="">Continue my studies</a></li>
							<li><a href="<?php echo $CFG->wwwroot.'/purchasemodule.php?id='.$USER->id; ?>">Purchase a module</a></li>
							<li><a href="">Exam admission slip</a></li>
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>	
		<td style="padding-right:15px;">
			<div id="board-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">My financial</td></tr>
				<tr>
				<td>
						<ul class="list">
							<li><a href="">Financial statement</a></li>
							<li><a href="">Credit/debit card record</a></li>
							<li><a href="">Pay now</a></li>
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>
		<td>
			<div id="board-div">
			<table border="0" id="my1" cellpadding="0" cellspacing="0">
				<tr><td class="titlebox">Feedback & Review</td></tr>
				<tr>
				<td>
						<ul class="list">
							<li><a href="">Past exam Q&A</a></li>
							<li><a href="">Feedback on cifaonline.com</a></li>
							<li><a href="">Exam script review</a></li>
							<li><a href="">Online survey(Occasionally)</a></li>
						</ul>				
				</td>
				</tr>
			</table>
			</div>
		</td>			
		</tr>
		</table><br/>