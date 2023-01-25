@extends('layouts.submit_profile_layouts')
@section('profileContent')
<style>
   
    #contact_select {
      
       
        background: #FFF;
      
      `
        color: #aaa;
    }

    #contact label {
        color: #000;
        font-size: 17px;
        font-family: "Roboto", Helvetica, Arial, sans-serif;
        font-weight: 500;
    }
</style>
<br />
<br />
<section class="container">
	<div class="container">
		<!-- [ Main Content ] start -->
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-8">
				<h3 class="text-center" style="color:red;"><b>Submit Profile</b></h3>
				<div class="card">
					<div class="card-header">
						<h1 class="text-center" style="color:red;">ACTOR PROFILE</h1>
					</div>
					<div class="card-body">


						<form>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1"><b>Name</b>&nbsp;<span
												style="color:red;">*</span></label>
										<input type="email" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="Enter email">

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1"><b>Date Of
												Birth</b>&nbsp;<span style="color:red;">*</span></label>
										<input type="date" style="color:red;" class="form-control"
											id="exampleInputPassword1" placeholder="Enter date of birth">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label" for="ethnicity"><b>Ethnicity</b>&nbsp;<span
												style="color:red;">*</span></label>
										<select name="ethnicity" class="form-control" id="ethnicity">
											<option value="" style="color:red;">Please Select</option>

											<option value="Andhra Pradesh" style="color:red;">Andhra Pradesh</option>
											<option value="Andaman &amp; Nicobar" style="color:red;">Andaman &amp; Nicobar </option>
											<option value="Arunachal Pradesh" style="color:red;">Arunachal Pradesh</option>
											<option value="Assam" style="color:red;">Assam</option>
											<option value="Bihar" style="color:red;">Bihar</option>
											<option value="Chandigarh" style="color:red;">Chandigarh</option>
											<option value="Chhattisgarh" style="color:red;">Chhattisgarh</option>
											<option value="Dadar &amp; Nagar Haveli" style="color:red;">Dadar &amp; Nagar Haveli
											</option>
											<option value="Daman &amp; Diu" style="color:red;">Daman &amp; Diu</option>
											<option value="Delhi" style="color:red;">Delhi</option>
											<option value="Lakshadweep" style="color:red;">Lakshadweep</option>
											<option value="Puducherry" style="color:red;">Puducherry</option>
											<option value="Goa" style="color:red;">Goa</option>
											<option value="Gujarat" style="color:red;">Gujarat</option>
											<option value="Haryana" style="color:red;">Haryana</option>
											<option value="Himachal Pradesh" style="color:red;">Himachal Pradesh</option>
											<option value="Jammu &amp; Kashmir" style="color:red;">Jammu &amp; Kashmir</option>
											<option value="Jharkhand" style="color:red;">Jharkhand</option>
											<option value="Karnataka" style="color:red;">Karnataka</option>
											<option value="Kerala" style="color:red;">Kerala</option>
											<option value="Madhya Pradesh" style="color:red;">Madhya Pradesh</option>
											<option value="Maharashtra" style="color:red;">Maharashtra</option>
											<option value="Manipur" style="color:red;">Manipur</option>
											<option value="Meghalaya" style="color:red;">Meghalaya</option>
											<option value="Mizoram" style="color:red;">Mizoram</option>
											<option value="Nagaland" style="color:red;">Nagaland</option>
											<option value="Odisha" style="color:red;">Odisha</option>
											<option value="Other" style="color:red;">Other</option>
											<option value="Punjab" style="color:red;">Punjab</option>
											<option value="Rajasthan" style="color:red;">Rajasthan</option>
											<option value="Sikkim" style="color:red;">Sikkim</option>
											<option value="Tamil Nadu" style="color:red;">Tamil Nadu</option>
											<option value="Telangana" style="color:red;">Telangana</option>
											<option value="Tripura" style="color:red;">Tripura</option>
											<option value="Uttar Pradesh" style="color:red;">Uttar Pradesh</option>
											<option value="Uttarakhand" style="color:red;">Uttarakhand</option>
											<option value="West Bengal" style="color:red;">West Bengal</option>
										</select>

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label" for="gender"><b>Gender
											</b>&nbsp;<span style="color:red;">*</span></label>
										<select name="gender" class="form-control" id="">
											<option value="" style="color:red;">Please Select</option>
											<option value="male" style="color:red;">Male</option>
											<option value="female" style="color:red;">Female</option>
											<option value="prefernottosay" style="color:red;">Prefer not to say</option>
										</select>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label class="form-label" id="contact"><b>Contact
										</b><span style="color:red;">*</span>
									</label>
									<div class="input-group mb-3">
										<select name="" id="contact_select" class="form-control"
											style="width:30%">
											<option data-countrycode="IN" value="91" selected="" style="color:red;">India
												(+91)</option>
											<option data-countrycode="GB" value="44" style="color:red;">UK (+44)</option>
											<option data-countrycode="US" value="1" style="color:red;">USA (+1)</option>
											<optgroup style="color:red;" label="Other countries">
												<option data-countrycode="DZ" value="213" style="color:red;">Algeria (+213)
												</option>
												<option data-countrycode="AD" value="376" style="color:red;">Andorra (+376)
												</option>
												<option data-countrycode="AO" value="244" style="color:red;">Angola (+244)
												</option>
												<option data-countrycode="AI" value="1264" style="color:red;">Anguilla (+1264)
												</option>
												<option data-countrycode="AG" value="1268" style="color:red;">Antigua &amp; Barbuda
													(+1268)</option>
												<option data-countrycode="AR" value="54" style="color:red;">Argentina (+54)
												</option>
												<option data-countrycode="AM" value="374" style="color:red;">Armenia (+374)
												</option>
												<option data-countrycode="AW" value="297" style="color:red;">Aruba (+297)</option>
												<option data-countrycode="AU" value="61" style="color:red;">Australia (+61)
												</option>
												<option data-countrycode="AT" value="43" style="color:red;">Austria (+43)
												</option>
												<option data-countrycode="AZ" value="994" style="color:red;">Azerbaijan (+994)
												</option>
												<option data-countrycode="BS" value="1242" style="color:red;">Bahamas (+1242)
												</option>
												<option data-countrycode="BH" value="973" style="color:red;">Bahrain (+973)
												</option>
												<option data-countrycode="BD" value="880" style="color:red;">Bangladesh (+880)
												</option>
												<option data-countrycode="BB" value="1246" style="color:red;">Barbados (+1246)
												</option>
												<option data-countrycode="BY" value="375" style="color:red;">Belarus (+375)
												</option>
												<option data-countrycode="BE" value="32" style="color:red;">Belgium (+32)
												</option>
												<option data-countrycode="BZ" value="501" style="color:red;">Belize (+501)
												</option>
												<option data-countrycode="BJ" value="229" style="color:red;">Benin (+229)</option>
												<option data-countrycode="BM" value="1441" style="color:red;">Bermuda (+1441)
												</option>
												<option data-countrycode="BT" value="975" style="color:red;">Bhutan (+975)
												</option>
												<option data-countrycode="BO" value="591" style="color:red;">Bolivia (+591)
												</option>
												<option data-countrycode="BA" value="387" style="color:red;">Bosnia Herzegovina
													(+387)</option>
												<option data-countrycode="BW" value="267" style="color:red;">Botswana (+267)
												</option>
												<option data-countrycode="BR" value="55" style="color:red;">Brazil (+55)</option>
												<option data-countrycode="BN" value="673" style="color:red;">Brunei (+673)
												</option>
												<option data-countrycode="BG" value="359" style="color:red;">Bulgaria (+359)
												</option>
												<option data-countrycode="BF" value="226" style="color:red;">Burkina Faso (+226)
												</option>
												<option data-countrycode="BI" value="257" style="color:red;">Burundi (+257)
												</option>
												<option data-countrycode="KH" value="855" style="color:red;">Cambodia (+855)
												</option>
												<option data-countrycode="CM" value="237" style="color:red;">Cameroon (+237)
												</option>
												<option data-countrycode="CA" value="1" style="color:red;">Canada (+1)</option>
												<option data-countrycode="CV" value="238" style="color:red;">Cape Verde Islands
													(+238)</option>
												<option data-countrycode="KY" value="1345" style="color:red;">Cayman Islands
													(+1345)</option>
												<option data-countrycode="CF" value="236" style="color:red;">Central African
													Republic (+236)</option>
												<option data-countrycode="CL" value="56" style="color:red;">Chile (+56)</option>
												<option data-countrycode="CN" value="86" style="color:red;">China (+86)</option>
												<option data-countrycode="CO" value="57" style="color:red;">Colombia (+57)
												</option>
												<option data-countrycode="KM" value="269" style="color:red;">Comoros (+269)
												</option>
												<option data-countrycode="CG" value="242" style="color:red;">Congo (+242)</option>
												<option data-countrycode="CK" value="682" style="color:red;">Cook Islands (+682)
												</option>
												<option data-countrycode="CR" value="506" style="color:red;">Costa Rica (+506)
												</option>
												<option data-countrycode="HR" value="385" style="color:red;">Croatia (+385)
												</option>
												<option data-countrycode="CU" value="53" style="color:red;">Cuba (+53)</option>
												<option data-countrycode="CY" value="90392" style="color:red;">Cyprus North (+90392)
												</option>
												<option data-countrycode="CY" value="357" style="color:red;">Cyprus South (+357)
												</option>
												<option data-countrycode="CZ" value="42" style="color:red;">Czech Republic (+42)
												</option>
												<option data-countrycode="DK" value="45" style="color:red;">Denmark (+45)
												</option>
												<option data-countrycode="DJ" value="253" style="color:red;">Djibouti (+253)
												</option>
												<option data-countrycode="DM" value="1809" style="color:red;">Dominica (+1809)
												</option>
												<option data-countrycode="DO" value="1809" style="color:red;">Dominican Republic
													(+1809)</option>
												<option data-countrycode="EC" value="593" style="color:red;">Ecuador (+593)
												</option>
												<option data-countrycode="EG" value="20" style="color:red;">Egypt (+20)</option>
												<option data-countrycode="SV" value="503" style="color:red;">El Salvador (+503)
												</option>
												<option data-countrycode="GQ" value="240" style="color:red;">Equatorial Guinea
													(+240)</option>
												<option data-countrycode="ER" value="291" style="color:red;">Eritrea (+291)
												</option>
												<option data-countrycode="EE" value="372" style="color:red;">Estonia (+372)
												</option>
												<option data-countrycode="ET" value="251" style="color:red;">Ethiopia (+251)
												</option>
												<option data-countrycode="FK" value="500" style="color:red;">Falkland Islands
													(+500)</option>
												<option data-countrycode="FO" value="298" style="color:red;">Faroe Islands (+298)
												</option>
												<option data-countrycode="FJ" value="679" style="color:red;">Fiji (+679)</option>
												<option data-countrycode="FI" value="358" style="color:red;">Finland (+358)
												</option>
												<option data-countrycode="FR" value="33" style="color:red;">France (+33)</option>
												<option data-countrycode="GF" value="594" style="color:red;">French Guiana (+594)
												</option>
												<option data-countrycode="PF" value="689" style="color:red;">French Polynesia
													(+689)</option>
												<option data-countrycode="GA" value="241" style="color:red;">Gabon (+241)</option>
												<option data-countrycode="GM" value="220" style="color:red;">Gambia (+220)
												</option>
												<option data-countrycode="GE" value="7880" style="color:red;">Georgia (+7880)
												</option>
												<option data-countrycode="DE" value="49" style="color:red;">Germany (+49)
												</option>
												<option data-countrycode="GH" value="233" style="color:red;">Ghana (+233)</option>
												<option data-countrycode="GI" value="350" style="color:red;">Gibraltar (+350)
												</option>
												<option data-countrycode="GR" value="30" style="color:red;">Greece (+30)</option>
												<option data-countrycode="GL" value="299" style="color:red;">Greenland (+299)
												</option>
												<option data-countrycode="GD" value="1473" style="color:red;">Grenada (+1473)
												</option>
												<option data-countrycode="GP" value="590" style="color:red;">Guadeloupe (+590)
												</option>
												<option data-countrycode="GU" value="671" style="color:red;">Guam (+671)</option>
												<option data-countrycode="GT" value="502" style="color:red;">Guatemala (+502)
												</option>
												<option data-countrycode="GN" value="224" style="color:red;">Guinea (+224)
												</option>
												<option data-countrycode="GW" value="245" style="color:red;">Guinea - Bissau
													(+245)</option>
												<option data-countrycode="GY" value="592" style="color:red;">Guyana (+592)
												</option>
												<option data-countrycode="HT" value="509" style="color:red;">Haiti (+509)</option>
												<option data-countrycode="HN" value="504" style="color:red;">Honduras (+504)
												</option>
												<option data-countrycode="HK" value="852" style="color:red;">Hong Kong (+852)
												</option>
												<option data-countrycode="HU" value="36" style="color:red;">Hungary (+36)
												</option>
												<option data-countrycode="IS" value="354" style="color:red;">Iceland (+354)
												</option>
												<option data-countrycode="IN" value="91" style="color:red;">India (+91)</option>
												<option data-countrycode="ID" value="62" style="color:red;">Indonesia (+62)
												</option>
												<option data-countrycode="IR" value="98" style="color:red;">Iran (+98)</option>
												<option data-countrycode="IQ" value="964" style="color:red;">Iraq (+964)</option>
												<option data-countrycode="IE" value="353" style="color:red;">Ireland (+353)
												</option>
												<option data-countrycode="IL" value="972" style="color:red;">Israel (+972)
												</option>
												<option data-countrycode="IT" value="39" style="color:red;">Italy (+39)</option>
												<option data-countrycode="JM" value="1876" style="color:red;">Jamaica (+1876)
												</option>
												<option data-countrycode="JP" value="81" style="color:red;">Japan (+81)</option>
												<option data-countrycode="JO" value="962" style="color:red;">Jordan (+962)
												</option>
												<option data-countrycode="KZ" value="7" style="color:red;">Kazakhstan (+7)
												</option>
												<option data-countrycode="KE" value="254" style="color:red;">Kenya (+254)</option>
												<option data-countrycode="KI" value="686" style="color:red;">Kiribati (+686)
												</option>
												<option data-countrycode="KP" value="850" style="color:red;">Korea North (+850)
												</option>
												<option data-countrycode="KR" value="82" style="color:red;">Korea South (+82)
												</option>
												<option data-countrycode="KW" value="965" style="color:red;">Kuwait (+965)
												</option>
												<option data-countrycode="KG" value="996" style="color:red;">Kyrgyzstan (+996)
												</option>
												<option data-countrycode="LA" value="856" style="color:red;">Laos (+856)</option>
												<option data-countrycode="LV" value="371" style="color:red;">Latvia (+371)
												</option>
												<option data-countrycode="LB" value="961" style="color:red;">Lebanon (+961)
												</option>
												<option data-countrycode="LS" value="266" style="color:red;">Lesotho (+266)
												</option>
												<option data-countrycode="LR" value="231" style="color:red;">Liberia (+231)
												</option>
												<option data-countrycode="LY" value="218" style="color:red;">Libya (+218)</option>
												<option data-countrycode="LI" value="417" style="color:red;">Liechtenstein (+417)
												</option>
												<option data-countrycode="LT" value="370" style="color:red;">Lithuania (+370)
												</option>
												<option data-countrycode="LU" value="352" style="color:red;">Luxembourg (+352)
												</option>
												<option data-countrycode="MO" value="853" style="color:red;">Macao (+853)</option>
												<option data-countrycode="MK" value="389" style="color:red;">Macedonia (+389)
												</option>
												<option data-countrycode="MG" value="261" style="color:red;">Madagascar (+261)
												</option>
												<option data-countrycode="MW" value="265" style="color:red;">Malawi (+265)
												</option>
												<option data-countrycode="MY" value="60" style="color:red;">Malaysia (+60)
												</option>
												<option data-countrycode="MV" value="960" style="color:red;">Maldives (+960)
												</option>
												<option data-countrycode="ML" value="223" style="color:red;">Mali (+223)</option>
												<option data-countrycode="MT" value="356" style="color:red;">Malta (+356)</option>
												<option data-countrycode="MH" value="692" style="color:red;">Marshall Islands
													(+692)</option>
												<option data-countrycode="MQ" value="596" style="color:red;">Martinique (+596)
												</option>
												<option data-countrycode="MR" value="222" style="color:red;">Mauritania (+222)
												</option>
												<option data-countrycode="YT" value="269" style="color:red;">Mayotte (+269)
												</option>
												<option data-countrycode="MX" value="52" style="color:red;">Mexico (+52)</option>
												<option data-countrycode="FM" value="691" style="color:red;">Micronesia (+691)
												</option>
												<option data-countrycode="MD" value="373" style="color:red;">Moldova (+373)
												</option>
												<option data-countrycode="MC" value="377" style="color:red;">Monaco (+377)
												</option>
												<option data-countrycode="MN" value="976" style="color:red;">Mongolia (+976)
												</option>
												<option data-countrycode="MS" value="1664" style="color:red;">Montserrat (+1664)
												</option>
												<option data-countrycode="MA" value="212" style="color:red;">Morocco (+212)
												</option>
												<option data-countrycode="MZ" value="258" style="color:red;">Mozambique (+258)
												</option>
												<option data-countrycode="MN" value="95" style="color:red;">Myanmar (+95)
												</option>
												<option data-countrycode="NA" value="264" style="color:red;">Namibia (+264)
												</option>
												<option data-countrycode="NR" value="674" style="color:red;">Nauru (+674)</option>
												<option data-countrycode="NP" value="977" style="color:red;">Nepal (+977)</option>
												<option data-countrycode="NL" value="31" style="color:red;">Netherlands (+31)
												</option>
												<option data-countrycode="NC" value="687" style="color:red;">New Caledonia (+687)
												</option>
												<option data-countrycode="NZ" value="64" style="color:red;">New Zealand (+64)
												</option>
												<option data-countrycode="NI" value="505" style="color:red;">Nicaragua (+505)
												</option>
												<option data-countrycode="NE" value="227" style="color:red;">Niger (+227)</option>
												<option data-countrycode="NG" value="234" style="color:red;">Nigeria (+234)
												</option>
												<option data-countrycode="NU" value="683" style="color:red;">Niue (+683)</option>
												<option data-countrycode="NF" value="672" style="color:red;">Norfolk Islands
													(+672)</option>
												<option data-countrycode="NP" value="670" style="color:red;">Northern Marianas
													(+670)</option>
												<option data-countrycode="NO" value="47" style="color:red;">Norway (+47)</option>
												<option data-countrycode="OM" value="968" style="color:red;">Oman (+968)</option>
												<option data-countrycode="PW" value="680" style="color:red;">Palau (+680)</option>
												<option data-countrycode="PA" value="507" style="color:red;">Panama (+507)
												</option>
												<option data-countrycode="PG" value="675" style="color:red;">Papua New Guinea
													(+675)</option>
												<option data-countrycode="PY" value="595" style="color:red;">Paraguay (+595)
												</option>
												<option data-countrycode="PE" value="51" style="color:red;">Peru (+51)</option>
												<option data-countrycode="PH" value="63" style="color:red;">Philippines (+63)
												</option>
												<option data-countrycode="PL" value="48" style="color:red;">Poland (+48)</option>
												<option data-countrycode="PT" value="351" style="color:red;">Portugal (+351)
												</option>
												<option data-countrycode="PR" value="1787" style="color:red;">Puerto Rico (+1787)
												</option>
												<option data-countrycode="QA" value="974" style="color:red;">Qatar (+974)</option>
												<option data-countrycode="RE" value="262" style="color:red;">Reunion (+262)
												</option>
												<option data-countrycode="RO" value="40" style="color:red;">Romania (+40)
												</option>
												<option data-countrycode="RU" value="7" style="color:red;">Russia (+7)</option>
												<option data-countrycode="RW" value="250" style="color:red;">Rwanda (+250)
												</option>
												<option data-countrycode="SM" value="378" style="color:red;">San Marino (+378)
												</option>
												<option data-countrycode="ST" value="239" style="color:red;">Sao Tome &amp;
													Principe (+239)</option>
												<option data-countrycode="SA" value="966" style="color:red;">Saudi Arabia (+966)
												</option>
												<option data-countrycode="SN" value="221" style="color:red;">Senegal (+221)
												</option>
												<option data-countrycode="CS" value="381" style="color:red;">Serbia (+381)
												</option>
												<option data-countrycode="SC" value="248" style="color:red;">Seychelles (+248)
												</option>
												<option data-countrycode="SL" value="232" style="color:red;">Sierra Leone (+232)
												</option>
												<option data-countrycode="SG" value="65" style="color:red;">Singapore (+65)
												</option>
												<option data-countrycode="SK" value="421" style="color:red;">Slovak Republic
													(+421)</option>
												<option data-countrycode="SI" value="386" style="color:red;">Slovenia (+386)
												</option>
												<option data-countrycode="SB" value="677" style="color:red;">Solomon Islands
													(+677)</option>
												<option data-countrycode="SO" value="252" style="color:red;">Somalia (+252)
												</option>
												<option data-countrycode="ZA" value="27" style="color:red;">South Africa (+27)
												</option>
												<option data-countrycode="ES" value="34" style="color:red;">Spain (+34)</option>
												<option data-countrycode="LK" value="94" style="color:red;">Sri Lanka (+94)
												</option>
												<option data-countrycode="SH" value="290" style="color:red;">St. Helena (+290)
												</option>
												<option data-countrycode="KN" value="1869" style="color:red;">St. Kitts (+1869)
												</option>
												<option data-countrycode="SC" value="1758" style="color:red;">St. Lucia (+1758)
												</option>
												<option data-countrycode="SD" value="249" style="color:red;">Sudan (+249)</option>
												<option data-countrycode="SR" value="597" style="color:red;">Suriname (+597)
												</option>
												<option data-countrycode="SZ" value="268" style="color:red;">Swaziland (+268)
												</option>
												<option data-countrycode="SE" value="46" style="color:red;">Sweden (+46)</option>
												<option data-countrycode="CH" value="41" style="color:red;">Switzerland (+41)
												</option>
												<option data-countrycode="SI" value="963" style="color:red;">Syria (+963)</option>
												<option data-countrycode="TW" value="886" style="color:red;">Taiwan (+886)
												</option>
												<option data-countrycode="TJ" value="7" style="color:red;">Tajikstan (+7)
												</option>
												<option data-countrycode="TH" value="66" style="color:red;">Thailand (+66)
												</option>
												<option data-countrycode="TG" value="228" style="color:red;">Togo (+228)</option>
												<option data-countrycode="TO" value="676" style="color:red;">Tonga (+676)</option>
												<option data-countrycode="TT" value="1868" style="color:red;">Trinidad &amp; Tobago
													(+1868)</option>
												<option data-countrycode="TN" value="216" style="color:red;">Tunisia (+216)
												</option>
												<option data-countrycode="TR" value="90" style="color:red;">Turkey (+90)</option>
												<option data-countrycode="TM" value="7" style="color:red;">Turkmenistan (+7)
												</option>
												<option data-countrycode="TM" value="993" style="color:red;">Turkmenistan (+993)
												</option>
												<option data-countrycode="TC" value="1649" style="color:red;">Turks &amp; Caicos
													Islands (+1649)</option>
												<option data-countrycode="TV" value="688" style="color:red;">Tuvalu (+688)
												</option>
												<option data-countrycode="UG" value="256" style="color:red;">Uganda (+256)
												</option>
												<!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
												<option data-countrycode="UA" value="380" style="color:red;">Ukraine (+380)
												</option>
												<option data-countrycode="AE" value="971" style="color:red;">United Arab Emirates
													(+971)</option>
												<option data-countrycode="UY" value="598" style="color:red;">Uruguay (+598)
												</option>
												<!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
												<option data-countrycode="UZ" value="7" style="color:red;">Uzbekistan (+7)
												</option>
												<option data-countrycode="VU" value="678" style="color:red;">Vanuatu (+678)
												</option>
												<option data-countrycode="VA" value="379" style="color:red;">Vatican City (+379)
												</option>
												<option data-countrycode="VE" value="58" style="color:red;">Venezuela (+58)
												</option>
												<option data-countrycode="VN" value="84" style="color:red;">Vietnam (+84)
												</option>
												<option data-countrycode="VG" value="84" style="color:red;">Virgin Islands -
													British (+1284)</option>
												<option data-countrycode="VI" value="84" style="color:red;">Virgin Islands - US
													(+1340)</option>
												<option data-countrycode="WF" value="681" style="color:red;">Wallis &amp; Futuna
													(+681)</option>
												<option data-countrycode="YE" value="969" style="color:red;">Yemen (North)(+969)
												</option>
												<option data-countrycode="YE" value="967" style="color:red;">Yemen (South)(+967)
												</option>
												<option data-countrycode="ZM" value="260" style="color:red;">Zambia (+260)
												</option>
												<option data-countrycode="ZW" value="263" style="color:red;">Zimbabwe (+263)
												</option>
											</optgroup>
										</select>

										<input type="text" class="form-control" name="contact" placeholder="Mobile number" aria-label="Mobile Number">
									   
										<span id="mobile_status" style="color:red; font-size:14px"></span>
									</div>

								</div>
							</div>
							<div class="row">
								<div class="col-md-6">

									<div class="form-group">
										<label class="form-label" for="exampleInputEmail"><b>Email-ID
											</b>&nbsp;<span style="color:red;">*</span></label>
										<input type="email" style="color:red;" class="form-control"
											id="exampleInputEmail" placeholder="Enter email">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label" for="LocationInput"><b>Current Location
											</b>&nbsp;<span style="color:red;">*</span></label>
										<input type="location" style="color:red;" class="form-control"
											id="LocationInput" placeholder="Enter current location">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-12 col-sm-12">
									<div class="form-group">
										<label class="form-label" for="LocationInput"><b>Headshot-Image
											</b>&nbsp;<span style="color:red;">*</span> <b> &nbsp; : &nbsp;Refer
												sample headshot image</b></label>
										<br />
										<input type="radio" name="tab" value="igotnone" id="hide">
										<span style="color:red;"><b>Hide sample headshot image</b></span>
										<input type="radio" name="tab" value="igottwo" id="show">
										<span style="color:red;"><b>Show sample headshot image</b></span>
										<br />
										<script>
											$('#hide').on("click", function(e) {
												$('#sample_headshot').hide();
											});

											$('#show').on("click", function(e) {
												$('#sample_headshot').show();
											});
										</script>
										<img id="sample_headshot" {{-- class="visually-hidden" --}}
											src="https://www.shutterstock.com/image-photo/man-hands-holding-global-network-260nw-1801568002.jpg"
											style="max-width:20%;height:auto;"><br>
										<input type="file" id="headshot_image" name="headshot_image"
											class="" style="color:red;" accept="image/*">
										<span id="uploaded_image1" style="display:none;"></span><span
											style="color:red;"><b>Extension
												(gif,png,jpg,jpeg) size 5kb to 2mb</b></span>
									</div>
								</div>

							</div>

							<div class="row">
								<div class="col-md-12 col-lg-12 col-sm-12">
									<div class="form-group">
										<label class="form-label" for="LocationInput"><b>Introduction Video link
											</b>&nbsp;<span style="color:red;">*</span> <b> &nbsp; <small
													style="color:red;">(Youtube video link) </small> &nbsp;: &nbsp;
												Refer sample intro video</b></label>
										<br />
										<input type="radio" name="tab" value="igotnone" id="hideVideo">
										<span style="color:red;"><b>Hide sample intro video</b></span>
										<input type="radio" name="tab" value="igottwo" id="showVideo">
										<span style="color:red;"><b>Show sample intro video</b></span>
										<br />
										<div id="sample_intro" class="hide">
											<select onchange="newSrc(this.value)" class="form-control">
												<option value="videos/sample_video_english.mp4">Intro in English
												</option>
												<option value="videos/sample_video_hindi.mp4">Intro in Hindi
												</option>
											</select>
											<br />
											<br />
											<video id="iframe_sample_intro" style="max-width:50%;height:50%;"
												controls="" preload="none">
												<source style="max-width:50%;height:50%;"
													src="https://youtu.be/UpyYq3bQEHg" preload="none"
													type="video/mp4">
											</video>
										</div>

										<script>
											$('#hideVideo').on("click", function(e) {
												$('#sample_intro').hide();
											});

											$('#showVideo').on("click", function(e) {
												$('#sample_intro').show();

											});
										</script>
									</div>
								</div>

							</div>
							<center>
							<button type="submit"  style="background:red;" class="btn btn-danger">Submit</button>
							</center>
						</form>



					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection