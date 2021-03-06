<?php

// List of all contries member of the European Union (used for VAT billing)
$cc_europe = array(
  "AT" => 1,
  "BE" => 1,
  "BG" => 1,
  "CY" => 1,
  "CZ" => 1,
  "DK" => 1,
  "EE" => 1,
  "FI" => 1,
  "FR" => 1,
  "DE" => 1,
  "GR" => 1,
  "HU" => 1,
  "IE" => 1,
  "IT" => 1,
  "LV" => 1,
  "LT" => 1,
  "LU" => 1,
  "MT" => 1,
  "NL" => 1,
  "PL" => 1,
  "PT" => 1,
  "SK" => 1,
  "SI" => 1,
  "ES" => 1,
  "SE" => 1,
  "RO" => 1,
  "UK" => 1
);

// This table sets the VAT for known countries (taken from http://en.wikipedia.org/wiki/Value_added_tax)
// If you know things that are not accurate (like a different rate for internet services)
// please get in touch (send a mail to thomas@goirand.fr)
$cc_code_vat = array(
"AR"=> 21,
"AU"=> 10,
"AT"=> 20,
"BE"=> 21,
"BA"=> 17,
"BG"=> 20,
"CA"=> 6,
"CL"=> 19,
"CN"=> 17,
"HR"=> 22,
"CY"=> 15,
"CZ"=> 19,
"DK"=> 25,
"DO"=> 6,
"EC"=> 12,
"SV"=> 13,
"EE"=> 18,
"FI"=> 22,
"FR"=> 19.6,
"GR"=> 19,
"GY"=> 16,
"HU"=> 20,
"IS"=> 24.5,
"IN"=> 12.5,
"IE"=> 20,
"IL"=> 15.5,
"IT"=> 20,
"JP"=> 5,
"KZ"=> 14,
"KR"=> 10,
"LV"=> 18,
"LB"=> 10,
"LT"=> 18,
"LU"=> 15,
"MO"=> 17,
"MK"=> 18,
"MY"=> 5,
"MT"=> 18,
"MX"=> 15,
"MD"=> 20,
"NL"=> 19,
"NZ"=> 12.5,
"NO"=> 25,
"PY"=> 10,
"PE"=> 19,
"PH"=> 12,
"PL"=> 22,
"PT"=> 21,
"RO"=> 19,
"RU"=> 18,
"RS"=> 18,
"SG"=> 5,
"SK"=> 19,
"SI"=> 20,
"ZA"=> 14,
"ES"=> 16,
"LK"=> 15,
"SE"=> 25,
"CH"=> 7.6,
"TH"=> 7,
"TR"=> 18,
"UA"=> 20,
"UK"=> 17.5,
"VE"=> 16
	);

