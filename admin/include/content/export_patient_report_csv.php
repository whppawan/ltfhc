<?php
include("../../../include/config.php");
include("../../../include/connection.php");

session_start();

$login=$_SESSION[APPLICATION_ID.'_login'];
$login_id=$login['login_id'];

if($login['language']!='')
	$language_code = $login['language'];
else
	$language_code = "en";

include("../../../class/Data.class");
$table1 =TBL69;	
$data=new Data();
$data_language=$data->getData($con, "id, $language_code as content", "$table1 a", "", "");
$content_lang = $data_language['detail'];

$export_data = json_decode(urldecode($_GET['export_data']));
//$export_data = unserialize('a:28:{s:10:"department";s:16:"artement Prnatal";s:9:"user_name";s:7:"cfatiya";s:11:"health_zone";s:7:"Kalemie";s:11:"health_area";s:15:"Mchungaji Mwema";s:4:"year";s:4:"2018";s:5:"month";s:4:"Juin";s:4:"cpn1";s:2:"20";s:7:"cpn1_16";s:1:"1";s:4:"cpn2";s:2:"12";s:4:"cpn3";s:2:"10";s:4:"cpn4";s:1:"1";s:7:"cpn4_36";s:1:"1";s:5:"iron1";s:2:"20";s:5:"iron2";s:2:"11";s:5:"iron3";s:2:"11";s:9:"sulfadox1";s:2:"20";s:9:"sulfadox2";s:2:"10";s:9:"sulfadox3";s:2:"10";s:9:"sulfadox4";s:1:"1";s:8:"mosquito";i:0;s:9:"mosquito1";i:0;s:8:"pregnant";i:0;s:9:"pregnant1";s:1:"2";s:4:"vat1";s:1:"5";s:4:"vat2";s:1:"3";s:4:"vat3";s:1:"2";s:4:"vat4";s:1:"2";s:4:"vat5";s:1:"2";}');
//echo "<pre>";
//print_r($export_data);
$filename="report";

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename="'.$filename.'.csv"');

$department = $export_data->department;
$user_name = $export_data->user_name;
$health_zone = $export_data->health_zone;
$health_area = $export_data->health_area;
$year = $export_data->year;
$month = $export_data->month;
$cpn1 = $export_data->cpn1;
$cpn1_16 = $export_data->cpn1_16;
$cpn2 = $export_data->cpn2;
$cpn3 = $export_data->cpn3;
$cpn4 = $export_data->cpn4;
$cpn4_36 = $export_data->cpn4_36;
$iron1 = $export_data->iron1;
$iron2 = $export_data->iron2;
$iron3 = $export_data->iron3;
$sulfadox1 = $export_data->sulfadox1;
$sulfadox2 = $export_data->sulfadox2;
$sulfadox3 = $export_data->sulfadox3;
$sulfadox4 = $export_data->sulfadox4;
$mosquito = $export_data->mosquito;
$mosquito1 = $export_data->mosquito1;
$pregnant = $export_data->pregnant;
$pregnant1 = $export_data->pregnant1;
$vat1 = $export_data->vat1;
$vat2 = $export_data->vat2;
$vat3 = $export_data->vat3;
$vat4 = $export_data->vat4;
$vat5 = $export_data->vat5;

$output ="ERCC Monthly Medical Report \n\n";
$output .=$content_lang['10']['content'].",".$content_lang['11']['content'].",".$content_lang['12']['content'].",".$content_lang['13']['content'].",".$content_lang['14']['content'];
$output .="\n";							
$output .="$department , $health_zone , $health_area , $year , $month\n";
$output .="\n Prenatal Questions From The DRC Medical Report (SNIS) \n\n 2. Mother's Health \n\n 2.1 Prenatal care (CPN) \n\n";	
$output .="CPN1 (Prenatal care1),$cpn1 \n";						
$output .="CPN1 at 16th week,$cpn1_16 \n";
$output .="CPN2 (Prenatal care2),$cpn2 \n";						
$output .="CPN3 (Prenatal care3),$cpn3 \n";	
$output .="CPN4 (Prenatal care4),$cpn4 \n";	
$output .="CPN 4 (Prenatal Care 4) at the 36th week,$cpn4_36 \n";	
$output .="Iron + Follic Acid 1st dose,$iron1 \n";
$output .="Iron + Follic Acid 2nd dose,$iron2 \n";
$output .="Iron + Follic Acid 3rd dose,$iron3 \n";
$output .="Sulfadox. + Pyrimet 1st dose received,$sulfadox1 \n";
$output .="Sulfadox. + Pyrimet 2nd dose received,$sulfadox2 \n";
$output .="Sulfadox. + Pyrimet 3rd dose received,$sulfadox3 \n";
$output .="Sulfadox. + Pyrimet 4th dose received,$sulfadox4 \n";
$output .="Mosquito-net MILD distributed during CPN 1,$mosquito \n";
$output .="Mosquito-net MILD distributed during CPN 2,$mosquito1 \n";
$output .="Pregnant women with PB < 230mm,$pregnant \n";
$output .="Pregnant women with detected risks,$pregnant1 \n\n";
$output .="2.2 Vaccination of pregnant women \n\n";
$output .="VAT 1,$vat1 \n";
$output .="VAT 2,$vat2 \n";
$output .="VAT 3,$vat3 \n";
$output .="VAT 4,$vat4 \n";
$output .="VAT 5,$vat5 \n";

echo $output;
exit;
?>
