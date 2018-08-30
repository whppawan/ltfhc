<?php
include("../../../include/config.php");
include("../../../include/connection.php");

$table1=TBL5;
$table2=TBL6;

$filename="report trimester $trimester";
$trimester=$_GET['trimester'];
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename="'.$filename.'.csv"');

$output="Patient Id,Visit,Visit Date,Trimester,Patient Name,Age,Gender,Father Husband Name,Patient Address,Mobile Number,Height,Weight, BMI,BPL Card Color,BPL Card Number,Landmark,Country,State,District,Block,Village,User Name,";
$stmt = $con->prepare("SELECT a.id, a.question FROM $table1 a WHERE a.status=1 AND a.tremesterid='$trimester' ORDER BY a.categoryid, a.sequenceid") or die($con->error);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $question);
while ($stmt->fetch())
{
	$question_id[]=$id;
	$output .="$question,";
}
$stmt->close();
$output .="\n";
$stmt = $con->prepare("SELECT a.Patient_Id, a.Visit_Id, a.Visit_Date, a.Trimester, a.Name, a.Date_Of_Birth, IF(a.years='0', IF(a.months='0', CONCAT(a.days, ' Days'), CONCAT(a.months, ' Months')), CONCAT(a.years, ' Years')) AS age, a.Gender, a.Fathers_Husbands_FName, a.Address, a.Mobile_Number, a.Height, a.Weight, a.bmi, a.BPL_Card_Color, a.BPL_Card_Number, a.Landmark, a.Country, a.State, a.District, a.Block, a.Village, a.data_entry_id FROM ".TBL2." a WHERE a.Trimester='$trimester' AND a.Visit_Date BETWEEN '$from_date' AND '$to_date'") or die($con->error);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($patient_id, $visit_id, $visit_date, $trimester, $patient_name, $dob, $age, $gender, $father_husband_name, $address, $mobile_no, $height, $weight, $bmi, $bpl_card_color, $bpl_card_no, $landmark, $country, $state, $district, $block, $village, $data_entry_id);
while ($stmt->fetch())
{							
	$output .="$patient_id,$visit_id,".date('d M Y', strtotime($visit_date)).",$trimester,$patient_name,$age,$gender,$father_husband_name,$address,$mobile_no,$height,$weight,$bmi,$bpl_card_color,$bpl_card_no,$landmark,$country,$state,$district,$block,$village,$data_entry_id,";
								
	for($i=0; $i<sizeof($question_id); $i++)
	{
		$answertext="";
		$stmt1 = $con->prepare("SELECT b.answertext, a.field_type FROM $table1 a JOIN $table2 b ON a.id=b.questionid WHERE b.questionid='$question_id[$i]' AND b.patientid='$patient_id' AND b.visit_count='$visit_id' AND b.trmstr_id='$trimester' AND b.date BETWEEN '$from_date' AND '$to_date'") or die($con->error);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($answertext, $field_type);
		$stmt1->fetch();
		$stmt1->close();
		
		if($field_type=="date")
			$answertext=date("d M Y", strtotime($answertext));
		
		$answer=str_replace(",", ";", $answertext);
		$output .="$answer,";
	}
	$output .="\n";
}
$stmt->close();

echo $output;
exit;
?>