$cc_code_array = array(
"AF"=> _("Afghanistan"),
"AL"=> _("Albania"),
"DZ"=> _("Algeria"),
"AS"=> _("American Samoa"),
"AD"=> _("Andorra"),
"AO"=> _("Angola"),
"AI"=> _("Anguilla"),
"AQ"=> _("Antarctica"),
"AG"=> _("Antigua And Barbuda"),
"AR"=> _("Argentina"),
"AM"=> _("Armenia"),
"AW"=> _("Aruba"),
"AU"=> _("Australia"),
"AT"=> _("Austria"),
"AZ"=> _("Azerbaijan"),
"AC"=> _("Ascension Island"),
"BS"=> _("Bahamas"),
"BH"=> _("Bahrain"),
"BD"=> _("Bangladesh"),
"BB"=> _("Barbados"),
"BY"=> _("Belarus"),
"BE"=> _("Belgium"),
"BZ"=> _("Belize"),
"BJ"=> _("Benin"),
"BM"=> _("Bermuda"),
"BT"=> _("Bhutan"),
"BO"=> _("Bolivia"),
"BA"=> _("Bosnia Hercegovina"),
"BW"=> _("Botswana"),
"BV"=> _("Bouvet Island"),
"BR"=> _("Brazil"),
"IO"=> _("British Indian Ocean Territory"),
"BN"=> _("Brunei Darussalam"),
"BG"=> _("Bulgaria"),
"BF"=> _("Burkina Faso"),
"BI"=> _("Burundi"),
"KH"=> _("Cambodia"),
"CM"=> _("Cameroon"),
"CA"=> _("Canada"),
"CV"=> _("Cape Verde"),
"KY"=> _("Cayman Islands"),
"CF"=> _("Central African Republic"),
"TD"=> _("Chad"),
"CL"=> _("Chile"),
"CN"=> _("China"),
"CX"=> _("Christmas Island"),
"CC"=> _("Cocos (Keeling) Islands"),
"CO"=> _("Colombia"),
"KM"=> _("Comoros"),
"CG"=> _("Congo"),
"CK"=> _("Cook Islands"),
"CR"=> _("Costa Rica"),
"HR"=> _("Croatia"),
"CU"=> _("Cuba"),
"CY"=> _("Cyprus"),
"CZ"=> _("Czech Republic"),
"CS"=> _("Czechoslovakia"),
"DK"=> _("Denmark"),
"DJ"=> _("Djibouti"),
"DM"=> _("Dominica"),
"DO"=> _("Dominican Republic"),
"TP"=> _("East Timor"),
"EC"=> _("Ecuador"),
"EG"=> _("Egypt"),
"SV"=> _("El Salvador"),
"GQ"=> _("Equatorial Guinea"),
"ER"=> _("Eritrea"),
"EE"=> _("Estonia"),
"ET"=> _("Ethiopia"),
"FK"=> _("Falkland Islands (Malvinas)"),
"FO"=> _("Faroe Islands"),
"FJ"=> _("Fiji"),
"FI"=> _("Finland"),
"CS"=> _("Former Czechoslovakia"),
"su"=> _("Former USSR"),
"FR"=> _("France"),
"FX"=> _("France (European Territories)"),
"GF"=> _("French Guiana"),
"PF"=> _("French Polynesia"),
"TF"=> _("French Southern Territories"),
"GA"=> _("Gabon"),
"GM"=> _("Gambia"),
"GE"=> _("Georgia"),
"DE"=> _("Germany"),
"GH"=> _("Ghana"),
"GI"=> _("Gibraltar"),
"GB"=> _("Great Britain"),
"GR"=> _("Greece"),
"GL"=> _("Greenland"),
"GD"=> _("Grenada"),
"GP"=> _("Guadeloupe (French)"),
"GU"=> _("Guam (USA)"),
"GT"=> _("Guatemela"),
"GW"=> _("Guinea Bissau"),
"GY"=> _("Guyana"),
"GG"=> _("Guernsey"),
"HT"=> _("Haiti"),
"HM"=> _("Heard and McDonald Islands"),
"HN"=> _("Honduras"),
"HK"=> _("Hong Kong"),
"HU"=> _("Hungary"),
"IS"=> _("Iceland"),
"IN"=> _("India"),
"ID"=> _("Indonesia"),
"IR"=> _("Iran (Islamic Republic Of)"),
"IQ"=> _("Iraq"),
"IE"=> _("Ireland"),
"IM"=> _("Isle Of Man"),
"IL"=> _("Israel"),
"IT"=> _("Italy"),
"CI"=> _("Ivory Coast (Cote D'Ivoire)"),
"JM"=> _("Jamaica"),
"JP"=> _("Japan"),
"JO"=> _("Jordan"),
"JF"=> _("Jothan Frakes Islands"),
"JE"=> _("Jersey"),
"KZ"=> _("Kazakhstan"),
"KE"=> _("Kenya"),
"KI"=> _("Kiribati"),
"KW"=> _("Kuwait"),
"KP"=> _("Korea, Democratic People's Republic Of"),
"KR"=> _("Korea, Republic Of"),
"KG"=> _("Kyrgyzstan"),
"LA"=> _("Lao People's Democratic Republic"),
"LV"=> _("Latvia"),
"LB"=> _("Lebanon"),
"LS"=> _("Lesotho"),
"LR"=> _("Liberia"),
"LY"=> _("Libyan Arab Jamahiriya"),
"LI"=> _("Liechtenstein"),
"LT"=> _("Lithuania"),
"LU"=> _("Luxembourg"),
"MO"=> _("Macau"),
"MK"=> _("Macedonia"),
"MG"=> _("Madagascar"),
"MW"=> _("Malawi"),
"MY"=> _("Malaysia"),
"MV"=> _("Maldives"),
"ML"=> _("Mali"),
"MT"=> _("Malta"),
"MH"=> _("Marshall Islands"),
"MQ"=> _("Martinique (French)"),
"MR"=> _("Mauritania"),
"MU"=> _("Mauritius"),
"YT"=> _("Mayotte"),
"MX"=> _("Mexico"),
"FM"=> _("Micronesia, Federated States Of"),
"MD"=> _("Moldova, Republic Of"),
"MC"=> _("Monaco"),
"MN"=> _("Mongolia"),
"MS"=> _("Montserrat"),
"MA"=> _("Morocco"),
"MZ"=> _("Mozambique"),
"MM"=> _("Myanmar"),
"NA"=> _("Namibia"),
"NR"=> _("Nauru"),
"NP"=> _("Nepal"),
"NL"=> _("Netherlands"),
"AN"=> _("Netherlands Antilles"),
"NT"=> _("Neutral Zone"),
"NC"=> _("New Caledonia (French)"),
"NZ"=> _("New Zealand"),
"NI"=> _("Nicaragua"),
"NE"=> _("Niger"),
"NG"=> _("Nigeria"),
"NU"=> _("Niue"),
"NF"=> _("Norfolk Island"),
"MP"=> _("Northern Mariana Islands"),
"NO"=> _("Norway"),
"OM"=> _("Oman"),
"PK"=> _("Pakistan"),
"PW"=> _("Palau"),
"PS"=> _("Palestine"),
"PA"=> _("Panama"),
"PG"=> _("Papua New Guinea"),
"PY"=> _("Paraguay"),
"PE"=> _("Peru"),
"PH"=> _("Philippines"),
"PN"=> _("Pitcairn"),
"PL"=> _("Poland"),
"PT"=> _("Portugal"),
"ZN"=> _("Prince Nizam Zambri Isle"),
"PR"=> _("Puerto Rico"),
"QA"=> _("Qatar"),
"RE"=> _("Reunion"),
"RO"=> _("Romania"),
"RU"=> _("Russian Federation"),
"RW"=> _("Rwanda"),
"SH"=> _("Saint Helena"),
"KN"=> _("Saint Kitts And Nevis"),
"LC"=> _("Saint Lucia"),
"PM"=> _("Saint Pierre and Miquelon"),
"VC"=> _("Saint Vincent and The Grenadines"),
"WS"=> _("Samoa"),
"SM"=> _("San Marino"),
"ST"=> _("Sao Tome and Principe"),
"SA"=> _("Saudi Arabia"),
"SN"=> _("Senegal"),
"RS"=> _("Serbia"),
"SC"=> _("Seychelles"),
"SL"=> _("Sierra Leone"),
"SG"=> _("Singapore"),
"SK"=> _("Slovakia (Republic)"),
"SI"=> _("Slovenia"),
"SB"=> _("Solomon Islands"),
"SO"=> _("Somalia"),
"ZA"=> _("South Africa"),
"GS"=> _("South Georgia and The Sandwich Islands"),
"ES"=> _("Spain"),
"LK"=> _("Sri Lanka"),
"SD"=> _("Sudan"),
"SR"=> _("Suriname"),
"SJ"=> _("Svalbard and Jan Mayen Islands"),
"SZ"=> _("Swaziland"),
"SE"=> _("Sweden"),
"CH"=> _("Switzerland"),
"SY"=> _("Syrian Arab Republic"),
"TJ"=> _("Tadjikistan"),
"TW"=> _("Taiwan"),
"TZ"=> _("Tanzania, United Republic Of"),
"TH"=> _("Thailand"),
"TG"=> _("Togo"),
"TK"=> _("Tokelau"),
"TO"=> _("Tonga"),
"TT"=> _("Trinidad and Tobago"),
"TN"=> _("Tunisia"),
"TR"=> _("Turkey"),
"TM"=> _("Turkmenistan"),
"TC"=> _("Turks and Caicos Islands"),
"TV"=> _("Tuvalu"),
"UG"=> _("Uganda"),
"UA"=> _("Ukraine"),
"AE"=> _("United Arab Emirates"),
"UK"=> _("United Kingdom"),
"US"=> _("United States"),
"UM"=> _("United States Minor Outlying Islands"),
"UY"=> _("Uruguay"),
"UZ"=> _("Uzbekistan"),
"VU"=> _("Vanuatu"),
"VA"=> _("Vatican City State"),
"VE"=> _("Venezuela"),
"VN"=> _("Vietnam"),
"VG"=> _("Virgin Islands (British)"),
"VI"=> _("Virgin Islands (U.S.)"),
"WF"=> _("Wallis and Futuna Islands"),
"WG"=> _("West Bank and Gaza"),
"EH"=> _("Western Sahara"),
"YE"=> _("Yemen, Republic of"),
"YU"=> _("Yugoslavia"),
"ZR"=> _("Zaire"),
"ZM"=> _("Zambia"),
"ZW"=> _("Zimbabwe")
	);

asort($cc_code_array);

function cc_code_popup($default="US"){
	global $cc_code_array;

	$out = "";

	$ar_keys = array_keys($cc_code_array);
	$nbr_cc_code = sizeof($ar_keys);
	for($i=0;$i<$nbr_cc_code;$i++){
		if($default == $ar_keys[$i]){
			$sel = " selected ";
		}else{
			$sel = "";
		}
		$out .= '<option value="' . $ar_keys[$i] . '"' . $sel . '>' .
			$cc_code_array[ $ar_keys[$i] ] . '</option>\n';
	}
	return $out;
}
$cc_code_popup = cc_code_popup();

?>
