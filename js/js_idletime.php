<script type="text/javascript">
inactivityTimeout = False
resetTimeout()
function onUserInactivity() {
   //window.location.href = "onUserInactivity.php"
   window.location.href = "<?=$CFG->wwwroot;?>/login/logout.php?sesskey=<?=sesskey();?>"
   alert('<?=get_string('idletime');?>');   
}
function resetTimeout() {
   clearTimeout(inactivityTimeout)
   inactivityTimeout = setTimeout(onUserInactivity, 1000 * 900)
}
window.onmousemove = resetTimeout
</script>