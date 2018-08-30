<?php
require_once('../include/config.php');
require_once('../include/connection.php');
require_once('../class/Action.class');

class SaveData
{		
	function __construct($con)
	{
		$this->con=$con;
		$this->action=new Action();
	}
	
	function saveData($indicator, $table, $where)
	{
		$response=array();
		$this->action->setData($this->con, $indicator, $table, $where);
		$insert_data=$this->action->insertData();
		if($insert_data['insert']=="query error")
		{
			$response["patient_id"] = $indicator['patient_id'];
			$response["visit_id"] = $indicator['patient_visit_id'];
			$response["msg"] = " Query error on insert in table $table of patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id']." & visit_id : ".$indicator['symptom_id'];	
			$response["status"] = "0";
		}
		else
		if($insert_data['insert']=="duplicate error")
		{
			$uwhere=array(patient_id=>"Update");
			$this->action->setData($this->con, $indicator, $table, $uwhere);
			$update_data=$this->action->updateData($where);
			if($update_data['update']=="query error")
			{
				$response["patient_id"] = $indicator['patient_id'];
				$response["visit_id"] = $indicator['patient_visit_id'];
				$response["msg"] = " Query error on update in table '$table' for patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id'];	
				$response["status"] = "0";	
			}
			else
			if($update_data['update']=="duplicate error")
			{
				$response["patient_id"] = $indicator['patient_id'];
				$response["visit_id"] = $indicator['patient_visit_id'];
				$response["msg"] = " Duplicate data on update in table '$table' for patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id'];	
				$response["status"] = "0";	
			}
			else
			if($update_data['update']=="success")
			{
				$response["patient_id"] = $indicator['patient_id'];
				$response["visit_id"] = $indicator['patient_visit_id'];
				$response["msg"] = " Data has been updated in table '$table' for patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id'];	
				$response["status"] = "1";	
			}
			else
			{
				$response["patient_id"] = $indicator['patient_id'];
				$response["visit_id"] = $indicator['patient_visit_id'];
				$response["msg"] = " Something went wrong on update in table '$table' for patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id'];	
				$response["status"] = "0";
			}
		}
		else
		if($insert_data['insert']=="success")
		{
			$response["patient_id"] = $indicator['patient_id'];
			$response["visit_id"] = $indicator['patient_visit_id'];
			$response["msg"] = " Data has been inserted in table '$table' for patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id'];	
			$response["status"] = "1";	
		}
		else
		{
			$response["patient_id"] = $indicator['patient_id'];
			$response["visit_id"] = $indicator['patient_visit_id'];
			$response["msg"] = " Something went wrong on insert in table '$table' for patient_id : ".$indicator['patient_id']." & visit_id : ".$indicator['patient_visit_id'];	
			$response["status"] = "0";
		}
		
		return($response);
	}
}

function docPath($provider_id, $patient_id, $visit_date)
{
	$folder_name="Patient-Report-".date("d-M-Y-H-i-s", strtotime($visit_date));
    if(!file_exists("../documents/".$provider_id))
        mkdir("../documents/".$provider_id, 0777);
    if(!file_exists("../documents/".$provider_id."/".$patient_id))
        mkdir("../documents/".$provider_id."/".$patient_id, 0777);
    if(!file_exists("../documents/".$provider_id."/".$patient_id."/".$folder_name))
        mkdir("../documents/".$provider_id."/".$patient_id."/".$folder_name, 0777);
	
	$doc_path="../documents/".$provider_id."/".$patient_id."/".$folder_name."/";
	return($doc_path);
}

$json = $_POST["ltfhcJSON"];
if (get_magic_quotes_gpc())
	$json = stripslashes($json);

//$json='[{"login_id":"test", "patient_id":"1", "patient_visit_id":"1", "patient_first_name":"p1", "patient_last_name":"k1", "symptom":[{"symptom_id":"1"},{"symptom_id":"2"},{"symptom_id":"2"}], "diagnosis":[{"diag_id":"1"},{"diag_id":"2"}], "investigation":[{"invest_id":"1"},{"invest_id":"2"}], "treatment":[{"treatment_id":"1"},{"treatment_id":"2"}], "outcome":[{"outcome_id":"1"},{"outcome_id":"2"}]}, {"login_id":"test", "patient_id":"1", "patient_visit_id":"2", "patient_first_name":"p2", "patient_last_name":"k2", "symptom":[{"symptom_id":"1"},{"symptom_id":"2"}], "diagnosis":[{"diag_id":"1"},{"diag_id":"2"}], "investigation":[{"invest_id":"1"},{"invest_id":"2"}], "treatment":[{"treatment_id":"1"},{"treatment_id":"2"}], "outcome":[{"outcome_id":"1"},{"outcome_id":"2"}]}]';

$data = json_decode($json);

$table1=TBL3;
$table2=TBL4;
$table3=TBL10;
$table4=TBL11;
$table5=TBL12;
$table6=TBL13;
$table7=TBL14;

$patient_indicator=array();
$patient_odp_indicator=array();
$symptom_indicator=array();
$diagnosis_indicator=array();
$investigation_indicator=array();
$treatment_indicator=array();
$outcome_indicator=array();

$save_data = new SaveData($con);

