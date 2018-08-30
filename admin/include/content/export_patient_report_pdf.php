<?php
include("../../../include/config.php");
include("../../../include/connection.php");
include("../../../include/MPDF57/mpdf.php");

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

$mpdf=new mPDF('win-1252','A4','','',5,5,5,5,5,5); 
$mpdf->useOnlyCoreFonts = true;    // false is default
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Monthly Medical Report");
//$mpdf->SetAuthor("AUTHOR");
//$mpdf->SetWatermarkText("TEST");
//$mpdf->showWatermarkText = False;
//$mpdf->watermark_font = 'DejaVuSansCondensed';
//$mpdf->watermarkTextAlpha = 0.1;
//$mpdf->SetDisplayMode('fullpage');
//$arr_export = unserialize($_GET['export_data']);

//print_r($arr_export);
$export_data = json_decode(urldecode($_GET['export_data']));
//echo "<pre>";
//print_r($export_data);

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

$html =  '<div class="col-sm-12">
		<h2 class="text-center">ERCC Monthly Medical Report</h2>
		<table width="100%" border="1">
			<thead>
				<tr class="info">
					<th>'.$content_lang['10']['content'].'</th>
					<!--<th>User</th>-->
					<th>'.$content_lang['11']['content'].'</th>
					<th>'.$content_lang['12']['content'].'</th>
					<th>'.$content_lang['13']['content'].'</th>
					<th>'.$content_lang['14']['content'].'</th>
				</tr>
			</thead>
			<tbody>
			<tr>
					<td>'.$department.'</td>
					<!--<td>'.$user_name.'</td>-->
					<td>'.$health_zone.'</td>
					<td>'.$health_area.'</td>
					<td>'.$year.'</td>
					<td>'.$month.'</td>
				</tr>
			</tbody>
		</table>
		<table width="100%" border="1">
			<thead>
				<tr>
				<th colspan=2 class="text-center">Prenatal Questions From The DRC Medical Report (SNIS)</th>
				</tr>
				<tr>
				<th colspan=2 class="text-left">2. Mothers Health</th>
				</tr>
				<tr>
				<th colspan=2 class="text-left">2.1 Prenatal care (CPN)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>CPN1 (Prenatal care1)</td>
					<td>'.$cpn1.'</td>
				</tr>
				<tr>
					<td>CPN1 at 16th week</td>
					<td>'.$cpn1_16.'</td>
				</tr>
				<tr>
					<td>CPN2 (Prenatal care2)</td>
					<td>'.$cpn2.'</td>
				</tr>
				<tr>
					<td>CPN3 (Prenatal care3)</td>
					<td>'.$cpn3.'</td>
				</tr>
				<tr>
					<td>CPN4 (Prenatal care4)</td>
					<td>'.$cpn4.'</td>
				</tr>
				<tr>
					<td>CPN 4 (Prenatal Care 4) at the 36th week</td>
					<td>'.$cpn4_36.'</td>
				</tr>
				<tr>
					<td>Iron + Follic Acid 1st dose</td>
					<td>'.$iron1.'</td>
				</tr>
				<tr>
					<td>Iron + Follic Acid 2nd dose</td>
					<td>'.$iron2.'</td>
				</tr>
				<tr>
					<td>Iron + Follic Acid 3rd dose</td>
					<td>'.$iron3.'</td>
				</tr>
				<tr>
					<td>Sulfadox. + Pyrimet 1st dose received</td>
					<td>'.$sulfadox1.'</td>
				</tr>
				<tr>
					<td>Sulfadox. + Pyrimet 2nd dose received</td>
					<td>'.$sulfadox2.'</td>
				</tr>
				<tr>
					<td>Sulfadox. + Pyrimet 3rd dose received</td>
					<td>'.$sulfadox3.'</td>
				</tr>
				<tr>
					<td>Sulfadox. + Pyrimet 4th dose received</td>
					<td>'.$sulfadox4.'</td>
				</tr>
				<tr>
					<td>Mosquito-net MILD distributed during CPN 1</td>
					<td>'.$mosquito.'</td>
				</tr>
				<tr>
					<td>Mosquito-net MILD distributed during CPN 2</td>
					<td>'.$mosquito1.'</td>
				</tr>
				<tr>
					<td>Pregnant women with PB < 230mm</td>
					<td>'.$pregnant.'</td>
				</tr>
				<tr>
					<td>Pregnant women with detected risks</td>
					<td>'.$pregnant1.'</td>
				</tr>
				<tr>
				<th colspan=2 class="text-left">2.2  Vaccination of pregnant women</th>
				</tr>
				<tr>
					<td>VAT 1</td>
					<td>'.$vat1.'</td>
				</tr>
				<tr>
					<td>VAT 2</td>
					<td>'.$vat2.'</td>
				</tr>
				<tr>
					<td>VAT 3</td>
					<td>'.$vat3.'</td>
				</tr>
				<tr>
					<td>VAT 4</td>
					<td>'.$vat4.'</td>
				</tr>
				<tr>
					<td>VAT 5</td>
					<td>'.$vat5.'</td>
				</tr>	
			</tbody>
		</table>
	</div>';
	
$mpdf->WriteHTML($html);
         
$mpdf->Output();

exit;

?>