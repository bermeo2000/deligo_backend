<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CodigoPaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $paises = [
            ['Afganistán','Afghanistan','AF','AFG','93','1'],
            ['Albania','Albania','AL','ALB','355','1'],
            ['Alemania','Germany','DE','DEU','49','1'],
            ['Algeria','Algeria','DZ','DZA','213','1'],
            ['Andorra','Andorra','AD','AND','376','1'],
            ['Angola','Angola','AO','AGO','244','1'],
            ['Anguila','Anguilla','AI','AIA','1 264','1'],
            ['Antártida','Antarctica','AQ','ATA','672','1'],
            ['Antigua y Barbuda','Antigua and Barbuda','AG','ATG','1 268','1'],
            ['Antillas Neerlandesas','Netherlands Antilles','AN','ANT','599','1'],
            ['Arabia Saudita','Saudi Arabia','SA','SAU','966','1'],
            ['Argentina','Argentina','AR','ARG','54','1'],
            ['Armenia','Armenia','AM','ARM','374','1'],
            ['Aruba','Aruba','AW','ABW','297','1'],
            ['Australia','Australia','AU','AUS','61','1'],
            ['Austria','Austria','AT','AUT','43','1'],
            ['Azerbayán','Azerbaijan','AZ','AZE','994','1'],
            ['Bélgica','Belgium','BE','BEL','32','1'],
            ['Bahamas','Bahamas','BS','BHS','1 242','1'],
            ['Bahrein','Bahrain','BH','BHR','973','1'],
            ['Bangladesh','Bangladesh','BD','BGD','880','1'],
            ['Barbados','Barbados','BB','BRB','1 246','1'],
            ['Belice','Belize','BZ','BLZ','501','1'],
            /* [Benín,Benin,BJ,BEN,229,1],
            [Bhután,Bhutan,BT,BTN,975,1],
            [Bielorrusia,Belarus,BY,BLR,375,1],
            [Birmania,Myanmar,MM,MMR,95,1],
            [Bolivia,Bolivia,BO,BOL,591,1],
            [Bosnia y Herzegovina,Bosnia and Herzegovina,BA,BIH,387,1],
            [Botsuana,Botswana,BW,BWA,267,1],
            [Brasil,Brazil,BR,BRA,55,1],
            [Brunéi,Brunei,BN,BRN,673,1],
            [Bulgaria,Bulgaria,BG,BGR,359,1],
            [Burkina Faso,Burkina Faso,BF,BFA,226,1],
            [Burundi,Burundi,BI,BDI,257,1],
            [Cabo Verde,Cape Verde,CV,CPV,238,1],
            [Camboya,Cambodia,KH,KHM,855,1],
            [Camerún,Cameroon,CM,CMR,237,1],
            [Canadá,Canada,CA,CAN,1,1],
            [Chad,Chad,TD,TCD,235,1],
            [Chile,Chile,CL,CHL,56,1],
            [China,China,CN,CHN,86,1],
            [Chipre,Cyprus,CY,CYP,357,1],
            [Ciudad del Vaticano,Vatican City State,VA,VAT,39,1],
            [Colombia,Colombia,CO,COL,57,1],
            [Comoras,Comoros,KM,COM,269,1],
            [Congo,Congo,CG,COG,242,1],
            [Congo,Congo,CD,COD,243,1],
            [Corea del Norte,North Korea,KP,PRK,850,1],
            [Corea del Sur,South Korea,KR,KOR,82,1],
            [Costa de Marfil,Ivory Coast,CI,CIV,225,1],
            [Costa Rica,Costa Rica,CR,CRI,506,1],
            [Croacia,Croatia,HR,HRV,385,1],
            [Cuba,Cuba,CU,CUB,53,1],
            [Dinamarca,Denmark,DK,DNK,45,1],
            [Dominica,Dominica,DM,DMA,1 767,1],
            [Ecuador,Ecuador,EC,ECU,593,1],
            [Egipto,Egypt,EG,EGY,20,1],
            [El Salvador,El Salvador,SV,SLV,503,1],
            [Emiratos Árabes Unidos,United Arab Emirates,AE,ARE,971,1],
            [Eritrea,Eritrea,ER,ERI,291,1],
            [Eslovaquia,Slovakia,SK,SVK,421,1],
            [Eslovenia,Slovenia,SI,SVN,386,1],
            [España,Spain,ES,ESP,34,1],
            [Estados Unidos de América,United States of America,US,USA,1,1],
            [Estonia,Estonia,EE,EST,372,1],
            [Etiopía,Ethiopia,ET,ETH,251,1],
            [Filipinas,Philippines,PH,PHL,63,1],
            [Finlandia,Finland,FI,FIN,358,1],
            [Fiyi,Fiji,FJ,FJI,679,1],
            [Francia,France,FR,FRA,33,1],
            [Gabón,Gabon,GA,GAB,241,1],
            [Gambia,Gambia,GM,GMB,220,1],
            [Georgia,Georgia,GE,GEO,995,1],
            [Ghana,Ghana,GH,GHA,233,1],
            [Gibraltar,Gibraltar,GI,GIB,350,1],
            [Granada,Grenada,GD,GRD,1 473,1],
            [Grecia,Greece,GR,GRC,30,1],
            [Groenlandia,Greenland,GL,GRL,299,1],
            [Guadalupe,Guadeloupe,GP,GLP,590,1],
            [Guam,Guam,GU,GUM,1 671,1],
            [Guatemala,Guatemala,GT,GTM,502,1],
            [Guayana Francesa,French Guiana,GF,GUF,594,1],
            [Guernsey,Guernsey,GG,GGY,44,1],
            [Guinea,Guinea,GN,GIN,224,1],
            [Guinea Ecuatorial,Equatorial Guinea,GQ,GNQ,240,1],
            [Guinea-Bissau,Guinea-Bissau,GW,GNB,245,1],
            [Guyana,Guyana,GY,GUY,592,1],
            [Haití,Haiti,HT,HTI,509,1],
            [Honduras,Honduras,HN,HND,504,1],
            [Hong kong,Hong Kong,HK,HKG,852,1],
            [Hungría,Hungary,HU,HUN,36,1],
            [India,India,IN,IND,91,1],
            [Indonesia,Indonesia,ID,IDN,62,1],
            [Irán,Iran,IR,IRN,98,1],
            [Irak,Iraq,IQ,IRQ,964,1],
            [Irlanda,Ireland,IE,IRL,353,1],
            [Isla Bouvet,Bouvet Island,BV,BVT,,1],
            [Isla de Man,Isle of Man,IM,IMN,44,1],
            [Isla de Navidad,Christmas Island,CX,CXR,61,1],
            [Isla Norfolk,Norfolk Island,NF,NFK,672,1],
            [Islandia,Iceland,IS,ISL,354,1],
            [Islas Bermudas,Bermuda Islands,BM,BMU,1 441,1],
            [Islas Caimán,Cayman Islands,KY,CYM,1 345,1],
            [Islas Cocos (Keeling),Cocos (Keeling) Islands,CC,CCK,61,1],
            [Islas Cook,Cook Islands,CK,COK,682,1],
            [Islas de Åland,Åland Islands,AX,ALA,358,1],
            [Islas Feroe,Faroe Islands,FO,FRO,298,1],
            [Islas Georgias del Sur y Sandwich del Sur,South Georgia and the South Sandwich Islands,GS,SGS,500,1],
            [Islas Heard y McDonald,Heard Island and McDonald Islands,HM,HMD,,1],
            [Islas Maldivas,Maldives,MV,MDV,960,1],
            [Islas Malvinas,Falkland Islands (Malvinas),FK,FLK,500,1],
            [Islas Marianas del Norte,Northern Mariana Islands,MP,MNP,1 670,1],
            [Islas Marshall,Marshall Islands,MH,MHL,692,1],
            [Islas Pitcairn,Pitcairn Islands,PN,PCN,870,1],
            [Islas Salomón,Solomon Islands,SB,SLB,677,1],
            [Islas Turcas y Caicos,Turks and Caicos Islands,TC,TCA,1 649,1],
            [Islas Ultramarinas Menores de Estados Unidos,United States Minor Outlying Islands,UM,UMI,246,1],
            [Islas Vírgenes Británicas,Virgin Islands,VG,VG,1 284,1],
            [Islas Vírgenes de los Estados Unidos,United States Virgin Islands,VI,VIR,1 340,1],
            [Israel,Israel,IL,ISR,972,1],
            [Italia,Italy,IT,ITA,39,1],
            [Jamaica,Jamaica,JM,JAM,1 876,1],
            [Japón,Japan,JP,JPN,81,1],
            [Jersey,Jersey,JE,JEY,44,1],
            [Jordania,Jordan,JO,JOR,962,1],
            [Kazajistán,Kazakhstan,KZ,KAZ,7,1],
            [Kenia,Kenya,KE,KEN,254,1],
            [Kirgizstán,Kyrgyzstan,KG,KGZ,996,1],
            [Kiribati,Kiribati,KI,KIR,686,1],
            [Kuwait,Kuwait,KW,KWT,965,1],
            [Líbano,Lebanon,LB,LBN,961,1],
            [Laos,Laos,LA,LAO,856,1],
            [Lesoto,Lesotho,LS,LSO,266,1],
            [Letonia,Latvia,LV,LVA,371,1],
            [Liberia,Liberia,LR,LBR,231,1],
            [Libia,Libya,LY,LBY,218,1],
            [Liechtenstein,Liechtenstein,LI,LIE,423,1],
            [Lituania,Lithuania,LT,LTU,370,1],
            [Luxemburgo,Luxembourg,LU,LUX,352,1],
            [México,Mexico,MX,MEX,52,1],
            [Mónaco,Monaco,MC,MCO,377,1],
            [Macao,Macao,MO,MAC,853,1],
            [Macedônia,Macedonia,MK,MKD,389,1],
            [Madagascar,Madagascar,MG,MDG,261,1],
            [Malasia,Malaysia,MY,MYS,60,1],
            [Malawi,Malawi,MW,MWI,265,1],
            [Mali,Mali,ML,MLI,223,1],
            [Malta,Malta,MT,MLT,356,1],
            [Marruecos,Morocco,MA,MAR,212,1],
            [Martinica,Martinique,MQ,MTQ,596,1],
            [Mauricio,Mauritius,MU,MUS,230,1],
            [Mauritania,Mauritania,MR,MRT,222,1],
            [Mayotte,Mayotte,YT,MYT,262,1],
            [Micronesia,Estados Federados de,FM,FSM,691,1],
            [Moldavia,Moldova,MD,MDA,373,1],
            [Mongolia,Mongolia,MN,MNG,976,1],
            [Montenegro,Montenegro,ME,MNE,382,1],
            [Montserrat,Montserrat,MS,MSR,1 664,1],
            [Mozambique,Mozambique,MZ,MOZ,258,1],
            [Namibia,Namibia,NA,NAM,264,1],
            [Nauru,Nauru,NR,NRU,674,1],
            [Nepal,Nepal,NP,NPL,977,1],
            [Nicaragua,Nicaragua,NI,NIC,505,1],
            [Niger,Niger,NE,NER,227,1],
            [Nigeria,Nigeria,NG,NGA,234,1],
            [Niue,Niue,NU,NIU,683,1],
            [Noruega,Norway,NO,NOR,47,1],
            [Nueva Caledonia,New Caledonia,NC,NCL,687,1],
            [Nueva Zelanda,New Zealand,NZ,NZL,64,1],
            [Omán,Oman,OM,OMN,968,1],
            [Países Bajos,Netherlands,NL,NLD,31,1],
            [Pakistán,Pakistan,PK,PAK,92,1],
            [Palau,Palau,PW,PLW,680,1],
            [Palestina,Palestine,PS,PSE,970,1],
            [Panamá,Panama,PA,PAN,507,1],
            [Papúa Nueva Guinea,Papua New Guinea,PG,PNG,675,1],
            [Paraguay,Paraguay,PY,PRY,595,1],
            [Perú,Peru,PE,PER,51,1],
            [Polinesia Francesa,French Polynesia,PF,PYF,689,1],
            [Polonia,Poland,PL,POL,48,1],
            [Portugal,Portugal,PT,PRT,351,1],
            [Puerto Rico,Puerto Rico,PR,PRI,1,1],
            [Qatar,Qatar,QA,QAT,974,1],
            [Reino Unido,United Kingdom,GB,GBR,44,1],
            [República Centroafricana,Central African Republic,CF,CAF,236,1],
            [República Checa,Czech Republic,CZ,CZE,420,1],
            [República Dominicana,Dominican Republic,DO,DOM,1 809,1],
            [República de Sudán del Sur,South Sudan,SS,SSD,211,1],
            [Reunión,Réunion,RE,REU,262,1],
            [Ruanda,Rwanda,RW,RWA,250,1],
            [Rumanía,Romania,RO,ROU,40,1],
            [Rusia,Russia,RU,RUS,7,1],
            [Sahara Occidental,Western Sahara,EH,ESH,212,1],
            [Samoa,Samoa,WS,WSM,685,1],
            [Samoa Americana,American Samoa,AS,ASM,1 684,1],
            [San Bartolomé,Saint Barthélemy,BL,BLM,590,1],
            [San Cristóbal y Nieves,Saint Kitts and Nevis,KN,KNA,1 869,1],
            [San Marino,San Marino,SM,SMR,378,1],
            [San Martín (Francia),Saint Martin (French part),MF,MAF,1 599,1],
            [San Pedro y Miquelón,Saint Pierre and Miquelon,PM,SPM,508,1],
            [San Vicente y las Granadinas,Saint Vincent and the Grenadines,VC,VCT,1 784,1],
            [Santa Elena,Ascensión y Tristán de Acuña,SH,SHN,290,1],
            [Santa Lucía,Saint Lucia,LC,LCA,1 758,1],
            [Santo Tomé y Príncipe,Sao Tome and Principe,ST,STP,239,1],
            [Senegal,Senegal,SN,SEN,221,1],
            [Serbia,Serbia,RS,SRB,381,1],
            [Seychelles,Seychelles,SC,SYC,248,1],
            [Sierra Leona,Sierra Leone,SL,SLE,232,1],
            [Singapur,Singapore,SG,SGP,65,1],
            [Sint Maarten,Sint Maarten,SX,SMX,1 721,1],
            [Siria,Syria,SY,SYR,963,1],
            [Somalia,Somalia,SO,SOM,252,1],
            [Sri lanka,Sri Lanka,LK,LKA,94,1],
            [Sudáfrica,South Africa,ZA,ZAF,27,1],
            [Sudán,Sudan,SD,SDN,249,1],
            [Suecia,Sweden,SE,SWE,46,1],
            [Suiza,Switzerland,CH,CHE,41,1],
            [Surinám,Suriname,SR,SUR,597,1],
            [Svalbard y Jan Mayen,Svalbard and Jan Mayen,SJ,SJM,47,1],
            [Swazilandia,Swaziland,SZ,SWZ,268,1],
            [Tadjikistán,Tajikistan,TJ,TJK,992,1],
            [Tailandia,Thailand,TH,THA,66,1],
            [Taiwán,Taiwan,TW,TWN,886,1],
            [Tanzania,Tanzania,TZ,TZA,255,1],
            [Territorio Británico del Océano Índico,British Indian Ocean Territory,IO,IOT,246,1],
            [Territorios Australes y Antárticas Franceses,French Southern Territories,TF,ATF,,1],
            [Timor Oriental,East Timor,TL,TLS,670,1],
            [Togo,Togo,TG,TGO,228,1],
            [Tokelau,Tokelau,TK,TKL,690,1],
            [Tonga,Tonga,TO,TON,676,1],
            [Trinidad y Tobago,Trinidad and Tobago,TT,TTO,1 868,1],
            [Tunez,Tunisia,TN,TUN,216,1],
            [Turkmenistán,Turkmenistan,TM,TKM,993,1],
            [Turquía,Turkey,TR,TUR,90,1],
            [Tuvalu,Tuvalu,TV,TUV,688,1],
            [Ucrania,Ukraine,UA,UKR,380,1],
            [Uganda,Uganda,UG,UGA,256,1],
            [Uruguay,Uruguay,UY,URY,598,1],
            [Uzbekistán,Uzbekistan,UZ,UZB,998,1],
            [Vanuatu,Vanuatu,VU,VUT,678,1],
            [Venezuela,Venezuela,VE,VEN,58,1],
            [Vietnam,Vietnam,VN,VNM,84,1],
            [Wallis y Futuna,Wallis and Futuna,WF,WLF,681,1],
            [Yemen,Yemen,YE,YEM,967,1],
            [Yibuti,Djibouti,DJ,DJI,253,1],
            [Zambia,Zambia,ZM,ZMB,260,1],
            [Zimbabue,Zimbabwe,ZW,ZWE,263,1], */

            
        ];

        foreach ($paises as $p){
            DB::table('codigo_pais')->insert([
                'nombre' => $p[0],
                'name' => $p[1],
                'iso2' => $p[2],
                'iso3' => $p[3],
                'phone_code' => $p[4],
                'estado' => $p[5],
            ]);
        }

    }
}