$login_id=$data[0]->login_id;
$myfile = fopen("json_files/patient/".$login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
fwrite($myfile, $json);
fclose($myfile);

for($i=0; $i<sizeof($data); $i++)
{
	$login_id=$data[$i]->login_id;
	$patient_id=$data[$i]->patient_id;
	$visit_id=$data[$i]->patient_visit_id;
	
	$patient_indicator['patient_id']=$patient_id;
	$patient_indicator['patient_visit_id']=$visit_id;
	$patient_indicator['patient_first_name']=$data[$i]->patient_first_name;
	$patient_indicator['patient_last_name']=$data[$i]->patient_last_name;
	$patient_indicator['patient_age']=$data[$i]->patient_age;
	$patient_indicator['patient_gender']=$data[$i]->patient_gender;
	$patient_indicator['patient_location']=$data[$i]->patient_location;
	$patient_indicator['patient_address']=$data[$i]->patient_address;
	$patient_indicator['patient_hz']=$data[$i]->patient_hz;
	$patient_indicator['patient_village']=$data[$i]->patient_village;
	$patient_indicator['patient_visit_num']=$data[$i]->patient_visit_num;
	$patient_indicator['patient_annual_seed']=$data[$i]->patient_annual_seed;
	$patient_indicator['patient_monthly_seed']=$data[$i]->patient_monthly_seed;
	$patient_indicator['data_entry_id']=$login_id;
	
	$patient_odp_indicator['patient_id']=$patient_id;
	$patient_odp_indicator['patient_visit_id']=$visit_id;
	$patient_odp_indicator['patient_condition']=$data[$i]->patient_condition;
	$patient_odp_indicator['patient_payment']=$data[$i]->patient_payment;
	$patient_odp_indicator['patient_payment_balance']=$data[$i]->patient_payment_balance;
	$patient_odp_indicator['patient_comment']=$data[$i]->patient_comment;
	$patient_odp_indicator['patient_pregnant']=$data[$i]->patient_pregnant;
	$patient_odp_indicator['patient_hospitalized']=$data[$i]->patient_hospitalized;
	$patient_odp_indicator['patient_temperature']=$data[$i]->patient_temperature;
	$patient_odp_indicator['internal_med_timestamp']=$data[$i]->internal_med_timestamp;
	$patient_odp_indicator['data_entry_id']=$login_id;
	
	$symptom=$data[$i]->symptom;
	$diagnosis=$data[$i]->diagnosis;
	$investigation=$data[$i]->investigation;
	$treatment=$data[$i]->treatment;
	$outcome=$data[$i]->outcome;
	
	$result=$save_data->saveData($patient_indicator, $table1, array(patient_id=>$patient_indicator['patient_id']));
	//$result['status']="1";
	if($result['status']=="1")
	{
		/************************create Folder : Start***************************/
		//$doc_path=docPath($provider_id, $patient_id, $visit_date);
		//$prescription_name=$patient_id."-".$visit_id."-prescription.pdf";
		/************************create Folder : End***************************/
		$result=$save_data->saveData($patient_odp_indicator, $table2, array(patient_id=>$patient_odp_indicator['patient_id'], patient_visit_id=>$patient_odp_indicator['patient_visit_id']));
		if($result['status']=="1")
		{
			for($j=0; $j<sizeof($symptom); $j++)
			{
				$symptom_indicator['patient_id']=$patient_id;
				$symptom_indicator['visit_id']=$visit_id;
				$symptom_indicator['symptom_id']=$symptom[$j]->symptom_id;
				$symptom_indicator['other']=$symptom[$j]->other_symptom;
				$result=$save_data->saveData($symptom_indicator, $table3, $symptom_indicator);
			}
			for($j=0; $j<sizeof($diagnosis); $j++)
			{
				$diagnosis_indicator['patient_id']=$patient_id;
				$diagnosis_indicator['visit_id']=$visit_id;
				$diagnosis_indicator['diag_id']=$diagnosis[$j]->diag_id;
				$result=$save_data->saveData($diagnosis_indicator, $table4, $diagnosis_indicator);
			}
			for($j=0; $j<sizeof($investigation); $j++)
			{
				$investigation_indicator['patient_id']=$patient_id;
				$investigation_indicator['visit_id']=$visit_id;
				$investigation_indicator['invest_id']=$investigation[$j]->invest_id;
				$investigation_indicator['other']=$investigation[$j]->other_invest;
				$result=$save_data->saveData($investigation_indicator, $table5, $investigation_indicator);
			}
			for($j=0; $j<sizeof($treatment); $j++)
			{
				$treatment_indicator['patient_id']=$patient_id;
				$treatment_indicator['visit_id']=$visit_id;
				$treatment_indicator['treatment_id']=$treatment[$j]->treatment_id;
				$treatment_indicator['other']=$treatment[$j]->other_treatment;
				$result=$save_data->saveData($treatment_indicator, $table6, $treatment_indicator);
			}
			for($j=0; $j<sizeof($outcome); $j++)
			{
				$outcome_indicator['patient_id']=$patient_id;
				$outcome_indicator['visit_id']=$visit_id;
				$outcome_indicator['outcome_id']=$outcome[$j]->outcome_id;
				$result=$save_data->saveData($outcome_indicator, $table7, $outcome_indicator);
			}
		}
	}
}

echo json_encode($result);
?>