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
//echo "<pre>";
//print_r($export_data);
$filename="report.xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

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

$output ="ERCC Monthly Medical Report \r\n\n";
$output .=$content_lang['10']['content']."\t".$content_lang['11']['content']."\t".$content_lang['12']['content']."\t".$content_lang['13']['content']."\t".$content_lang['14']['content'];
$output .="\r\n";							
$output .="$department \t $health_zone \t $health_area \t $year \t $month\n";
$output .="\r\n Prenatal Questions From The DRC Medical Report (SNIS) \r\n\n 2. Mother's Health \r\n\n 2.1 Prenatal care (CPN) \r\n\n";	

$output .="CPN1 (Prenatal care1) \t $cpn1 \r\n";						
$output .="CPN1 at 16th week \t $cpn1_16 \r\n";
$output .="CPN2 (Prenatal care2) \t $cpn2 \r\n";						
$output .="CPN3 (Prenatal care3) \t $cpn3 \r\n";	
$output .="CPN4 (Prenatal care4) \t $cpn4 \r\n";	
$output .="CPN 4 (Prenatal Care 4) at the 36th week \t $cpn4_36 \r\n";	
$output .="Iron + Follic Acid 1st dose \t $iron1 \r\n";
$output .="Iron + Follic Acid 2nd dose \t $iron2 \r\n";
$output .="Iron + Follic Acid 3rd dose \t $iron3 \r\n";
$output .="Sulfadox. + Pyrimet 1st dose received \t $sulfadox1 \r\n";
$output .="Sulfadox. + Pyrimet 2nd dose received \t $sulfadox2 \r\n";
$output .="Sulfadox. + Pyrimet 3rd dose received \t $sulfadox3 \r\n";
$output .="Sulfadox. + Pyrimet 4th dose received \t $sulfadox4 \r\n";
$output .="Mosquito-net MILD distributed during CPN 1 \t $mosquito \r\n";
$output .="Mosquito-net MILD distributed during CPN 2 \t $mosquito1 \r\n";
$output .="Pregnant women with PB < 230mm \t $pregnant \r\n";
$output .="Pregnant women with detected risks \t $pregnant1 \r\n\n";
$output .="2.2 Vaccination of pregnant women \r\n\n";
$output .="VAT 1 \t $vat1 \r\n";
$output .="VAT 2 \t $vat2 \r\n";
$output .="VAT 3 \t $vat3 \r\n";
$output .="VAT 4 \t $vat4 \r\n";
$output .="VAT 5 \t $vat5 \r\n";

echo $output;
exit;
?>
