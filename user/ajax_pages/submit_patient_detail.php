<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
session_start();

class SaveData
{		
	function __construct($con)
	{
		$this->con=$con;
		$this->action=new Action();
	}
	
	function savePatientData($indicator, $table, $where)
	{
		$response=array();
		$this->action->setData($this->con, $indicator, $table, $where);
		$insert_data=$this->action->insertData();
		if($insert_data['insert']=="query error")
		{
			$response["msg"] = " Query error on insert in table $table of patient id : ".$indicator['Patient_Id']." ". $indicator['Patient_Id']." ". $indicator['Trimester'];
			$response["status"] = "0";
		}
		else
		if($insert_data['insert']=="duplicate error")
		{
			$response["msg"] = " Duplicate data in table '$table' for patient id : ".$indicator['Patient_Id'];
			$response["status"] = "1";
		}
		else
		if($insert_data['insert']=="success")
		{
			$response["msg"] = "Data has been inserted successfully";
			$response["status"] = "1";	
		}
		else
		{
			$response["msg"] = " Something went wrong on insert in table '$table' for patient id : ".$indicator['Patient_Id'];
			$response["status"] = "0";
		}
		
		return($response);
	}
	
	function saveANCData($indicator, $table, $where)
	{
		$response=array();
		$this->action->setData($this->con, $indicator, $table, $where);
		$insert_data=$this->action->insertData();
		if($insert_data['insert']=="query error")
		{
			$response["ques_id"] = $indicator['questionid'];
			$response["msg"] = " Query error on insert in table $table of questionid : ".$indicator['questionid'];	
			$response["status"] = "0";
		}
		else
		if($insert_data['insert']=="duplicate error")
		{
			$response["ques_id"] = $indicator['questionid'];
			$response["msg"] = " Duplicate data error in table '$table' for questionid : ".$indicator['questionid'];	
			$response["status"] = "0";
		}
		else
		if($insert_data['insert']=="success")
		{
			$response["ques_id"] = $indicator['questionid'];
			$response["msg"] = "Data has been inserted successfully";
			$response["status"] = "1";	
		}
		else
		{
			$response["ques_id"] = $indicator['questionid'];
			$response["msg"] = " Something went wrong on insert in table '$table' for questionid : ".$indicator['questionid'];
			$response["status"] = "0";
		}
		
		return($response);
	}
	
	function updateData($indicator, $table, $where)
	{
		$response=array();
		$this->action->setData($this->con, $indicator, $table, array(id=>"Update"));
		$update_data=$this->action->updateData($where);
		if($update_data['update']=="query error")
		{
			$response["msg"] = " Query error on update in table $table of patient id : ".$indicator['patient_id']." and visit id : ".$indicator['visit_id'];	
			$response["status"] = "0";
		}
		else
		if($update_data['update']=="duplicate error")
		{
			$response["msg"] = " Duplicate data error in table '$table' for patient id : ".$indicator['patient_id']." and visit id : ".$indicator['visit_id'];	
			$response["status"] = "0";
		}
		else
		if($update_data['update']=="success")
		{
			$response["msg"] = "Data has been updated successfully";
			$response["status"] = "1";	
		}
		else
		{
			$response["msg"] = " Something went wrong on update in table '$table' for patient id : ".$indicator['patient_id']." and visit id : ".$indicator['visit_id'];	
			$response["status"] = "0";
		}
		
		return($response);
	}
}

$save_data = new SaveData($con);
$indicator=array();

$patient_detail=$_SESSION[APPLICATION_ID.'_patient_detail'];
$login_id=$_SESSION[APPLICATION_ID.'_login_id'];

function visit_count($con, $patient_id, $trimester)
{
	$stmt = $con->prepare("SELECT MAX(a.visit_count) AS visit FROM ".TBL6." a WHERE a.patientid='$patient_id' AND trmstr_id='$trimester'") or die($con->error);
	$stmt->execute();
	//$result = $stmt->get_result();
	$stmt->store_result();
	$stmt->bind_result($visit_count);
	$stmt->fetch();
	$stmt->close();
	return $visit_count;
};

