<?php
/**
%%%copyright%%%
 *
 * FusionTicket - ticket reservation system
 *  Copyright (C) 2007-2009 Christopher Jenkins, Niels, Lou. All rights reserved.
 *
 * Original Design:
 *	phpMyTicket - ticket reservation system
 * 	Copyright (C) 2004-2005 Anna Putrino, Stanislav Chachkov. All rights reserved.
 *
 * This file is part of FusionTicket.
 *
 * This file may be distributed and/or modified under the terms of the
 * "GNU General Public License" version 3 as published by the Free
 * Software Foundation and appearing in the file LICENSE included in
 * the packaging of this file.
 *
 * This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
 * THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE.
 *
 * Any links or references to Fusion Ticket must be left in under our licensing agreement.
 *
 * By USING this file you are agreeing to the above terms of use. REMOVING this licence does NOT
 * remove your obligation to the terms of use.
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * Contact help@fusionticket.com if any conditions of this licencing isn't
 * clear to you.
 */

global $_COUNTRY_LIST;
$_COUNTRY_LIST=array(
 "AF" => "Afghanistan",
 "AL" => "Albania",
 "DZ" => "Algeria",
 "AS" => "American Samoa",
 "AD" => "Andorra",
 "AO" => "Angola",
 "AI" => "Anguilla",
 "AQ" => "Antarctica",
 "AG" => "Antigua and Barbuda",
 "AR" => "Argentina",
 "AM" => "Armenia",
 "AW" => "Aruba",
 "AU" => "Australia",
 "AT" => "Austria",
 "AZ" => "Azerbaijan",
 "BS" => "Bahamas",
 "BH" => "Bahrain",
 "BD" => "Bangladesh",
 "BB" => "Barbados",
 "BY" => "Belarus",
 "BE" => "Belgium",
 "BZ" => "Belize",
 "BJ" => "Benin",
 "BM" => "Bermuda",
 "BT" => "Bhutan",
 "BO" => "Bolivia",
 "BA" => "Bosnia and Herzegovina",
 "BW" => "Botswana",
 "BV" => "Bouvet Island",
 "BR" => "Brazil",
 "BN" => "Brunei",
 "BG" => "Bulgaria",
 "BF" => "Burkina Faso",
 "BI" => "Burundi",
 "KH" => "Cambodia",
 "CM" => "Cameroon",
 "CA" => "Canada",
 "CV" => "Cape Verde",
 "KY" => "Cayman Islands",
 "CF" => "Central African Republic",
 "TD" => "Chad",
 "CL" => "Chile",
 "CN" => "China",
 "CX" => "Christmas Island",
 "CC" => "Cocos (Keeling) Islands",
 "CO" => "Colombia",
 "KM" => "Comores",
 "CG" => "Congo",
 "CD" => "Congo, democratic republic of",
 "CK" => "Cook Islands",
 "CR" => "Costa Rica",
 "CI" => "Cote d'Ivoire",
 "HR" => "Croatia (local name: Hrvatska)",
 "CU" => "Cuba",
 "CY" => "Cyprus",
 "CZ" => "Czech Republic",
 "DK" => "Denmark",
 "DJ" => "Djibouti",
 "DM" => "Dominica",
 "DO" => "Dominican Republic",
 "TP" => "East Timor",
 "EC" => "Ecuador",
 "EG" => "Egypt",
 "SV" => "El Salvador",
 "GQ" => "Equatorial Guinea",
 "ER" => "Eritrea",
 "EE" => "Estonia",
 "ET" => "Ethiopia",
 "FK" => "Falkland Islands (Malvinas)",
 "FO" => "Faroe Islands",
 "FJ" => "Fiji",
 "FI" => "Finland",
 "FR" => "France",
 "FX" => "France, Metropolitan",
 "GF" => "French Guiana",
 "PF" => "French Polynesia",
 "GA" => "Gabon",
 "GM" => "Gambia",
 "GE" => "Georgia",
 "DE" => "Germany",
 "GH" => "Ghana",
 "GI" => "Gibraltar",
 "GR" => "Greece",
 "GL" => "Greenland",
 "GD" => "Grenada",
 "GP" => "Guadeloupe",
 "GU" => "Guam",
 "GT" => "Guatemala",
 "GN" => "Guinea",
 "GW" => "Guinea-Bissau",
 "GY" => "Guyana",
 "HT" => "Haiti",
 "HM" => "Heard and Mc Donald Islands",
 "HN" => "Honduras",
 "HK" => "Hong Kong",
 "HU" => "Hungary",
 "IS" => "Iceland",
 "IN" => "India",
 "ID" => "Indonesia",
 "IR" => "Iran (Islamic Republic of)",
 "IQ" => "Iraq",
 "IE" => "Ireland",
 "IL" => "Israel",
 "IT" => "Italy",
 "JM" => "Jamaica",
 "JP" => "Japan",
 "JO" => "Jordan",
 "KZ" => "Kazakhstan",
 "KE" => "Kenya",
 "KI" => "Kiribati",
 "KP" => "Korea, Democratic People's ...",
 "KR" => "Korea, Republic of",
 "KW" => "Kuwait",
 "KG" => "Kyrgyzstan",
 "LA" => "Lao People's Democratic Rep...",
 "LV" => "Lativa",
 "LB" => "Lebanon",
 "LS" => "Lesotho",
 "LR" => "Liberia",
 "LY" => "Libya",
 "LI" => "Liechtenstein",
 "LT" => "Lithuania",
 "LU" => "Luxenbourg",
 "MO" => "Macau",
 "MK" => "Macedonia",
 "MG" => "Madagascar",
 "MW" => "Malawi",
 "MY" => "Malaysia",
 "MV" => "Maldives",
 "ML" => "Mali",
 "MT" => "Malta",
 "MH" => "Marshall Islands",
 "MQ" => "Martinique",
 "MR" => "Mauritania",
 "MU" => "Mauritius",
 "YT" => "Mayotte",
 "MX" => "Mexico",
 "FM" => "Micronesia, Federated State...",
 "MD" => "Moldova, Republic of",
 "MC" => "Monaco",
 "MN" => "Mongolia",
 "MS" => "Montserrat",
 "MA" => "Morocco",
 "MZ" => "Mozambique",
 "MM" => "Myanmar",
 "NA" => "Namibia",
 "NR" => "Nauru",
 "NP" => "Nepal",
 "NL" => "Netherlands",
 "AN" => "Netherlands Antilles",
 "NC" => "New Caledonia",
 "NZ" => "New Zealand",
 "NI" => "Nicaragua",
 "NE" => "Niger",
 "NG" => "Nigeria",
 "NU" => "Niue",
 "NF" => "Norfolk Island",
 "MP" => "Northern Mariana Islands",
 "NO" => "Norway",
 "OM" => "Oman",
 "PK" => "Pakistan",
 "PW" => "Palau",
 "PA" => "Panama",
 "PG" => "Papua New Guinea",
 "PY" => "Paraguay",
 "PE" => "Peru",
 "PH" => "Philippines",
 "PN" => "Pitcairn",
 "PL" => "Poland",
 "PT" => "Portugal",
 "PR" => "Puerto Rico",
 "QA" => "Qatar",
 "RE" => "Reunion",
 "RO" => "Romania",
 "RU" => "Russian Federation",
 "RW" => "Rwanda",
 "KN" => "Saint Kitts and Nevis",
 "LC" => "Saint Lucia",
 "VC" => "Saint Vincent and the Grena...",
 "WS" => "Samoa",
 "SM" => "San Marino",
 "ST" => "Sao Tome and Principe",
 "SA" => "Saudi Arabia",
 "SN" => "Senegal",
 "SC" => "Seychelles",
 "SL" => "Sierra Leone",
 "SG" => "Singapore",
 "SK" => "Slovakia (Slovak Republic)",
 "SI" => "Slovenia",
 "SB" => "Solomon Islands",
 "SO" => "Somalia",
 "ZA" => "South Africa",
 "GS" => "South Georgia and the South...",
 "ES" => "Spain",
 "LK" => "Sri Lanka",
 "SH" => "St. Helena",
 "PM" => "St. Pierre and Miquelon",
 "SD" => "Sudan",
 "SR" => "Surinam",
 "SJ" => "Svalbard and Jan Mayen Islands",
 "SZ" => "Swaziland",
 "SE" => "Sweden",
 "CH" => "Switzerland",
 "SY" => "Syrian Arab Republic",
 "TW" => "Taiwan, Province of China",
 "TJ" => "Tajikistan",
 "TZ" => "Tanzania, United Republic of",
 "TH" => "Thailand",
 "TG" => "Togo",
 "TK" => "Tokelau",
 "TO" => "Tonga",
 "TT" => "Trinidad and Tobago",
 "TN" => "Tunisia",
 "TR" => "Turkey",
 "TM" => "Turkmenistan",
 "TC" => "Turks and Caicos Islands",
 "TV" => "Tuvalu",
 "UG" => "Uganda",
 "UA" => "Ukraine",
 "AE" => "United Arab Emirates",
 "GB" => "United Kingdom",
 "US" => "United States",
 "UY" => "Uruguay",
 "UZ" => "Uzbekistan",
 "VU" => "Vanuatu",
 "VA" => "Vatican City State",
 "VE" => "Venezuela",
 "VN" => "Vietnam",
 "VI" => "Virgin Islands  (U.S.)",
 "VG" => "Virgin Islands (British)",
 "WF" => "Wallis and Futuna Islands",
 "EH" => "Western Sahara",
 "YE" => "Yemen",
 "YU" => "Yugoslavia",
 "ZM" => "Zambia",
 "ZW" => "Zimbabwe");
 ?>