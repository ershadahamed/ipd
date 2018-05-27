		<script language="JavaScript" type="text/javascript">
		function validate(mform1) {
			var VAL = true;
			var license = document.mform1.license.value;
			var centreName = document.mform1.centreName.value;
			var address1 = document.mform1.address1.value;
			var city = document.mform1.city.value;
			var office = document.mform1.office.value;
			var fax = document.mform1.fax.value;
			var email=document.mform1.email2.value;
		
			if(!centreName)
			{
				VAL = false;
				alert('Fill the input box CENTRE NAME before submitting');
				mform1.centreName.focus();
				return false;
			}	

			if(!address1)
			{
				VAL = false;
				alert('Fill the input box Street Addres before submitting');
				mform1.address1.focus();
				return false;
			}		
			if(!city)
			{
				VAL = false;
				alert('Fill the input box CITY before submitting');
				mform1.city.focus();
				return false;
			}	
			if(!license)
			{
				VAL = false;
				alert('Fill the input box Centre Coordinator before submitting');
				mform1.license.focus();
				return false;
			}				
			if(!office)
			{
				VAL = false;
				alert('Fill the input box Centre Line before submitting');
				mform1.office.focus();
				return false;
			}	
			if(!fax)
			{
				VAL = false;
				alert('Fill the input box FAX Num. before submitting');
				mform1.fax.focus();
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
					mform1.email2.focus();
				return false;
				}
			}
		}    
		</script>