$visit_count=visit_count($con, $patient_detail['patient_id'], $patient_detail['trimester'])+1;

$patient_indicator['Patient_Id']=$patient_detail['patient_id'];
$patient_indicator['Visit_Id']=$visit_count;
$patient_indicator['Visit_Date']=$patient_detail['visit_date'];
$patient_indicator['Trimester']=$patient_detail['trimester'];
$patient_indicator['Name']=$patient_detail['name'];
$patient_indicator['Date_Of_Birth']=$patient_detail['dob'];
$patient_indicator['years']=$patient_detail['age'];
$patient_indicator['Gender']=$patient_detail['gender'];
$patient_indicator['Fathers_Husbands_FName']=$patient_detail['father_husband_name'];
$patient_indicator['Address']=$patient_detail['address'];
$patient_indicator['Mobile_Number']=$patient_detail['contact'];
$patient_indicator['Height']=$patient_detail['height'];
$patient_indicator['Weight']=$patient_detail['weight'];
$patient_indicator['bmi']=$patient_detail['bmi'];
$patient_indicator['BPL_Card_Color']=$patient_detail['bpl_card_color'];
$patient_indicator['BPL_Card_Number']=$patient_detail['bpl_card_no'];
$patient_indicator['Landmark']=$patient_detail['landmark'];
$patient_indicator['Country']=$patient_detail['country_name'];
$patient_indicator['State']=$patient_detail['state_name'];
$patient_indicator['District']=$patient_detail['district_name'];
$patient_indicator['Block']=$patient_detail['block_name'];
$patient_indicator['Village']=$patient_detail['village_name'];
$patient_indicator['data_entry_id']=$login_id;
			
$patient_where=array(Patient_Id=>$patient_indicator['Patient_Id'], Visit_Id=>$patient_indicator['Visit_Id'], Trimester=>$patient_indicator['Trimester']);
$rslt=$save_data->savePatientData($patient_indicator, TBL2, $patient_where);

if($rslt['status']==1)
{
	$patient_where=array(patient_id=>$patient_indicator['Patient_Id']);
	$rslt=$save_data->updateData(array(trimester=>$patient_indicator['Trimester'], anc_visit=>$visit_count), "hlth_case_history", $patient_where);
}

if($rslt['status']==1)
{
	$patient_where=array(patient_id=>$patient_indicator['Patient_Id'], visit_id=>$_SESSION['3_visit_id']);
	$rslt=$save_data->updateData(array(trimester=>$patient_indicator['Trimester'], anc_visit=>$visit_count), "hlth_case_history_visit", $patient_where);
}

if($rslt['status']==1)
{
	$stmt = $con->prepare("SELECT a.id as id FROM ".TBL5." a WHERE a.tremesterid = '".$patient_detail['trimester']."'") or die($con->error);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id);
	
	while ($stmt->fetch())
	{
	//$result = $stmt->get_result();
	
	//while ($row=$result->fetch_assoc())
		//echo $_POST['ans_'.$id];
		//$id=$row['id'];
		
		$answer="";

		if($_POST['ans_'.$id])
		{
			foreach($_POST['ans_'.$id] as $ans)
			{
				$answer .=$ans."|";
			}
			$answer=rtrim($answer, "|");
		}
		if($answer)
		{
			$indicator['questionid']=$id;
		
			$indicator['answertext']=$answer;
			$indicator['patientid']=$patient_detail['patient_id'];
			$indicator['askedby']=$login_id;
			$indicator['date']=$patient_detail['visit_date'];
			$indicator['visit_count']=$visit_count;
			$indicator['trmstr_id']=$patient_detail['trimester'];
	
			$where = array(questionid=>$indicator['questionid'], patientid=>$indicator['patientid'], visit_count=>$indicator['visit_count'], trmstr_id=>$indicator['trmstr_id']);
	
			$rslt=$save_data->saveANCData($indicator, TBL6, $where);
			if($rslt['status']==1)
				unset($_SESSION[APPLICATION_ID.'_patient_detail']);
		}
	}
	$stmt->free_result();
	$stmt->close();
}

echo json_encode($rslt);
?>

