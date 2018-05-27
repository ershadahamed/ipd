<script language="JavaScript" type="text/javascript">
function validate2(mform) {
	var VAL = true;
	var license = document.mform.license.value;
	var centreName = document.mform.centreName.value;
	var address1 = document.mform.address1.value;
	var state = document.mform.state.value;
	var city = document.mform.city.value;
	var zip = document.mform.zip.value;
	var office = document.mform.office.value;
	var fax = document.mform.fax.value;
	var email=document.mform.email2.value;
	
	if(!license)
	{
		VAL = false;
		alert('Fill the input box LICENSE NO. before submitting');
		mform.license.focus();
		return false;
	}	
	
	if(!centreName)
	{
		VAL = false;
		alert('Fill the input box CENTRE NAME before submitting');
		mform.centreName.focus();
		return false;
	}	

	if(!address1)
	{
		VAL = false;
		alert('Fill the input box ADDRESS before submitting');
		mform.address1.focus();
		return false;
	}	

	if(!state)
	{
		VAL = false;
		alert('Fill the input box STATE before submitting');
		mform.state.focus();
		return false;
	}	
	if(!city)
	{
		VAL = false;
		alert('Fill the input box CITY before submitting');
		mform.city.focus();
		return false;
	}	
	if(!zip)
	{
		VAL = false;
		alert('Fill the input box ZIP CODE before submitting');
		mform.zip.focus();
		return false;
	}	
	if(!office)
	{
		VAL = false;
		alert('Fill the input box OFFICE before submitting');
		mform.office.focus();
		return false;
	}	
	if(!fax)
	{
		VAL = false;
		alert('Fill the input box FAX before submitting');
		mform.fax.focus();
		return false;
	}	
	if(!email){
		VAL = false;
		if (email.indexOf(' ')==-1 
			&& 0<email.indexOf('@')
			&& email.indexOf('@')+1 < email.length
		) return true;
		else {
			alert ('Invalid email address!')
			mform.email2.focus();
		return false;
		}
	}
} 
</script>