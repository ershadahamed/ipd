		<script language="javascript">
		function displ()
		{
		  if(document.formcart.country.options[0].value == true) {
			return false
		  }
		  else {
			if(document.formcart.centrecode.value=document.formcart.country.options[document.formcart.country.selectedIndex].value){
				document.formcart.centrecode.value=document.formcart.country.options[document.formcart.country.selectedIndex].value+document.formcart.centrecode1.value;			
				
				//get value for country code
				if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AF'){
					document.formcart.countrycode.value='('+'+93'+')';
					document.formcart.centreline.value='+93'+document.formcart.office.value;					
					document.formcart.countrycode2.value='('+'+93'+')';
					document.formcart.faxnum.value='+93'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AL'){
					document.formcart.countrycode.value='('+'+355'+')';
					document.formcart.centreline.value='+355'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+355'+')';
					document.formcart.faxnum.value='+355'+document.formcart.fax.value;					
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='DZ'){
					document.formcart.countrycode.value='('+'+213'+')';
					document.formcart.centreline.value='+213'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+213'+')';
					document.formcart.faxnum.value='+213'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AS'){
					document.formcart.countrycode.value='('+'+1684'+')';
					document.formcart.centreline.value='+1684'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+93'+')';
					document.formcart.faxnum.value='+93'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AD'){
					document.formcart.countrycode.value='('+'+376'+')';
					document.formcart.centreline.value='+376'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+376'+')';
					document.formcart.faxnum.value='+376'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AO'){
					document.formcart.countrycode.value='('+'+244'+')';
					document.formcart.centreline.value='+244'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+244'+')';
					document.formcart.faxnum.value='+244'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AI'){
					document.formcart.countrycode.value='('+'+1264'+')';
					document.formcart.centreline.value='+1264'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1264'+')';
					document.formcart.faxnum.value='+1264'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AQ'){
					document.formcart.countrycode.value='('+'+672'+')';
					document.formcart.centreline.value='+672'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+672'+')';
					document.formcart.faxnum.value='+672'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AG'){
					document.formcart.countrycode.value='('+'+1268'+')';
					document.formcart.centreline.value='+1268'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1268'+')';
					document.formcart.faxnum.value='+1268'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AR'){
					document.formcart.countrycode.value='('+'+54'+')';
					document.formcart.centreline.value='+54'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+54'+')';
					document.formcart.faxnum.value='+54'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AM'){
					document.formcart.countrycode.value='('+'+374'+')';
					document.formcart.centreline.value='+374'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+374'+')';
					document.formcart.faxnum.value='+374'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AW'){
					document.formcart.countrycode.value='('+'+297'+')';
					document.formcart.centreline.value='+297'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+297'+')';
					document.formcart.faxnum.value='+297'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AU'){
					document.formcart.countrycode.value='('+'+61'+')';
					document.formcart.centreline.value='+61'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+61'+')';
					document.formcart.faxnum.value='+61'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AT'){
					document.formcart.countrycode.value='('+'+43'+')';
					document.formcart.centreline.value='+43'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+43'+')';
					document.formcart.faxnum.value='+43'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AZ'){
					document.formcart.countrycode.value='('+'+994'+')';
					document.formcart.centreline.value='+994'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+994'+')';
					document.formcart.faxnum.value='+994'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BS'){
					document.formcart.countrycode.value='('+'+1242'+')';
					document.formcart.centreline.value='+1242'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1242'+')';
					document.formcart.faxnum.value='+1242'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BH'){
					document.formcart.countrycode.value='('+'+973'+')';
					document.formcart.centreline.value='+973'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+973'+')';
					document.formcart.faxnum.value='+973'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BD'){
					document.formcart.countrycode.value='('+'+880'+')';
					document.formcart.centreline.value='+880'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+880'+')';
					document.formcart.faxnum.value='+880'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BB'){
					document.formcart.countrycode.value='('+'+1246'+')';
					document.formcart.centreline.value='+1246'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1246'+')';
					document.formcart.faxnum.value='+1246'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BY'){
					document.formcart.countrycode.value='('+'+375'+')';
					document.formcart.centreline.value='+375'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+375'+')';
					document.formcart.faxnum.value='+375'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BE'){
					document.formcart.countrycode.value='('+'+32'+')';
					document.formcart.centreline.value='+32'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+32'+')';
					document.formcart.faxnum.value='+32'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BZ'){
					document.formcart.countrycode.value='('+'+501'+')';
					document.formcart.centreline.value='+501'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+501'+')';
					document.formcart.faxnum.value='+501'+document.formcart.fax.value;
				}					
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BJ'){
					document.formcart.countrycode.value='('+'+229'+')';
					document.formcart.centreline.value='+229'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+229'+')';
					document.formcart.faxnum.value='+229'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BU'){
					document.formcart.countrycode.value='('+'+1441'+')';
					document.formcart.centreline.value='+1441'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1441'+')';
					document.formcart.faxnum.value='+1441'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BT'){
					document.formcart.countrycode.value='('+'+975'+')';
					document.formcart.centreline.value='+975'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+975'+')';
					document.formcart.faxnum.value='+975'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BO'){
					document.formcart.countrycode.value='('+'+591'+')';
					document.formcart.centreline.value='+591'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+591'+')';
					document.formcart.faxnum.value='+591'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BA'){
					document.formcart.countrycode.value='('+'+387'+')';
					document.formcart.centreline.value='+387'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+387'+')';
					document.formcart.faxnum.value='+387'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BW'){
					document.formcart.countrycode.value='('+'+267'+')';
					document.formcart.centreline.value='+267'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+267'+')';
					document.formcart.faxnum.value='+267'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BR'){
					document.formcart.countrycode.value='('+'+55'+')';
					document.formcart.centreline.value='+55'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+55'+')';
					document.formcart.faxnum.value='+55'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VG'){
					document.formcart.countrycode.value='('+'+1284'+')';
					document.formcart.centreline.value='+1284'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1284'+')';
					document.formcart.faxnum.value='+1284'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BN'){
					document.formcart.countrycode.value='('+'+673'+')';
					document.formcart.centreline.value='+673'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+673'+')';
					document.formcart.faxnum.value='+673'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BG'){
					document.formcart.countrycode.value='('+'+359'+')';
					document.formcart.centreline.value='+359'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+359'+')';
					document.formcart.faxnum.value='+359'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BF'){
					document.formcart.countrycode.value='('+'+226'+')';
					document.formcart.centreline.value='+226'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+226'+')';
					document.formcart.faxnum.value='+226'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MM'){
					document.formcart.countrycode.value='('+'+95'+')';
					document.formcart.centreline.value='+95'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+95'+')';
					document.formcart.faxnum.value='+95'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BI'){
					document.formcart.countrycode.value='('+'+257'+')';
					document.formcart.centreline.value='+257'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+257'+')';
					document.formcart.faxnum.value='+257'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KH'){
					document.formcart.countrycode.value='('+'+855'+')';
					document.formcart.centreline.value='+855'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+855'+')';
					document.formcart.faxnum.value='+855'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CM'){
					document.formcart.countrycode.value='('+'+237'+')';
					document.formcart.centreline.value='+237'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+237'+')';
					document.formcart.faxnum.value='+237'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CA'){
					document.formcart.countrycode.value='('+'+1'+')';
					document.formcart.centreline.value='+1'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1'+')';
					document.formcart.faxnum.value='+1'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CV'){
					document.formcart.countrycode.value='('+'+238'+')';
					document.formcart.centreline.value='+238'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+238'+')';
					document.formcart.faxnum.value='+238'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KY'){
					document.formcart.countrycode.value='('+'+1345'+')';
					document.formcart.centreline.value='+1345'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1345'+')';
					document.formcart.faxnum.value='+1345'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CF'){
					document.formcart.countrycode.value='('+'+236'+')';
					document.formcart.centreline.value='+236'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+236'+')';
					document.formcart.faxnum.value='+236'+document.formcart.fax.value;
				}
				
				
				
				
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TD'){
					document.formcart.countrycode.value='('+'+235'+')';
					document.formcart.centreline.value='+235'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+235'+')';
					document.formcart.faxnum.value='+235'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CL'){
					document.formcart.countrycode.value='('+'+56'+')';
					document.formcart.centreline.value='+56'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+56'+')';
					document.formcart.faxnum.value='+56'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CN'){
					document.formcart.countrycode.value='('+'+86'+')';
					document.formcart.centreline.value='+86'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+86'+')';
					document.formcart.faxnum.value='+86'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CX'){
					document.formcart.countrycode.value='('+'+61'+')';
					document.formcart.centreline.value='+61'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+61'+')';
					document.formcart.faxnum.value='+61'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CC'){
					document.formcart.countrycode.value='('+'+61'+')';
					document.formcart.centreline.value='+61'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+61'+')';
					document.formcart.faxnum.value='+61'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CO'){
					document.formcart.countrycode.value='('+'+57'+')';
					document.formcart.centreline.value='+57'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+57'+')';
					document.formcart.faxnum.value='+57'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KM'){
					document.formcart.countrycode.value='('+'+269'+')';
					document.formcart.centreline.value='+269'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+269'+')';
					document.formcart.faxnum.value='+269'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CK'){
					document.formcart.countrycode.value='('+'+682'+')';
					document.formcart.centreline.value='+682'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+682'+')';
					document.formcart.faxnum.value='+682'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CR'){
					document.formcart.countrycode.value='('+'+506'+')';
					document.formcart.centreline.value='+506'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+506'+')';
					document.formcart.faxnum.value='+506'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='HR'){
					document.formcart.countrycode.value='('+'+385'+')';
					document.formcart.centreline.value='+385'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+385'+')';
					document.formcart.faxnum.value='+385'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CU'){
					document.formcart.countrycode.value='('+'+53'+')';
					document.formcart.centreline.value='+53'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+53'+')';
					document.formcart.faxnum.value='+53'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CY'){
					document.formcart.countrycode.value='('+'+357'+')';
					document.formcart.centreline.value='+357'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+357'+')';
					document.formcart.faxnum.value='+357'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CZ'){
					document.formcart.countrycode.value='('+'+420'+')';
					document.formcart.centreline.value='+420'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+420'+')';
					document.formcart.faxnum.value='+420'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CD'){
					document.formcart.countrycode.value='('+'+243'+')';
					document.formcart.centreline.value='+243'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+243'+')';
					document.formcart.faxnum.value='+243'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='DK'){
					document.formcart.countrycode.value='('+'+45'+')';
					document.formcart.centreline.value='+45'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+45'+')';
					document.formcart.faxnum.value='+45'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='DJ'){
					document.formcart.countrycode.value='('+'+253'+')';
					document.formcart.centreline.value='+253'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+253'+')';
					document.formcart.faxnum.value='+253'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='DM'){
					document.formcart.countrycode.value='('+'+1767'+')';
					document.formcart.centreline.value='+1767'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1767'+')';
					document.formcart.faxnum.value='+1767'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='DO'){
					document.formcart.countrycode.value='('+'+1809'+')';
					document.formcart.centreline.value='+1809'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1809'+')';
					document.formcart.faxnum.value='+1809'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='EC'){
					document.formcart.countrycode.value='('+'+593'+')';
					document.formcart.centreline.value='+593'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+593'+')';
					document.formcart.faxnum.value='+593'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='EG'){
					document.formcart.countrycode.value='('+'+20'+')';
					document.formcart.centreline.value='+20'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+20'+')';
					document.formcart.faxnum.value='+20'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SV'){
					document.formcart.countrycode.value='('+'+503'+')';
					document.formcart.centreline.value='+503'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+503'+')';
					document.formcart.faxnum.value='+503'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GQ'){
					document.formcart.countrycode.value='('+'+240'+')';
					document.formcart.centreline.value='+240'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+240'+')';
					document.formcart.faxnum.value='+240'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ER'){
					document.formcart.countrycode.value='('+'+291'+')';
					document.formcart.centreline.value='+291'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+291'+')';
					document.formcart.faxnum.value='+291'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='EE'){
					document.formcart.countrycode.value='('+'+372'+')';
					document.formcart.centreline.value='+372'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+372'+')';
					document.formcart.faxnum.value='+372'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ET'){
					document.formcart.countrycode.value='('+'+251'+')';
					document.formcart.centreline.value='+251'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+251'+')';
					document.formcart.faxnum.value='+251'+document.formcart.fax.value;
				}					
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='FK'){
					document.formcart.countrycode.value='('+'+500'+')';
					document.formcart.centreline.value='+500'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+500'+')';
					document.formcart.faxnum.value='+500'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='FO'){
					document.formcart.countrycode.value='('+'+298'+')';
					document.formcart.centreline.value='+298'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+298'+')';
					document.formcart.faxnum.value='+298'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='FJ'){
					document.formcart.countrycode.value='('+'+679'+')';
					document.formcart.centreline.value='+679'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+679'+')';
					document.formcart.faxnum.value='+679'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='FI'){
					document.formcart.countrycode.value='('+'+358'+')';
					document.formcart.centreline.value='+358'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+358'+')';
					document.formcart.faxnum.value='+358'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='FR'){
					document.formcart.countrycode.value='('+'+33'+')';
					document.formcart.centreline.value='+33'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+33'+')';
					document.formcart.faxnum.value='+33'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PF'){
					document.formcart.countrycode.value='('+'+689'+')';
					document.formcart.centreline.value='+689'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+689'+')';
					document.formcart.faxnum.value='+689'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GA'){
					document.formcart.countrycode.value='('+'+241'+')';
					document.formcart.centreline.value='+241'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+241'+')';
					document.formcart.faxnum.value='+241'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GM'){
					document.formcart.countrycode.value='('+'+220'+')';
					document.formcart.centreline.value='+220'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+220'+')';
					document.formcart.faxnum.value='+220'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GE'){
					document.formcart.countrycode.value='('+'+995'+')';
					document.formcart.centreline.value='+995'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+995'+')';
					document.formcart.faxnum.value='+995'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='DE'){
					document.formcart.countrycode.value='('+'+49'+')';
					document.formcart.centreline.value='+49'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+49'+')';
					document.formcart.faxnum.value='+49'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GH'){
					document.formcart.countrycode.value='('+'+233'+')';
					document.formcart.centreline.value='+233'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+233'+')';
					document.formcart.faxnum.value='+233'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GI'){
					document.formcart.countrycode.value='('+'+350'+')';
					document.formcart.centreline.value='+350'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+350'+')';
					document.formcart.faxnum.value='+350'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GR'){
					document.formcart.countrycode.value='('+'+30'+')';
					document.formcart.centreline.value='+30'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+30'+')';
					document.formcart.faxnum.value='+30'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GL'){
					document.formcart.countrycode.value='('+'+299'+')';
					document.formcart.centreline.value='+299'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+299'+')';
					document.formcart.faxnum.value='+299'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GD'){
					document.formcart.countrycode.value='('+'+1473'+')';
					document.formcart.centreline.value='+1473'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1473'+')';
					document.formcart.faxnum.value='+1473'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GU'){
					document.formcart.countrycode.value='('+'+1671'+')';
					document.formcart.centreline.value='+1671'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1671'+')';
					document.formcart.faxnum.value='+1671'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GT'){
					document.formcart.countrycode.value='('+'+502'+')';
					document.formcart.centreline.value='+502'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+502'+')';
					document.formcart.faxnum.value='+502'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GN'){
					document.formcart.countrycode.value='('+'+224'+')';
					document.formcart.centreline.value='+224'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+224'+')';
					document.formcart.faxnum.value='+224'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GW'){
					document.formcart.countrycode.value='('+'+245'+')';
					document.formcart.centreline.value='+245'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+245'+')';
					document.formcart.faxnum.value='+245'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GY'){
					document.formcart.countrycode.value='('+'+592'+')';
					document.formcart.centreline.value='+592'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+592'+')';
					document.formcart.faxnum.value='+592'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='HT'){
					document.formcart.countrycode.value='('+'+509'+')';
					document.formcart.centreline.value='+509'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+509'+')';
					document.formcart.faxnum.value='+509'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VA'){
					document.formcart.countrycode.value='('+'+39'+')';
					document.formcart.centreline.value='+39'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+39'+')';
					document.formcart.faxnum.value='+39'+document.formcart.fax.value;
				}
							
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='HN'){
					document.formcart.countrycode.value='('+'+504'+')';
					document.formcart.centreline.value='+504'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+504'+')';
					document.formcart.faxnum.value='+504'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='HK'){
					document.formcart.countrycode.value='('+'+852'+')';
					document.formcart.centreline.value='+852'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+852'+')';
					document.formcart.faxnum.value='+852'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='HU'){
					document.formcart.countrycode.value='('+'+36'+')';
					document.formcart.centreline.value='+36'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+36'+')';
					document.formcart.faxnum.value='+36'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IS'){
					document.formcart.countrycode.value='('+'+354'+')';
					document.formcart.centreline.value='+354'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+354'+')';
					document.formcart.faxnum.value='+354'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IN'){
					document.formcart.countrycode.value='('+'+91'+')';
					document.formcart.centreline.value='+91'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+91'+')';
					document.formcart.faxnum.value='+91'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ID'){
					document.formcart.countrycode.value='('+'+62'+')';
					document.formcart.centreline.value='+62'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+62'+')';
					document.formcart.faxnum.value='+62'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IR'){
					document.formcart.countrycode.value='('+'+98'+')';
					document.formcart.centreline.value='+98'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+98'+')';
					document.formcart.faxnum.value='+98'+document.formcart.fax.value;
				}					
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IQ'){
					document.formcart.countrycode.value='('+'+964'+')';
					document.formcart.centreline.value='+964'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+964'+')';
					document.formcart.faxnum.value='+964'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IE'){
					document.formcart.countrycode.value='('+'+353'+')';
					document.formcart.centreline.value='+353'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+353'+')';
					document.formcart.faxnum.value='+353'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IM'){
					document.formcart.countrycode.value='('+'+44'+')';
					document.formcart.centreline.value='+44'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+44'+')';
					document.formcart.faxnum.value='+44'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IL'){
					document.formcart.countrycode.value='('+'+972'+')';
					document.formcart.centreline.value='+972'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+972'+')';
					document.formcart.faxnum.value='+972'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='IT'){
					document.formcart.countrycode.value='('+'+39'+')';
					document.formcart.centreline.value='+39'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+39'+')';
					document.formcart.faxnum.value='+39'+document.formcart.fax.value;
				}					
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CI'){
					document.formcart.countrycode.value='('+'+225'+')';
					document.formcart.centreline.value='+225'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+225'+')';
					document.formcart.faxnum.value='+225'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='JM'){
					document.formcart.countrycode.value='('+'+1876'+')';
					document.formcart.centreline.value='+1876'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1876'+')';
					document.formcart.faxnum.value='+1876'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='JP'){
					document.formcart.countrycode.value='('+'+81'+')';
					document.formcart.centreline.value='+81'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+81'+')';
					document.formcart.faxnum.value='+81'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='JE'){
					document.formcart.countrycode.value='('+'+81'+')';
					document.formcart.centreline.value='+81'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+81'+')';
					document.formcart.faxnum.value='+81'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='JO'){
					document.formcart.countrycode.value='('+'+962'+')';
					document.formcart.centreline.value='+962'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+962'+')';
					document.formcart.faxnum.value='+962'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KE'){
					document.formcart.countrycode.value='('+'+254'+')';
					document.formcart.centreline.value='+254'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+254'+')';
					document.formcart.faxnum.value='+254'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KZ'){
					document.formcart.countrycode.value='('+'+7'+')';
					document.formcart.centreline.value='+7'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+7'+')';
					document.formcart.faxnum.value='+7'+document.formcart.fax.value;
				}					
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KI'){
					document.formcart.countrycode.value='('+'+686'+')';
					document.formcart.centreline.value='+686'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+686'+')';
					document.formcart.faxnum.value='+686'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KW'){
					document.formcart.countrycode.value='('+'+965'+')';
					document.formcart.centreline.value='+965'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+965'+')';
					document.formcart.faxnum.value='+965'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KG'){
					document.formcart.countrycode.value='('+'+996'+')';
					document.formcart.centreline.value='+996'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+996'+')';
					document.formcart.faxnum.value='+996'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LA'){
					document.formcart.countrycode.value='('+'+856'+')';
					document.formcart.centreline.value='+856'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+856'+')';
					document.formcart.faxnum.value='+856'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LV'){
					document.formcart.countrycode.value='('+'+371'+')';
					document.formcart.centreline.value='+371'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+371'+')';
					document.formcart.faxnum.value='+371'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LB'){
					document.formcart.countrycode.value='('+'+961'+')';
					document.formcart.centreline.value='+961'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+961'+')';
					document.formcart.faxnum.value='+961'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LS'){
					document.formcart.countrycode.value='('+'+266'+')';
					document.formcart.centreline.value='+266'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+266'+')';
					document.formcart.faxnum.value='+266'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LR'){
					document.formcart.countrycode.value='('+'+231'+')';
					document.formcart.centreline.value='+231'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+231'+')';
					document.formcart.faxnum.value='+231'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LY'){
					document.formcart.countrycode.value='('+'+218'+')';
					document.formcart.centreline.value='+218'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+218'+')';
					document.formcart.faxnum.value='+218'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LI'){
					document.formcart.countrycode.value='('+'+423'+')';
					document.formcart.centreline.value='+423'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+423'+')';
					document.formcart.faxnum.value='+423'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LT'){
					document.formcart.countrycode.value='('+'+370'+')';
					document.formcart.centreline.value='+370'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+370'+')';
					document.formcart.faxnum.value='+370'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LU'){
					document.formcart.countrycode.value='('+'+352'+')';
					document.formcart.centreline.value='+352'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+352'+')';
					document.formcart.faxnum.value='+352'+document.formcart.fax.value;
				}				
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MO'){
					document.formcart.countrycode.value='('+'+853'+')';
					document.formcart.centreline.value='+853'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+853'+')';
					document.formcart.faxnum.value='+853'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MK'){
					document.formcart.countrycode.value='('+'+389'+')';
					document.formcart.centreline.value='+389'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+389'+')';
					document.formcart.faxnum.value='+389'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MG'){
					document.formcart.countrycode.value='('+'+261'+')';
					document.formcart.centreline.value='+261'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+261'+')';
					document.formcart.faxnum.value='+261'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MW'){
					document.formcart.countrycode.value='('+'+265'+')';
					document.formcart.centreline.value='+265'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+265'+')';
					document.formcart.faxnum.value='+265'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MY'){
					document.formcart.countrycode.value='('+'+60'+')';
					document.formcart.centreline.value='+60'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+60'+')';
					document.formcart.faxnum.value='+60'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MV'){
					document.formcart.countrycode.value='('+'+960'+')';
					document.formcart.centreline.value='+960'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+960'+')';
					document.formcart.faxnum.value='+960'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ML'){
					document.formcart.countrycode.value='('+'+223'+')';
					document.formcart.centreline.value='+223'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+223'+')';
					document.formcart.faxnum.value='+223'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MT'){
					document.formcart.countrycode.value='('+'+356'+')';
					document.formcart.centreline.value='+356'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+356'+')';
					document.formcart.faxnum.value='+356'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MH'){
					document.formcart.countrycode.value='('+'+692'+')';
					document.formcart.centreline.value='+692'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+692'+')';
					document.formcart.faxnum.value='+692'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MR'){
					document.formcart.countrycode.value='('+'+222'+')';
					document.formcart.centreline.value='+222'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+222'+')';
					document.formcart.faxnum.value='+222'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MU'){
					document.formcart.countrycode.value='('+'+230'+')';
					document.formcart.centreline.value='+230'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+230'+')';
					document.formcart.faxnum.value='+230'+document.formcart.fax.value;
				}
								
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='YT'){
					document.formcart.countrycode.value='('+'+262'+')';
					document.formcart.centreline.value='+262'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+262'+')';
					document.formcart.faxnum.value='+262'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MX'){
					document.formcart.countrycode.value='('+'+52'+')';
					document.formcart.centreline.value='+52'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+52'+')';
					document.formcart.faxnum.value='+52'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='FM'){
					document.formcart.countrycode.value='('+'+691'+')';
					document.formcart.centreline.value='+691'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+691'+')';
					document.formcart.faxnum.value='+691'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MD'){
					document.formcart.countrycode.value='('+'+373'+')';
					document.formcart.centreline.value='+373'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+373'+')';
					document.formcart.faxnum.value='+373'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MC'){
					document.formcart.countrycode.value='('+'+377'+')';
					document.formcart.centreline.value='+377'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+377'+')';
					document.formcart.faxnum.value='+377'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MN'){
					document.formcart.countrycode.value='('+'+976'+')';
					document.formcart.centreline.value='+976'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+976'+')';
					document.formcart.faxnum.value='+976'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ME'){
					document.formcart.countrycode.value='('+'+382'+')';
					document.formcart.centreline.value='+382'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+382'+')';
					document.formcart.faxnum.value='+382'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MS'){
					document.formcart.countrycode.value='('+'+1664'+')';
					document.formcart.centreline.value='+1664'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1664'+')';
					document.formcart.faxnum.value='+1664'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MA'){
					document.formcart.countrycode.value='('+'+212'+')';
					document.formcart.centreline.value='+212'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+212'+')';
					document.formcart.faxnum.value='+212'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MZ'){
					document.formcart.countrycode.value='('+'+258'+')';
					document.formcart.centreline.value='+258'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+258'+')';
					document.formcart.faxnum.value='+258'+document.formcart.fax.value;
				}					
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NA'){
					document.formcart.countrycode.value='('+'+264'+')';
					document.formcart.centreline.value='+264'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+264'+')';
					document.formcart.faxnum.value='+264'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NR'){
					document.formcart.countrycode.value='('+'+674'+')';
					document.formcart.centreline.value='+674'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+674'+')';
					document.formcart.faxnum.value='+674'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NP'){
					document.formcart.countrycode.value='('+'+977'+')';
					document.formcart.centreline.value='+977'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+977'+')';
					document.formcart.faxnum.value='+977'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NL'){
					document.formcart.countrycode.value='('+'+31'+')';
					document.formcart.centreline.value='+31'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+31'+')';
					document.formcart.faxnum.value='+31'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AN'){
					document.formcart.countrycode.value='('+'+599'+')';
					document.formcart.centreline.value='+599'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+599'+')';
					document.formcart.faxnum.value='+599'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NC'){
					document.formcart.countrycode.value='('+'+687'+')';
					document.formcart.centreline.value='+687'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+687'+')';
					document.formcart.faxnum.value='+687'+document.formcart.fax.value;
				}	
						
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NZ'){
					document.formcart.countrycode.value='('+'+64'+')';
					document.formcart.centreline.value='+64'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+64'+')';
					document.formcart.faxnum.value='+64'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NI'){
					document.formcart.countrycode.value='('+'+505'+')';
					document.formcart.centreline.value='+505'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+505'+')';
					document.formcart.faxnum.value='+505'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NE'){
					document.formcart.countrycode.value='('+'+227'+')';
					document.formcart.centreline.value='+227'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+227'+')';
					document.formcart.faxnum.value='+227'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NG'){
					document.formcart.countrycode.value='('+'+234'+')';
					document.formcart.centreline.value='+234'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+234'+')';
					document.formcart.faxnum.value='+234'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NU'){
					document.formcart.countrycode.value='('+'+683'+')';
					document.formcart.centreline.value='+683'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+683'+')';
					document.formcart.faxnum.value='+683'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KP'){
					document.formcart.countrycode.value='('+'+850'+')';
					document.formcart.centreline.value='+850'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+850'+')';
					document.formcart.faxnum.value='+850'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MP'){
					document.formcart.countrycode.value='('+'+1670'+')';
					document.formcart.centreline.value='+1670'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1670'+')';
					document.formcart.faxnum.value='+1670'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='NO'){
					document.formcart.countrycode.value='('+'+47'+')';
					document.formcart.centreline.value='+47'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+47'+')';
					document.formcart.faxnum.value='+47'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='OM'){
					document.formcart.countrycode.value='('+'+968'+')';
					document.formcart.centreline.value='+968'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+968'+')';
					document.formcart.faxnum.value='+968'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PK'){
					document.formcart.countrycode.value='('+'+92'+')';
					document.formcart.centreline.value='+213'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+92'+')';
					document.formcart.faxnum.value='+92'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PW'){
					document.formcart.countrycode.value='('+'+680'+')';
					document.formcart.centreline.value='+680'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+680'+')';
					document.formcart.faxnum.value='+680'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PA'){
					document.formcart.countrycode.value='('+'+507'+')';
					document.formcart.centreline.value='+507'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+507'+')';
					document.formcart.faxnum.value='+507'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PG'){
					document.formcart.countrycode.value='('+'+675'+')';
					document.formcart.centreline.value='+675'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+675'+')';
					document.formcart.faxnum.value='+675'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PY'){
					document.formcart.countrycode.value='('+'+595'+')';
					document.formcart.centreline.value='+595'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+595'+')';
					document.formcart.faxnum.value='+595'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PE'){
					document.formcart.countrycode.value='('+'+51'+')';
					document.formcart.centreline.value='+51'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+51'+')';
					document.formcart.faxnum.value='+51'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PH'){
					document.formcart.countrycode.value='('+'+63'+')';
					document.formcart.centreline.value='+63'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+63'+')';
					document.formcart.faxnum.value='+63'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PN'){
					document.formcart.countrycode.value='('+'+870'+')';
					document.formcart.centreline.value='+870'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+870'+')';
					document.formcart.faxnum.value='+870'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PL'){
					document.formcart.countrycode.value='('+'+48'+')';
					document.formcart.centreline.value='+48'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+48'+')';
					document.formcart.faxnum.value='+48'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PT'){
					document.formcart.countrycode.value='('+'+351'+')';
					document.formcart.centreline.value='+351'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+351'+')';
					document.formcart.faxnum.value='+351'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PR'){
					document.formcart.countrycode.value='('+'+1'+')';
					document.formcart.centreline.value='+1'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1'+')';
					document.formcart.faxnum.value='+1'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='QA'){
					document.formcart.countrycode.value='('+'+974'+')';
					document.formcart.centreline.value='+974'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+974'+')';
					document.formcart.faxnum.value='+974'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CG'){
					document.formcart.countrycode.value='('+'+242'+')';
					document.formcart.centreline.value='+242'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+242'+')';
					document.formcart.faxnum.value='+242'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='RO'){
					document.formcart.countrycode.value='('+'+40'+')';
					document.formcart.centreline.value='+40'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+40'+')';
					document.formcart.faxnum.value='+40'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='RU'){
					document.formcart.countrycode.value='('+'+7'+')';
					document.formcart.centreline.value='+7'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+7'+')';
					document.formcart.faxnum.value='+7'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='RW'){
					document.formcart.countrycode.value='('+'+250'+')';
					document.formcart.centreline.value='+250'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+250'+')';
					document.formcart.faxnum.value='+250'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='BL'){
					document.formcart.countrycode.value='('+'+590'+')';
					document.formcart.centreline.value='+590'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+590'+')';
					document.formcart.faxnum.value='+590'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SH'){
					document.formcart.countrycode.value='('+'+290'+')';
					document.formcart.centreline.value='+290'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+290'+')';
					document.formcart.faxnum.value='+290'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KN'){
					document.formcart.countrycode.value='('+'+1869'+')';
					document.formcart.centreline.value='+1869'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1869'+')';
					document.formcart.faxnum.value='+1869'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LC'){
					document.formcart.countrycode.value='('+'+1758'+')';
					document.formcart.centreline.value='+1758'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1758'+')';
					document.formcart.faxnum.value='+1758'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='MF'){
					document.formcart.countrycode.value='('+'+1599'+')';
					document.formcart.centreline.value='+1599'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1599'+')';
					document.formcart.faxnum.value='+1599'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='PM'){
					document.formcart.countrycode.value='('+'+508'+')';
					document.formcart.centreline.value='+508'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+508'+')';
					document.formcart.faxnum.value='+508'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VC'){
					document.formcart.countrycode.value='('+'+1784'+')';
					document.formcart.centreline.value='+1784'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1784'+')';
					document.formcart.faxnum.value='+1784'+document.formcart.fax.value;
				}						
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='WS'){
					document.formcart.countrycode.value='('+'+685'+')';
					document.formcart.centreline.value='+685'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+685'+')';
					document.formcart.faxnum.value='+685'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SM'){
					document.formcart.countrycode.value='('+'+378'+')';
					document.formcart.centreline.value='+378'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+378'+')';
					document.formcart.faxnum.value='+378'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ST'){
					document.formcart.countrycode.value='('+'+239'+')';
					document.formcart.centreline.value='+239'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+239'+')';
					document.formcart.faxnum.value='+239'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SA'){
					document.formcart.countrycode.value='('+'+966'+')';
					document.formcart.centreline.value='+966'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+966'+')';
					document.formcart.faxnum.value='+966'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SN'){
					document.formcart.countrycode.value='('+'+221'+')';
					document.formcart.centreline.value='+221'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+221'+')';
					document.formcart.faxnum.value='+221'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='RS'){
					document.formcart.countrycode.value='('+'+381'+')';
					document.formcart.centreline.value='+381'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+381'+')';
					document.formcart.faxnum.value='+381'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SC'){
					document.formcart.countrycode.value='('+'+248'+')';
					document.formcart.centreline.value='+248'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+248'+')';
					document.formcart.faxnum.value='+248'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SL'){
					document.formcart.countrycode.value='('+'+232'+')';
					document.formcart.centreline.value='+232'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+232'+')';
					document.formcart.faxnum.value='+232'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SG'){
					document.formcart.countrycode.value='('+'+65'+')';
					document.formcart.centreline.value='+65'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+65'+')';
					document.formcart.faxnum.value='+65'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SK'){
					document.formcart.countrycode.value='('+'+421'+')';
					document.formcart.centreline.value='+421'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+421'+')';
					document.formcart.faxnum.value='+421'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SI'){
					document.formcart.countrycode.value='('+'+386'+')';
					document.formcart.centreline.value='+386'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+386'+')';
					document.formcart.faxnum.value='+386'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SB'){
					document.formcart.countrycode.value='('+'+677'+')';
					document.formcart.centreline.value='+677'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+677'+')';
					document.formcart.faxnum.value='+677'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SO'){
					document.formcart.countrycode.value='('+'+252'+')';
					document.formcart.centreline.value='+252'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+252'+')';
					document.formcart.faxnum.value='+252'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ZA'){
					document.formcart.countrycode.value='('+'+27'+')';
					document.formcart.centreline.value='+27'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+27'+')';
					document.formcart.faxnum.value='+27'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='KR'){
					document.formcart.countrycode.value='('+'+82'+')';
					document.formcart.centreline.value='+82'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+82'+')';
					document.formcart.faxnum.value='+82'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ES'){
					document.formcart.countrycode.value='('+'+34'+')';
					document.formcart.centreline.value='+34'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+34'+')';
					document.formcart.faxnum.value='+34'+document.formcart.fax.value;
				}				

				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='LK'){
					document.formcart.countrycode.value='('+'+94'+')';
					document.formcart.centreline.value='+94'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+94'+')';
					document.formcart.faxnum.value='+94'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SD'){
					document.formcart.countrycode.value='('+'+249'+')';
					document.formcart.centreline.value='+249'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+249'+')';
					document.formcart.faxnum.value='+249'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SR'){
					document.formcart.countrycode.value='('+'+597'+')';
					document.formcart.centreline.value='+597'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+597'+')';
					document.formcart.faxnum.value='+597'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SJ'){
					document.formcart.countrycode.value='('+'+597'+')';
					document.formcart.centreline.value='+597'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+597'+')';
					document.formcart.faxnum.value='+597'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SZ'){
					document.formcart.countrycode.value='('+'+268'+')';
					document.formcart.centreline.value='+268'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+268'+')';
					document.formcart.faxnum.value='+268'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SE'){
					document.formcart.countrycode.value='('+'+46'+')';
					document.formcart.centreline.value='+46'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+46'+')';
					document.formcart.faxnum.value='+46'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='CH'){
					document.formcart.countrycode.value='('+'+41'+')';
					document.formcart.centreline.value='+41'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+41'+')';
					document.formcart.faxnum.value='+41'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='SY'){
					document.formcart.countrycode.value='('+'+963'+')';
					document.formcart.centreline.value='+963'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+963'+')';
					document.formcart.faxnum.value='+963'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TW'){
					document.formcart.countrycode.value='('+'+886'+')';
					document.formcart.centreline.value='+886'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+886'+')';
					document.formcart.faxnum.value='+886'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TJ'){
					document.formcart.countrycode.value='('+'+992'+')';
					document.formcart.centreline.value='+992'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+992'+')';
					document.formcart.faxnum.value='+992'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TZ'){
					document.formcart.countrycode.value='('+'+255'+')';
					document.formcart.centreline.value='+255'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+255'+')';
					document.formcart.faxnum.value='+255'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TH'){
					document.formcart.countrycode.value='('+'+66'+')';
					document.formcart.centreline.value='+66'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+66'+')';
					document.formcart.faxnum.value='+66'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TL'){
					document.formcart.countrycode.value='('+'+670'+')';
					document.formcart.centreline.value='+670'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+670'+')';
					document.formcart.faxnum.value='+670'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TG'){
					document.formcart.countrycode.value='('+'+228'+')';
					document.formcart.centreline.value='+228'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+228'+')';
					document.formcart.faxnum.value='+228'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TK'){
					document.formcart.countrycode.value='('+'+690'+')';
					document.formcart.centreline.value='+690'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+690'+')';
					document.formcart.faxnum.value='+690'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TO'){
					document.formcart.countrycode.value='('+'+676'+')';
					document.formcart.centreline.value='+676'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+676'+')';
					document.formcart.faxnum.value='+676'+document.formcart.fax.value;
				}	

				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TT'){
					document.formcart.countrycode.value='('+'+1868'+')';
					document.formcart.centreline.value='+1868'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1868'+')';
					document.formcart.faxnum.value='+1868'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TN'){
					document.formcart.countrycode.value='('+'+216'+')';
					document.formcart.centreline.value='+216'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+216'+')';
					document.formcart.faxnum.value='+216'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TR'){
					document.formcart.countrycode.value='('+'+90'+')';
					document.formcart.centreline.value='+90'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+90'+')';
					document.formcart.faxnum.value='+90'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TM'){
					document.formcart.countrycode.value='('+'+993'+')';
					document.formcart.centreline.value='+993'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+993'+')';
					document.formcart.faxnum.value='+993'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TC'){
					document.formcart.countrycode.value='('+'+1649'+')';
					document.formcart.centreline.value='+1649'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1649'+')';
					document.formcart.faxnum.value='+1649'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='TV'){
					document.formcart.countrycode.value='('+'+688'+')';
					document.formcart.centreline.value='+688'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+688'+')';
					document.formcart.faxnum.value='+688'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='UG'){
					document.formcart.countrycode.value='('+'+256'+')';
					document.formcart.centreline.value='+256'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+256'+')';
					document.formcart.faxnum.value='+256'+document.formcart.fax.value;
				}		
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='UA'){
					document.formcart.countrycode.value='('+'+380'+')';
					document.formcart.centreline.value='+380'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+380'+')';
					document.formcart.faxnum.value='+380'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='AE'){
					document.formcart.countrycode.value='('+'+971'+')';
					document.formcart.centreline.value='+971'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+971'+')';
					document.formcart.faxnum.value='+v'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='GB'){
					document.formcart.countrycode.value='('+'+44'+')';
					document.formcart.centreline.value='+44'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+44'+')';
					document.formcart.faxnum.value='+44'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='US'){
					document.formcart.countrycode.value='('+'+1'+')';
					document.formcart.centreline.value='+1'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1'+')';
					document.formcart.faxnum.value='+1'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='UY'){
					document.formcart.countrycode.value='('+'+598'+')';
					document.formcart.centreline.value='+598'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+598'+')';
					document.formcart.faxnum.value='+598'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VI'){
					document.formcart.countrycode.value='('+'+1340'+')';
					document.formcart.centreline.value='+1340'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+1340'+')';
					document.formcart.faxnum.value='+1340'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='UZ'){
					document.formcart.countrycode.value='('+'+998'+')';
					document.formcart.centreline.value='+998'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+998'+')';
					document.formcart.faxnum.value='+998'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VU'){
					document.formcart.countrycode.value='('+'+678'+')';
					document.formcart.centreline.value='+678'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+678'+')';
					document.formcart.faxnum.value='+678'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VE'){
					document.formcart.countrycode.value='('+'+58'+')';
					document.formcart.centreline.value='+58'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+58'+')';
					document.formcart.faxnum.value='+58'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='VN'){
					document.formcart.countrycode.value='('+'+84'+')';
					document.formcart.centreline.value='+84'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+84'+')';
					document.formcart.faxnum.value='+84'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='WF'){
					document.formcart.countrycode.value='('+'+681'+')';
					document.formcart.centreline.value='+681'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+681'+')';
					document.formcart.faxnum.value='+681'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='YE'){
					document.formcart.countrycode.value='('+'+967'+')';
					document.formcart.centreline.value='+967'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+967'+')';
					document.formcart.faxnum.value='+967'+document.formcart.fax.value;
				}
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ZM'){
					document.formcart.countrycode.value='('+'+260'+')';
					document.formcart.centreline.value='+260'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+260'+')';
					document.formcart.faxnum.value='+260'+document.formcart.fax.value;
				}	
				else if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='ZW'){
					document.formcart.countrycode.value='('+'+263'+')';
					document.formcart.centreline.value='+263'+document.formcart.office.value;
					document.formcart.countrycode2.value='('+'+263'+')';
					document.formcart.faxnum.value='+263'+document.formcart.fax.value;
				}									
			}
		  }
		  return true;
		}
		//-->
		</script>