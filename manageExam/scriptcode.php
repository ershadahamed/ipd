		<script language="javascript">
		function displ()
		{
		  if(document.mform1.country.options[0].value == true) {
			return false
		  }
		  else {
			if(document.mform1.centrecode.value=document.mform1.country.options[document.mform1.country.selectedIndex].value){
				document.mform1.centrecode.value=document.mform1.country.options[document.mform1.country.selectedIndex].value+document.mform1.centrecode1.value;			
				
				//get value for country code
				if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AF'){
					document.mform1.countrycode.value='('+'+93'+')';
					document.mform1.centreline.value='+93'+document.mform1.office.value;					
					document.mform1.countrycode2.value='('+'+93'+')';
					document.mform1.faxnum.value='+93'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AL'){
					document.mform1.countrycode.value='('+'+355'+')';
					document.mform1.centreline.value='+355'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+355'+')';
					document.mform1.faxnum.value='+355'+document.mform1.fax.value;					
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='DZ'){
					document.mform1.countrycode.value='('+'+213'+')';
					document.mform1.centreline.value='+213'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+213'+')';
					document.mform1.faxnum.value='+213'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AS'){
					document.mform1.countrycode.value='('+'+1684'+')';
					document.mform1.centreline.value='+1684'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+93'+')';
					document.mform1.faxnum.value='+93'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AD'){
					document.mform1.countrycode.value='('+'+376'+')';
					document.mform1.centreline.value='+376'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+376'+')';
					document.mform1.faxnum.value='+376'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AO'){
					document.mform1.countrycode.value='('+'+244'+')';
					document.mform1.centreline.value='+244'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+244'+')';
					document.mform1.faxnum.value='+244'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AI'){
					document.mform1.countrycode.value='('+'+1264'+')';
					document.mform1.centreline.value='+1264'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1264'+')';
					document.mform1.faxnum.value='+1264'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AQ'){
					document.mform1.countrycode.value='('+'+672'+')';
					document.mform1.centreline.value='+672'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+672'+')';
					document.mform1.faxnum.value='+672'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AG'){
					document.mform1.countrycode.value='('+'+1268'+')';
					document.mform1.centreline.value='+1268'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1268'+')';
					document.mform1.faxnum.value='+1268'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AR'){
					document.mform1.countrycode.value='('+'+54'+')';
					document.mform1.centreline.value='+54'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+54'+')';
					document.mform1.faxnum.value='+54'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AM'){
					document.mform1.countrycode.value='('+'+374'+')';
					document.mform1.centreline.value='+374'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+374'+')';
					document.mform1.faxnum.value='+374'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AW'){
					document.mform1.countrycode.value='('+'+297'+')';
					document.mform1.centreline.value='+297'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+297'+')';
					document.mform1.faxnum.value='+297'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AU'){
					document.mform1.countrycode.value='('+'+61'+')';
					document.mform1.centreline.value='+61'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+61'+')';
					document.mform1.faxnum.value='+61'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AT'){
					document.mform1.countrycode.value='('+'+43'+')';
					document.mform1.centreline.value='+43'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+43'+')';
					document.mform1.faxnum.value='+43'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AZ'){
					document.mform1.countrycode.value='('+'+994'+')';
					document.mform1.centreline.value='+994'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+994'+')';
					document.mform1.faxnum.value='+994'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BS'){
					document.mform1.countrycode.value='('+'+1242'+')';
					document.mform1.centreline.value='+1242'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1242'+')';
					document.mform1.faxnum.value='+1242'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BH'){
					document.mform1.countrycode.value='('+'+973'+')';
					document.mform1.centreline.value='+973'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+973'+')';
					document.mform1.faxnum.value='+973'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BD'){
					document.mform1.countrycode.value='('+'+880'+')';
					document.mform1.centreline.value='+880'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+880'+')';
					document.mform1.faxnum.value='+880'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BB'){
					document.mform1.countrycode.value='('+'+1246'+')';
					document.mform1.centreline.value='+1246'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1246'+')';
					document.mform1.faxnum.value='+1246'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BY'){
					document.mform1.countrycode.value='('+'+375'+')';
					document.mform1.centreline.value='+375'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+375'+')';
					document.mform1.faxnum.value='+375'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BE'){
					document.mform1.countrycode.value='('+'+32'+')';
					document.mform1.centreline.value='+32'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+32'+')';
					document.mform1.faxnum.value='+32'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BZ'){
					document.mform1.countrycode.value='('+'+501'+')';
					document.mform1.centreline.value='+501'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+501'+')';
					document.mform1.faxnum.value='+501'+document.mform1.fax.value;
				}					
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BJ'){
					document.mform1.countrycode.value='('+'+229'+')';
					document.mform1.centreline.value='+229'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+229'+')';
					document.mform1.faxnum.value='+229'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BU'){
					document.mform1.countrycode.value='('+'+1441'+')';
					document.mform1.centreline.value='+1441'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1441'+')';
					document.mform1.faxnum.value='+1441'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BT'){
					document.mform1.countrycode.value='('+'+975'+')';
					document.mform1.centreline.value='+975'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+975'+')';
					document.mform1.faxnum.value='+975'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BO'){
					document.mform1.countrycode.value='('+'+591'+')';
					document.mform1.centreline.value='+591'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+591'+')';
					document.mform1.faxnum.value='+591'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BA'){
					document.mform1.countrycode.value='('+'+387'+')';
					document.mform1.centreline.value='+387'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+387'+')';
					document.mform1.faxnum.value='+387'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BW'){
					document.mform1.countrycode.value='('+'+267'+')';
					document.mform1.centreline.value='+267'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+267'+')';
					document.mform1.faxnum.value='+267'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BR'){
					document.mform1.countrycode.value='('+'+55'+')';
					document.mform1.centreline.value='+55'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+55'+')';
					document.mform1.faxnum.value='+55'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VG'){
					document.mform1.countrycode.value='('+'+1284'+')';
					document.mform1.centreline.value='+1284'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1284'+')';
					document.mform1.faxnum.value='+1284'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BN'){
					document.mform1.countrycode.value='('+'+673'+')';
					document.mform1.centreline.value='+673'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+673'+')';
					document.mform1.faxnum.value='+673'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BG'){
					document.mform1.countrycode.value='('+'+359'+')';
					document.mform1.centreline.value='+359'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+359'+')';
					document.mform1.faxnum.value='+359'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BF'){
					document.mform1.countrycode.value='('+'+226'+')';
					document.mform1.centreline.value='+226'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+226'+')';
					document.mform1.faxnum.value='+226'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MM'){
					document.mform1.countrycode.value='('+'+95'+')';
					document.mform1.centreline.value='+95'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+95'+')';
					document.mform1.faxnum.value='+95'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BI'){
					document.mform1.countrycode.value='('+'+257'+')';
					document.mform1.centreline.value='+257'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+257'+')';
					document.mform1.faxnum.value='+257'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KH'){
					document.mform1.countrycode.value='('+'+855'+')';
					document.mform1.centreline.value='+855'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+855'+')';
					document.mform1.faxnum.value='+855'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CM'){
					document.mform1.countrycode.value='('+'+237'+')';
					document.mform1.centreline.value='+237'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+237'+')';
					document.mform1.faxnum.value='+237'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CA'){
					document.mform1.countrycode.value='('+'+1'+')';
					document.mform1.centreline.value='+1'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1'+')';
					document.mform1.faxnum.value='+1'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CV'){
					document.mform1.countrycode.value='('+'+238'+')';
					document.mform1.centreline.value='+238'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+238'+')';
					document.mform1.faxnum.value='+238'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KY'){
					document.mform1.countrycode.value='('+'+1345'+')';
					document.mform1.centreline.value='+1345'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1345'+')';
					document.mform1.faxnum.value='+1345'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CF'){
					document.mform1.countrycode.value='('+'+236'+')';
					document.mform1.centreline.value='+236'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+236'+')';
					document.mform1.faxnum.value='+236'+document.mform1.fax.value;
				}
				
				
				
				
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TD'){
					document.mform1.countrycode.value='('+'+235'+')';
					document.mform1.centreline.value='+235'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+235'+')';
					document.mform1.faxnum.value='+235'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CL'){
					document.mform1.countrycode.value='('+'+56'+')';
					document.mform1.centreline.value='+56'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+56'+')';
					document.mform1.faxnum.value='+56'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CN'){
					document.mform1.countrycode.value='('+'+86'+')';
					document.mform1.centreline.value='+86'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+86'+')';
					document.mform1.faxnum.value='+86'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CX'){
					document.mform1.countrycode.value='('+'+61'+')';
					document.mform1.centreline.value='+61'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+61'+')';
					document.mform1.faxnum.value='+61'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CC'){
					document.mform1.countrycode.value='('+'+61'+')';
					document.mform1.centreline.value='+61'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+61'+')';
					document.mform1.faxnum.value='+61'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CO'){
					document.mform1.countrycode.value='('+'+57'+')';
					document.mform1.centreline.value='+57'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+57'+')';
					document.mform1.faxnum.value='+57'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KM'){
					document.mform1.countrycode.value='('+'+269'+')';
					document.mform1.centreline.value='+269'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+269'+')';
					document.mform1.faxnum.value='+269'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CK'){
					document.mform1.countrycode.value='('+'+682'+')';
					document.mform1.centreline.value='+682'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+682'+')';
					document.mform1.faxnum.value='+682'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CR'){
					document.mform1.countrycode.value='('+'+506'+')';
					document.mform1.centreline.value='+506'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+506'+')';
					document.mform1.faxnum.value='+506'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='HR'){
					document.mform1.countrycode.value='('+'+385'+')';
					document.mform1.centreline.value='+385'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+385'+')';
					document.mform1.faxnum.value='+385'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CU'){
					document.mform1.countrycode.value='('+'+53'+')';
					document.mform1.centreline.value='+53'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+53'+')';
					document.mform1.faxnum.value='+53'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CY'){
					document.mform1.countrycode.value='('+'+357'+')';
					document.mform1.centreline.value='+357'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+357'+')';
					document.mform1.faxnum.value='+357'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CZ'){
					document.mform1.countrycode.value='('+'+420'+')';
					document.mform1.centreline.value='+420'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+420'+')';
					document.mform1.faxnum.value='+420'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CD'){
					document.mform1.countrycode.value='('+'+243'+')';
					document.mform1.centreline.value='+243'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+243'+')';
					document.mform1.faxnum.value='+243'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='DK'){
					document.mform1.countrycode.value='('+'+45'+')';
					document.mform1.centreline.value='+45'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+45'+')';
					document.mform1.faxnum.value='+45'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='DJ'){
					document.mform1.countrycode.value='('+'+253'+')';
					document.mform1.centreline.value='+253'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+253'+')';
					document.mform1.faxnum.value='+253'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='DM'){
					document.mform1.countrycode.value='('+'+1767'+')';
					document.mform1.centreline.value='+1767'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1767'+')';
					document.mform1.faxnum.value='+1767'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='DO'){
					document.mform1.countrycode.value='('+'+1809'+')';
					document.mform1.centreline.value='+1809'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1809'+')';
					document.mform1.faxnum.value='+1809'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='EC'){
					document.mform1.countrycode.value='('+'+593'+')';
					document.mform1.centreline.value='+593'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+593'+')';
					document.mform1.faxnum.value='+593'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='EG'){
					document.mform1.countrycode.value='('+'+20'+')';
					document.mform1.centreline.value='+20'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+20'+')';
					document.mform1.faxnum.value='+20'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SV'){
					document.mform1.countrycode.value='('+'+503'+')';
					document.mform1.centreline.value='+503'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+503'+')';
					document.mform1.faxnum.value='+503'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GQ'){
					document.mform1.countrycode.value='('+'+240'+')';
					document.mform1.centreline.value='+240'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+240'+')';
					document.mform1.faxnum.value='+240'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ER'){
					document.mform1.countrycode.value='('+'+291'+')';
					document.mform1.centreline.value='+291'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+291'+')';
					document.mform1.faxnum.value='+291'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='EE'){
					document.mform1.countrycode.value='('+'+372'+')';
					document.mform1.centreline.value='+372'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+372'+')';
					document.mform1.faxnum.value='+372'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ET'){
					document.mform1.countrycode.value='('+'+251'+')';
					document.mform1.centreline.value='+251'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+251'+')';
					document.mform1.faxnum.value='+251'+document.mform1.fax.value;
				}					
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='FK'){
					document.mform1.countrycode.value='('+'+500'+')';
					document.mform1.centreline.value='+500'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+500'+')';
					document.mform1.faxnum.value='+500'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='FO'){
					document.mform1.countrycode.value='('+'+298'+')';
					document.mform1.centreline.value='+298'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+298'+')';
					document.mform1.faxnum.value='+298'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='FJ'){
					document.mform1.countrycode.value='('+'+679'+')';
					document.mform1.centreline.value='+679'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+679'+')';
					document.mform1.faxnum.value='+679'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='FI'){
					document.mform1.countrycode.value='('+'+358'+')';
					document.mform1.centreline.value='+358'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+358'+')';
					document.mform1.faxnum.value='+358'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='FR'){
					document.mform1.countrycode.value='('+'+33'+')';
					document.mform1.centreline.value='+33'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+33'+')';
					document.mform1.faxnum.value='+33'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PF'){
					document.mform1.countrycode.value='('+'+689'+')';
					document.mform1.centreline.value='+689'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+689'+')';
					document.mform1.faxnum.value='+689'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GA'){
					document.mform1.countrycode.value='('+'+241'+')';
					document.mform1.centreline.value='+241'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+241'+')';
					document.mform1.faxnum.value='+241'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GM'){
					document.mform1.countrycode.value='('+'+220'+')';
					document.mform1.centreline.value='+220'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+220'+')';
					document.mform1.faxnum.value='+220'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GE'){
					document.mform1.countrycode.value='('+'+995'+')';
					document.mform1.centreline.value='+995'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+995'+')';
					document.mform1.faxnum.value='+995'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='DE'){
					document.mform1.countrycode.value='('+'+49'+')';
					document.mform1.centreline.value='+49'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+49'+')';
					document.mform1.faxnum.value='+49'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GH'){
					document.mform1.countrycode.value='('+'+233'+')';
					document.mform1.centreline.value='+233'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+233'+')';
					document.mform1.faxnum.value='+233'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GI'){
					document.mform1.countrycode.value='('+'+350'+')';
					document.mform1.centreline.value='+350'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+350'+')';
					document.mform1.faxnum.value='+350'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GR'){
					document.mform1.countrycode.value='('+'+30'+')';
					document.mform1.centreline.value='+30'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+30'+')';
					document.mform1.faxnum.value='+30'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GL'){
					document.mform1.countrycode.value='('+'+299'+')';
					document.mform1.centreline.value='+299'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+299'+')';
					document.mform1.faxnum.value='+299'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GD'){
					document.mform1.countrycode.value='('+'+1473'+')';
					document.mform1.centreline.value='+1473'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1473'+')';
					document.mform1.faxnum.value='+1473'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GU'){
					document.mform1.countrycode.value='('+'+1671'+')';
					document.mform1.centreline.value='+1671'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1671'+')';
					document.mform1.faxnum.value='+1671'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GT'){
					document.mform1.countrycode.value='('+'+502'+')';
					document.mform1.centreline.value='+502'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+502'+')';
					document.mform1.faxnum.value='+502'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GN'){
					document.mform1.countrycode.value='('+'+224'+')';
					document.mform1.centreline.value='+224'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+224'+')';
					document.mform1.faxnum.value='+224'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GW'){
					document.mform1.countrycode.value='('+'+245'+')';
					document.mform1.centreline.value='+245'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+245'+')';
					document.mform1.faxnum.value='+245'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GY'){
					document.mform1.countrycode.value='('+'+592'+')';
					document.mform1.centreline.value='+592'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+592'+')';
					document.mform1.faxnum.value='+592'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='HT'){
					document.mform1.countrycode.value='('+'+509'+')';
					document.mform1.centreline.value='+509'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+509'+')';
					document.mform1.faxnum.value='+509'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VA'){
					document.mform1.countrycode.value='('+'+39'+')';
					document.mform1.centreline.value='+39'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+39'+')';
					document.mform1.faxnum.value='+39'+document.mform1.fax.value;
				}
							
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='HN'){
					document.mform1.countrycode.value='('+'+504'+')';
					document.mform1.centreline.value='+504'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+504'+')';
					document.mform1.faxnum.value='+504'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='HK'){
					document.mform1.countrycode.value='('+'+852'+')';
					document.mform1.centreline.value='+852'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+852'+')';
					document.mform1.faxnum.value='+852'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='HU'){
					document.mform1.countrycode.value='('+'+36'+')';
					document.mform1.centreline.value='+36'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+36'+')';
					document.mform1.faxnum.value='+36'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IS'){
					document.mform1.countrycode.value='('+'+354'+')';
					document.mform1.centreline.value='+354'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+354'+')';
					document.mform1.faxnum.value='+354'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IN'){
					document.mform1.countrycode.value='('+'+91'+')';
					document.mform1.centreline.value='+91'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+91'+')';
					document.mform1.faxnum.value='+91'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ID'){
					document.mform1.countrycode.value='('+'+62'+')';
					document.mform1.centreline.value='+62'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+62'+')';
					document.mform1.faxnum.value='+62'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IR'){
					document.mform1.countrycode.value='('+'+98'+')';
					document.mform1.centreline.value='+98'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+98'+')';
					document.mform1.faxnum.value='+98'+document.mform1.fax.value;
				}					
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IQ'){
					document.mform1.countrycode.value='('+'+964'+')';
					document.mform1.centreline.value='+964'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+964'+')';
					document.mform1.faxnum.value='+964'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IE'){
					document.mform1.countrycode.value='('+'+353'+')';
					document.mform1.centreline.value='+353'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+353'+')';
					document.mform1.faxnum.value='+353'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IM'){
					document.mform1.countrycode.value='('+'+44'+')';
					document.mform1.centreline.value='+44'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+44'+')';
					document.mform1.faxnum.value='+44'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IL'){
					document.mform1.countrycode.value='('+'+972'+')';
					document.mform1.centreline.value='+972'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+972'+')';
					document.mform1.faxnum.value='+972'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='IT'){
					document.mform1.countrycode.value='('+'+39'+')';
					document.mform1.centreline.value='+39'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+39'+')';
					document.mform1.faxnum.value='+39'+document.mform1.fax.value;
				}					
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CI'){
					document.mform1.countrycode.value='('+'+225'+')';
					document.mform1.centreline.value='+225'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+225'+')';
					document.mform1.faxnum.value='+225'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='JM'){
					document.mform1.countrycode.value='('+'+1876'+')';
					document.mform1.centreline.value='+1876'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1876'+')';
					document.mform1.faxnum.value='+1876'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='JP'){
					document.mform1.countrycode.value='('+'+81'+')';
					document.mform1.centreline.value='+81'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+81'+')';
					document.mform1.faxnum.value='+81'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='JE'){
					document.mform1.countrycode.value='('+'+81'+')';
					document.mform1.centreline.value='+81'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+81'+')';
					document.mform1.faxnum.value='+81'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='JO'){
					document.mform1.countrycode.value='('+'+962'+')';
					document.mform1.centreline.value='+962'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+962'+')';
					document.mform1.faxnum.value='+962'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KE'){
					document.mform1.countrycode.value='('+'+254'+')';
					document.mform1.centreline.value='+254'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+254'+')';
					document.mform1.faxnum.value='+254'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KZ'){
					document.mform1.countrycode.value='('+'+7'+')';
					document.mform1.centreline.value='+7'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+7'+')';
					document.mform1.faxnum.value='+7'+document.mform1.fax.value;
				}					
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KI'){
					document.mform1.countrycode.value='('+'+686'+')';
					document.mform1.centreline.value='+686'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+686'+')';
					document.mform1.faxnum.value='+686'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KW'){
					document.mform1.countrycode.value='('+'+965'+')';
					document.mform1.centreline.value='+965'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+965'+')';
					document.mform1.faxnum.value='+965'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KG'){
					document.mform1.countrycode.value='('+'+996'+')';
					document.mform1.centreline.value='+996'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+996'+')';
					document.mform1.faxnum.value='+996'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LA'){
					document.mform1.countrycode.value='('+'+856'+')';
					document.mform1.centreline.value='+856'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+856'+')';
					document.mform1.faxnum.value='+856'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LV'){
					document.mform1.countrycode.value='('+'+371'+')';
					document.mform1.centreline.value='+371'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+371'+')';
					document.mform1.faxnum.value='+371'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LB'){
					document.mform1.countrycode.value='('+'+961'+')';
					document.mform1.centreline.value='+961'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+961'+')';
					document.mform1.faxnum.value='+961'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LS'){
					document.mform1.countrycode.value='('+'+266'+')';
					document.mform1.centreline.value='+266'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+266'+')';
					document.mform1.faxnum.value='+266'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LR'){
					document.mform1.countrycode.value='('+'+231'+')';
					document.mform1.centreline.value='+231'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+231'+')';
					document.mform1.faxnum.value='+231'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LY'){
					document.mform1.countrycode.value='('+'+218'+')';
					document.mform1.centreline.value='+218'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+218'+')';
					document.mform1.faxnum.value='+218'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LI'){
					document.mform1.countrycode.value='('+'+423'+')';
					document.mform1.centreline.value='+423'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+423'+')';
					document.mform1.faxnum.value='+423'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LT'){
					document.mform1.countrycode.value='('+'+370'+')';
					document.mform1.centreline.value='+370'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+370'+')';
					document.mform1.faxnum.value='+370'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LU'){
					document.mform1.countrycode.value='('+'+352'+')';
					document.mform1.centreline.value='+352'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+352'+')';
					document.mform1.faxnum.value='+352'+document.mform1.fax.value;
				}				
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MO'){
					document.mform1.countrycode.value='('+'+853'+')';
					document.mform1.centreline.value='+853'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+853'+')';
					document.mform1.faxnum.value='+853'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MK'){
					document.mform1.countrycode.value='('+'+389'+')';
					document.mform1.centreline.value='+389'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+389'+')';
					document.mform1.faxnum.value='+389'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MG'){
					document.mform1.countrycode.value='('+'+261'+')';
					document.mform1.centreline.value='+261'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+261'+')';
					document.mform1.faxnum.value='+261'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MW'){
					document.mform1.countrycode.value='('+'+265'+')';
					document.mform1.centreline.value='+265'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+265'+')';
					document.mform1.faxnum.value='+265'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MY'){
					document.mform1.countrycode.value='('+'+60'+')';
					document.mform1.centreline.value='+60'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+60'+')';
					document.mform1.faxnum.value='+60'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MV'){
					document.mform1.countrycode.value='('+'+960'+')';
					document.mform1.centreline.value='+960'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+960'+')';
					document.mform1.faxnum.value='+960'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ML'){
					document.mform1.countrycode.value='('+'+223'+')';
					document.mform1.centreline.value='+223'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+223'+')';
					document.mform1.faxnum.value='+223'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MT'){
					document.mform1.countrycode.value='('+'+356'+')';
					document.mform1.centreline.value='+356'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+356'+')';
					document.mform1.faxnum.value='+356'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MH'){
					document.mform1.countrycode.value='('+'+692'+')';
					document.mform1.centreline.value='+692'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+692'+')';
					document.mform1.faxnum.value='+692'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MR'){
					document.mform1.countrycode.value='('+'+222'+')';
					document.mform1.centreline.value='+222'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+222'+')';
					document.mform1.faxnum.value='+222'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MU'){
					document.mform1.countrycode.value='('+'+230'+')';
					document.mform1.centreline.value='+230'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+230'+')';
					document.mform1.faxnum.value='+230'+document.mform1.fax.value;
				}
								
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='YT'){
					document.mform1.countrycode.value='('+'+262'+')';
					document.mform1.centreline.value='+262'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+262'+')';
					document.mform1.faxnum.value='+262'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MX'){
					document.mform1.countrycode.value='('+'+52'+')';
					document.mform1.centreline.value='+52'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+52'+')';
					document.mform1.faxnum.value='+52'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='FM'){
					document.mform1.countrycode.value='('+'+691'+')';
					document.mform1.centreline.value='+691'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+691'+')';
					document.mform1.faxnum.value='+691'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MD'){
					document.mform1.countrycode.value='('+'+373'+')';
					document.mform1.centreline.value='+373'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+373'+')';
					document.mform1.faxnum.value='+373'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MC'){
					document.mform1.countrycode.value='('+'+377'+')';
					document.mform1.centreline.value='+377'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+377'+')';
					document.mform1.faxnum.value='+377'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MN'){
					document.mform1.countrycode.value='('+'+976'+')';
					document.mform1.centreline.value='+976'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+976'+')';
					document.mform1.faxnum.value='+976'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ME'){
					document.mform1.countrycode.value='('+'+382'+')';
					document.mform1.centreline.value='+382'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+382'+')';
					document.mform1.faxnum.value='+382'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MS'){
					document.mform1.countrycode.value='('+'+1664'+')';
					document.mform1.centreline.value='+1664'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1664'+')';
					document.mform1.faxnum.value='+1664'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MA'){
					document.mform1.countrycode.value='('+'+212'+')';
					document.mform1.centreline.value='+212'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+212'+')';
					document.mform1.faxnum.value='+212'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MZ'){
					document.mform1.countrycode.value='('+'+258'+')';
					document.mform1.centreline.value='+258'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+258'+')';
					document.mform1.faxnum.value='+258'+document.mform1.fax.value;
				}					
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NA'){
					document.mform1.countrycode.value='('+'+264'+')';
					document.mform1.centreline.value='+264'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+264'+')';
					document.mform1.faxnum.value='+264'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NR'){
					document.mform1.countrycode.value='('+'+674'+')';
					document.mform1.centreline.value='+674'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+674'+')';
					document.mform1.faxnum.value='+674'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NP'){
					document.mform1.countrycode.value='('+'+977'+')';
					document.mform1.centreline.value='+977'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+977'+')';
					document.mform1.faxnum.value='+977'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NL'){
					document.mform1.countrycode.value='('+'+31'+')';
					document.mform1.centreline.value='+31'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+31'+')';
					document.mform1.faxnum.value='+31'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AN'){
					document.mform1.countrycode.value='('+'+599'+')';
					document.mform1.centreline.value='+599'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+599'+')';
					document.mform1.faxnum.value='+599'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NC'){
					document.mform1.countrycode.value='('+'+687'+')';
					document.mform1.centreline.value='+687'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+687'+')';
					document.mform1.faxnum.value='+687'+document.mform1.fax.value;
				}	
						
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NZ'){
					document.mform1.countrycode.value='('+'+64'+')';
					document.mform1.centreline.value='+64'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+64'+')';
					document.mform1.faxnum.value='+64'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NI'){
					document.mform1.countrycode.value='('+'+505'+')';
					document.mform1.centreline.value='+505'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+505'+')';
					document.mform1.faxnum.value='+505'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NE'){
					document.mform1.countrycode.value='('+'+227'+')';
					document.mform1.centreline.value='+227'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+227'+')';
					document.mform1.faxnum.value='+227'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NG'){
					document.mform1.countrycode.value='('+'+234'+')';
					document.mform1.centreline.value='+234'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+234'+')';
					document.mform1.faxnum.value='+234'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NU'){
					document.mform1.countrycode.value='('+'+683'+')';
					document.mform1.centreline.value='+683'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+683'+')';
					document.mform1.faxnum.value='+683'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KP'){
					document.mform1.countrycode.value='('+'+850'+')';
					document.mform1.centreline.value='+850'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+850'+')';
					document.mform1.faxnum.value='+850'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MP'){
					document.mform1.countrycode.value='('+'+1670'+')';
					document.mform1.centreline.value='+1670'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1670'+')';
					document.mform1.faxnum.value='+1670'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='NO'){
					document.mform1.countrycode.value='('+'+47'+')';
					document.mform1.centreline.value='+47'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+47'+')';
					document.mform1.faxnum.value='+47'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='OM'){
					document.mform1.countrycode.value='('+'+968'+')';
					document.mform1.centreline.value='+968'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+968'+')';
					document.mform1.faxnum.value='+968'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PK'){
					document.mform1.countrycode.value='('+'+92'+')';
					document.mform1.centreline.value='+213'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+92'+')';
					document.mform1.faxnum.value='+92'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PW'){
					document.mform1.countrycode.value='('+'+680'+')';
					document.mform1.centreline.value='+680'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+680'+')';
					document.mform1.faxnum.value='+680'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PA'){
					document.mform1.countrycode.value='('+'+507'+')';
					document.mform1.centreline.value='+507'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+507'+')';
					document.mform1.faxnum.value='+507'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PG'){
					document.mform1.countrycode.value='('+'+675'+')';
					document.mform1.centreline.value='+675'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+675'+')';
					document.mform1.faxnum.value='+675'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PY'){
					document.mform1.countrycode.value='('+'+595'+')';
					document.mform1.centreline.value='+595'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+595'+')';
					document.mform1.faxnum.value='+595'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PE'){
					document.mform1.countrycode.value='('+'+51'+')';
					document.mform1.centreline.value='+51'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+51'+')';
					document.mform1.faxnum.value='+51'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PH'){
					document.mform1.countrycode.value='('+'+63'+')';
					document.mform1.centreline.value='+63'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+63'+')';
					document.mform1.faxnum.value='+63'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PN'){
					document.mform1.countrycode.value='('+'+870'+')';
					document.mform1.centreline.value='+870'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+870'+')';
					document.mform1.faxnum.value='+870'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PL'){
					document.mform1.countrycode.value='('+'+48'+')';
					document.mform1.centreline.value='+48'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+48'+')';
					document.mform1.faxnum.value='+48'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PT'){
					document.mform1.countrycode.value='('+'+351'+')';
					document.mform1.centreline.value='+351'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+351'+')';
					document.mform1.faxnum.value='+351'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PR'){
					document.mform1.countrycode.value='('+'+1'+')';
					document.mform1.centreline.value='+1'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1'+')';
					document.mform1.faxnum.value='+1'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='QA'){
					document.mform1.countrycode.value='('+'+974'+')';
					document.mform1.centreline.value='+974'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+974'+')';
					document.mform1.faxnum.value='+974'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CG'){
					document.mform1.countrycode.value='('+'+242'+')';
					document.mform1.centreline.value='+242'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+242'+')';
					document.mform1.faxnum.value='+242'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='RO'){
					document.mform1.countrycode.value='('+'+40'+')';
					document.mform1.centreline.value='+40'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+40'+')';
					document.mform1.faxnum.value='+40'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='RU'){
					document.mform1.countrycode.value='('+'+7'+')';
					document.mform1.centreline.value='+7'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+7'+')';
					document.mform1.faxnum.value='+7'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='RW'){
					document.mform1.countrycode.value='('+'+250'+')';
					document.mform1.centreline.value='+250'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+250'+')';
					document.mform1.faxnum.value='+250'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='BL'){
					document.mform1.countrycode.value='('+'+590'+')';
					document.mform1.centreline.value='+590'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+590'+')';
					document.mform1.faxnum.value='+590'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SH'){
					document.mform1.countrycode.value='('+'+290'+')';
					document.mform1.centreline.value='+290'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+290'+')';
					document.mform1.faxnum.value='+290'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KN'){
					document.mform1.countrycode.value='('+'+1869'+')';
					document.mform1.centreline.value='+1869'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1869'+')';
					document.mform1.faxnum.value='+1869'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LC'){
					document.mform1.countrycode.value='('+'+1758'+')';
					document.mform1.centreline.value='+1758'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1758'+')';
					document.mform1.faxnum.value='+1758'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='MF'){
					document.mform1.countrycode.value='('+'+1599'+')';
					document.mform1.centreline.value='+1599'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1599'+')';
					document.mform1.faxnum.value='+1599'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='PM'){
					document.mform1.countrycode.value='('+'+508'+')';
					document.mform1.centreline.value='+508'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+508'+')';
					document.mform1.faxnum.value='+508'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VC'){
					document.mform1.countrycode.value='('+'+1784'+')';
					document.mform1.centreline.value='+1784'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1784'+')';
					document.mform1.faxnum.value='+1784'+document.mform1.fax.value;
				}						
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='WS'){
					document.mform1.countrycode.value='('+'+685'+')';
					document.mform1.centreline.value='+685'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+685'+')';
					document.mform1.faxnum.value='+685'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SM'){
					document.mform1.countrycode.value='('+'+378'+')';
					document.mform1.centreline.value='+378'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+378'+')';
					document.mform1.faxnum.value='+378'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ST'){
					document.mform1.countrycode.value='('+'+239'+')';
					document.mform1.centreline.value='+239'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+239'+')';
					document.mform1.faxnum.value='+239'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SA'){
					document.mform1.countrycode.value='('+'+966'+')';
					document.mform1.centreline.value='+966'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+966'+')';
					document.mform1.faxnum.value='+966'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SN'){
					document.mform1.countrycode.value='('+'+221'+')';
					document.mform1.centreline.value='+221'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+221'+')';
					document.mform1.faxnum.value='+221'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='RS'){
					document.mform1.countrycode.value='('+'+381'+')';
					document.mform1.centreline.value='+381'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+381'+')';
					document.mform1.faxnum.value='+381'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SC'){
					document.mform1.countrycode.value='('+'+248'+')';
					document.mform1.centreline.value='+248'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+248'+')';
					document.mform1.faxnum.value='+248'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SL'){
					document.mform1.countrycode.value='('+'+232'+')';
					document.mform1.centreline.value='+232'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+232'+')';
					document.mform1.faxnum.value='+232'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SG'){
					document.mform1.countrycode.value='('+'+65'+')';
					document.mform1.centreline.value='+65'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+65'+')';
					document.mform1.faxnum.value='+65'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SK'){
					document.mform1.countrycode.value='('+'+421'+')';
					document.mform1.centreline.value='+421'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+421'+')';
					document.mform1.faxnum.value='+421'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SI'){
					document.mform1.countrycode.value='('+'+386'+')';
					document.mform1.centreline.value='+386'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+386'+')';
					document.mform1.faxnum.value='+386'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SB'){
					document.mform1.countrycode.value='('+'+677'+')';
					document.mform1.centreline.value='+677'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+677'+')';
					document.mform1.faxnum.value='+677'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SO'){
					document.mform1.countrycode.value='('+'+252'+')';
					document.mform1.centreline.value='+252'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+252'+')';
					document.mform1.faxnum.value='+252'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ZA'){
					document.mform1.countrycode.value='('+'+27'+')';
					document.mform1.centreline.value='+27'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+27'+')';
					document.mform1.faxnum.value='+27'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='KR'){
					document.mform1.countrycode.value='('+'+82'+')';
					document.mform1.centreline.value='+82'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+82'+')';
					document.mform1.faxnum.value='+82'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ES'){
					document.mform1.countrycode.value='('+'+34'+')';
					document.mform1.centreline.value='+34'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+34'+')';
					document.mform1.faxnum.value='+34'+document.mform1.fax.value;
				}				

				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='LK'){
					document.mform1.countrycode.value='('+'+94'+')';
					document.mform1.centreline.value='+94'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+94'+')';
					document.mform1.faxnum.value='+94'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SD'){
					document.mform1.countrycode.value='('+'+249'+')';
					document.mform1.centreline.value='+249'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+249'+')';
					document.mform1.faxnum.value='+249'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SR'){
					document.mform1.countrycode.value='('+'+597'+')';
					document.mform1.centreline.value='+597'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+597'+')';
					document.mform1.faxnum.value='+597'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SJ'){
					document.mform1.countrycode.value='('+'+597'+')';
					document.mform1.centreline.value='+597'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+597'+')';
					document.mform1.faxnum.value='+597'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SZ'){
					document.mform1.countrycode.value='('+'+268'+')';
					document.mform1.centreline.value='+268'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+268'+')';
					document.mform1.faxnum.value='+268'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SE'){
					document.mform1.countrycode.value='('+'+46'+')';
					document.mform1.centreline.value='+46'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+46'+')';
					document.mform1.faxnum.value='+46'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='CH'){
					document.mform1.countrycode.value='('+'+41'+')';
					document.mform1.centreline.value='+41'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+41'+')';
					document.mform1.faxnum.value='+41'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='SY'){
					document.mform1.countrycode.value='('+'+963'+')';
					document.mform1.centreline.value='+963'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+963'+')';
					document.mform1.faxnum.value='+963'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TW'){
					document.mform1.countrycode.value='('+'+886'+')';
					document.mform1.centreline.value='+886'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+886'+')';
					document.mform1.faxnum.value='+886'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TJ'){
					document.mform1.countrycode.value='('+'+992'+')';
					document.mform1.centreline.value='+992'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+992'+')';
					document.mform1.faxnum.value='+992'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TZ'){
					document.mform1.countrycode.value='('+'+255'+')';
					document.mform1.centreline.value='+255'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+255'+')';
					document.mform1.faxnum.value='+255'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TH'){
					document.mform1.countrycode.value='('+'+66'+')';
					document.mform1.centreline.value='+66'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+66'+')';
					document.mform1.faxnum.value='+66'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TL'){
					document.mform1.countrycode.value='('+'+670'+')';
					document.mform1.centreline.value='+670'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+670'+')';
					document.mform1.faxnum.value='+670'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TG'){
					document.mform1.countrycode.value='('+'+228'+')';
					document.mform1.centreline.value='+228'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+228'+')';
					document.mform1.faxnum.value='+228'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TK'){
					document.mform1.countrycode.value='('+'+690'+')';
					document.mform1.centreline.value='+690'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+690'+')';
					document.mform1.faxnum.value='+690'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TO'){
					document.mform1.countrycode.value='('+'+676'+')';
					document.mform1.centreline.value='+676'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+676'+')';
					document.mform1.faxnum.value='+676'+document.mform1.fax.value;
				}	

				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TT'){
					document.mform1.countrycode.value='('+'+1868'+')';
					document.mform1.centreline.value='+1868'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1868'+')';
					document.mform1.faxnum.value='+1868'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TN'){
					document.mform1.countrycode.value='('+'+216'+')';
					document.mform1.centreline.value='+216'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+216'+')';
					document.mform1.faxnum.value='+216'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TR'){
					document.mform1.countrycode.value='('+'+90'+')';
					document.mform1.centreline.value='+90'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+90'+')';
					document.mform1.faxnum.value='+90'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TM'){
					document.mform1.countrycode.value='('+'+993'+')';
					document.mform1.centreline.value='+993'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+993'+')';
					document.mform1.faxnum.value='+993'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TC'){
					document.mform1.countrycode.value='('+'+1649'+')';
					document.mform1.centreline.value='+1649'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1649'+')';
					document.mform1.faxnum.value='+1649'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='TV'){
					document.mform1.countrycode.value='('+'+688'+')';
					document.mform1.centreline.value='+688'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+688'+')';
					document.mform1.faxnum.value='+688'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='UG'){
					document.mform1.countrycode.value='('+'+256'+')';
					document.mform1.centreline.value='+256'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+256'+')';
					document.mform1.faxnum.value='+256'+document.mform1.fax.value;
				}		
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='UA'){
					document.mform1.countrycode.value='('+'+380'+')';
					document.mform1.centreline.value='+380'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+380'+')';
					document.mform1.faxnum.value='+380'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='AE'){
					document.mform1.countrycode.value='('+'+971'+')';
					document.mform1.centreline.value='+971'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+971'+')';
					document.mform1.faxnum.value='+v'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='GB'){
					document.mform1.countrycode.value='('+'+44'+')';
					document.mform1.centreline.value='+44'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+44'+')';
					document.mform1.faxnum.value='+44'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='US'){
					document.mform1.countrycode.value='('+'+1'+')';
					document.mform1.centreline.value='+1'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1'+')';
					document.mform1.faxnum.value='+1'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='UY'){
					document.mform1.countrycode.value='('+'+598'+')';
					document.mform1.centreline.value='+598'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+598'+')';
					document.mform1.faxnum.value='+598'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VI'){
					document.mform1.countrycode.value='('+'+1340'+')';
					document.mform1.centreline.value='+1340'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+1340'+')';
					document.mform1.faxnum.value='+1340'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='UZ'){
					document.mform1.countrycode.value='('+'+998'+')';
					document.mform1.centreline.value='+998'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+998'+')';
					document.mform1.faxnum.value='+998'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VU'){
					document.mform1.countrycode.value='('+'+678'+')';
					document.mform1.centreline.value='+678'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+678'+')';
					document.mform1.faxnum.value='+678'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VE'){
					document.mform1.countrycode.value='('+'+58'+')';
					document.mform1.centreline.value='+58'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+58'+')';
					document.mform1.faxnum.value='+58'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='VN'){
					document.mform1.countrycode.value='('+'+84'+')';
					document.mform1.centreline.value='+84'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+84'+')';
					document.mform1.faxnum.value='+84'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='WF'){
					document.mform1.countrycode.value='('+'+681'+')';
					document.mform1.centreline.value='+681'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+681'+')';
					document.mform1.faxnum.value='+681'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='YE'){
					document.mform1.countrycode.value='('+'+967'+')';
					document.mform1.centreline.value='+967'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+967'+')';
					document.mform1.faxnum.value='+967'+document.mform1.fax.value;
				}
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ZM'){
					document.mform1.countrycode.value='('+'+260'+')';
					document.mform1.centreline.value='+260'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+260'+')';
					document.mform1.faxnum.value='+260'+document.mform1.fax.value;
				}	
				else if(document.mform1.country.options[document.mform1.country.selectedIndex].value=='ZW'){
					document.mform1.countrycode.value='('+'+263'+')';
					document.mform1.centreline.value='+263'+document.mform1.office.value;
					document.mform1.countrycode2.value='('+'+263'+')';
					document.mform1.faxnum.value='+263'+document.mform1.fax.value;
				}									
			}
		  }
		  return true;
		}
		//-->
		</script>