<link rel="stylesheet" type="text/css" media="all" href="offlineexam/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="offlineexam/jquery.1.4.2.js"></script>
<script type="text/javascript" src="offlineexam/jsDatePick.jquery.min.1.3.js"></script>
<script type="text/javascript">
	$("tr").click(function(){
		$(this).addClass("selected").siblings().removeClass("selected");
	});
</script>
<style type="text/css">
#a table{ border-collapse: collapse; }
#a tr:hover, tr.selected {
    background-color: #FFCF8B
}

</style>
<table id="a">
    <tbody>
        <tr class="kl"><td class="adreef">content</td><td>content</td><td>content</td></tr>
        <tr><td>content</td><td>content</td><td>content</td></tr>
        <tr><td>content</td><td>content</td><td>content</td></tr>
        <tr><td>content</td><td>content</td><td>content</td></tr>
        <tr><td>content</td><td>content</td><td>content3</td></tr>
    </tbody>
</table>