<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
session_start();
class Patient
{
	function __construct($con, $patient_id, $visit_date)
	{
		$this->con=$con;
		$this->table="hlth_patient";
		$this->patient_id=$patient_id;
		$this->visit_date=$visit_date;
	}
		
	function checkPatient()
	{
		$a=array(status=>0);
		$patient_detail=array();
		$stmt = $this->con->prepare("	SELECT a.patient_id, a.name, a.age, a.gender, a.father_husband_name, a.contact, g.district_name, h.block_name, i.village_name
										FROM $this->table a	JOIN master_district g ON a.district_id=g.id
															JOIN master_block h ON a.block_id=h.id
															JOIN master_village i ON a.village_id=i.id
										WHERE patient_id = ? ORDER BY visit_id desc") or die($this->con->error);
		$stmt->bind_param("s", $this->patient_id); 
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($patient_id, $name, $age, $gender, $father_husband_name, $contact, $district_name, $block_name, $village_name);
		if($stmt->num_rows>0)
		{
			unset($_SESSION[APPLICATION_ID.'_patient_detail']);
			$stmt->fetch();
			if($gender=="Female")
			{
				$stmt1 = $this->con->prepare("SELECT trmstr_id FROM ".TBL6." WHERE patientid = ? ORDER BY id DESC LIMIT 1 ") or die($this->con->error);
				$stmt1->bind_param("s", $this->patient_id); 
				$stmt1->execute();
				$stmt1->store_result();
				$stmt1->bind_result($last_trimester);
				$stmt1->fetch();
				$stmt1->close();

				$patient_detail['patient_id']=$patient_id;
				$patient_detail['visit_date']=$this->visit_date;
				$patient_detail['name']=$name;
				$patient_detail['age']=$age;
				$patient_detail['gender']=$gender;
				$patient_detail['father_husband_name']=$father_husband_name;
				$patient_detail['contact']=$contact;
				$patient_detail['district_name']=$district_name;
				$patient_detail['block_name']=$block_name;
				$patient_detail['village_name']=$village_name;

				$_SESSION[APPLICATION_ID.'_patient_detail']=$patient_detail;
				$_SESSION[APPLICATION_ID.'_last_trimester']=$last_trimester;

				//$a['last_trimester']=$last_trimester;
				$a['status']=1;
			}
			else
				$a['msg']="Patient is not female";
		}
		else
			$a['msg']="Patient id has not been found";

		$stmt->close();
		return($a);
	}
	
	function getDetail($trimester)
	{
		$a=array();
		$patient_detail=array();
		$stmt = $this->con->prepare("	SELECT a.name, a.age, a.dob, a.gender, a.father_husband_name, a.address, a.contact, b.height, b.weight, b.bmi, c.name AS bpl_card_color, a.bpl_card_no, d.name AS landmark, e.country_name, f.state_name, g.district_name, h.block_name, i.village_name, j.lmp_date, b.systolic, b.diastolic, b.pulse_rate, b.hemoglobin
										FROM $this->table a JOIN ".TBL26." b ON a.patient_id=b.patient_id AND a.visit_id=b.visit_id 
															JOIN ".TBL29." c ON a.bpl_card_id=c.id
															JOIN ".TBL38." d ON a.landmark_id=d.id
															JOIN master_country e ON a.country_id=e.id
															JOIN master_state f ON a.state_id=f.id
															JOIN master_district g ON a.district_id=g.id
															JOIN master_block h ON a.block_id=h.id
															JOIN master_village i ON a.village_id=i.id
															JOIN ".TBL25." j ON a.patient_id=j.patient_id AND a.visit_id=j.visit_id 
										WHERE a.patient_id = ? AND a.gender='Female'") or die($this->con->error);
		$stmt->bind_param( "s", $this->patient_id); 
		$stmt->execute();
		$stmt->store_result();
		//$stmt->num_rows>0;
		$stmt->bind_result($name, $age, $dob, $gender, $father_husband_name, $address, $contact, $height, $weight, $bmi, $bpl_card_color, $bpl_card_no, $landmark, $country_name, $state_name, $district_name, $block_name, $village_name, $lmp_date, $systolic, $diastolic, $pulse_rate, $hemoglobin);
		if($stmt->fetch())
		{
			$a['status']=1;
			$patient_detail['trimester']=$trimester;
			$patient_detail['patient_id']=$this->patient_id;
			$patient_detail['visit_date']=$this->visit_date;
			
			$patient_detail['name']=$name;
			$patient_detail['age']=$age;
			$patient_detail['dob']=$dob;
			$patient_detail['gender']=$gender;
			$patient_detail['father_husband_name']=$father_husband_name;
			$patient_detail['address']=$address;
			$patient_detail['contact']=$contact;
			$patient_detail['height']=$height;
			$patient_detail['weight']=$weight;
			$patient_detail['bmi']=$bmi;
			$patient_detail['bpl_card_color']=$bpl_card_color;
			$patient_detail['bpl_card_no']=$bpl_card_no;
			$patient_detail['landmark']=$landmark;
			$patient_detail['country_name']=$country_name;
			$patient_detail['state_name']=$state_name;
			$patient_detail['district_name']=$district_name;
			$patient_detail['block_name']=$block_name;
			$patient_detail['village_name']=$village_name;
			
			
			$patient_detail['systolic']=$systolic;
			$patient_detail['diastolic']=$diastolic;
			
			$date = date_create($lmp_date);
			date_add($date, date_interval_create_from_date_string('9 months 7 days'));
			
			if($trimester=="1")
			{
				$patient_detail['indctr_1']=$lmp_date;
				$patient_detail['indctr_5']="$systolic/$diastolic";
				$patient_detail['indctr_6']=$weight;
				$patient_detail['indctr_7']=$pulse_rate;
				$patient_detail['indctr_136']=$hemoglobin;
				$patient_detail['indctr_12']=date_format($date, 'Y-m-d');
				
				$d1 = date_create($lmp_date);
				$d2 = date_create($lmp_date);
				date_add($d1, date_interval_create_from_date_string('3 months 1 day'));
				date_add($d2, date_interval_create_from_date_string('6 months'));
				$patient_detail['indctr_16']=date_format($d1, 'Y-m-d')." to ".date_format($d2, 'Y-m-d');
				$patient_detail['instruction']="Suggest to come with ABORH, VDRL, HBsAG, HIV, Malaria in the next ANC visit.
Ask the lady to go to nearest PHC/CHC/FC and get the antenatal card done.";
			}
			else
			if($trimester=="2")
			{
				$patient_detail['indctr_70']=$lmp_date;
				$patient_detail['indctr_20']="$systolic/$diastolic";
				$patient_detail['indctr_21']=$weight;
				$patient_detail['indctr_150']=$pulse_rate;
				$patient_detail['indctr_114']=$hemoglobin;
				$patient_detail['indctr_76']=date_format($date, 'Y-m-d');
				
				$d1 = date_create($lmp_date);
				$d2 = date_create($lmp_date);
				date_add($d1, date_interval_create_from_date_string('6 months 1 day'));
				date_add($d2, date_interval_create_from_date_string('8 months 7days'));
				$patient_detail['indctr_29']=date_format($d1, 'Y-m-d')." to ".date_format($d2, 'Y-m-d');
				$patient_detail['instruction']="Ask the lady to go to nearest PHC/CHC/FC(the place identified for the delivery) and get the antenatal card done.";
			}
			else
			if($trimester=="3-1" or $trimester=="3-2")
			{
				$patient_detail['indctr_72']=$lmp_date;
				$patient_detail['indctr_33']="$systolic/$diastolic";
				$patient_detail['indctr_34']=$weight;
				$patient_detail['indctr_151']=$pulse_rate;
				$patient_detail['indctr_116']=$hemoglobin;
				$patient_detail['indctr_80']=date_format($date, 'Y-m-d');
				
				if($trimester=="3-1")
				{
					$d1 = date_create($lmp_date);
					$d2 = date_create($lmp_date);
					date_add($d1, date_interval_create_from_date_string('8 months 8days'));
					date_add($d2, date_interval_create_from_date_string('8 months 15days'));
					$patient_detail['indctr_31']=date_format($d1, 'Y-m-d')." to ".date_format($d2, 'Y-m-d');
				}
				$patient_detail['instruction']="Ask the lady to go to nearest PHC/CHC/FC (the place identified for the delivery) and get the antenatal card done.";
			}			
			
			switch($trimester)
			{
				case "1":
					$patient_detail['page_heading']="First Trimester";
					break;
					
				case "2":
					$patient_detail['page_heading']="Second Trimester";
					break;
				
				case "3-1":
					$patient_detail['page_heading']="Third Trimester (1st Visit)";
					break;
				
				case "3-2":
					$patient_detail['page_heading']="Third Trimester (2nd Visit)";
					break;
			}
			
			$stmt1 = $this->con->prepare("	SELECT a.askedby, a.current_date, a.visit_count
											FROM ".TBL6." a
											WHERE a.patientid = ? AND a.trmstr_id = ? ORDER BY a.current_date DESC LIMIT 1") or die($this->con->error);
			$stmt1->bind_param( "ss", $this->patient_id, $trimester); 
			$stmt1->execute();
			$stmt1->store_result();
			if($stmt1->num_rows>0)
			{
				$stmt1->bind_result($data_entry_id, $data_entry_time, $visit);
				$stmt1->fetch();
				$stmt1->close();
				$patient_detail['last_entry_info']="Last time <strong>".$patient_detail['page_heading']."</strong> details were entered on <strong>'$data_entry_time'</strong> for visit <strong>$visit</strong>";
			}
			
			$patient_detail['page']="patient_form";
			$_SESSION[APPLICATION_ID.'_patient_detail']=$patient_detail;
		}
		else
		{
			$a['status']=0;
			$a['msg']="Patient id has not been found";
		}
	
		return($a);
	}
}

if($patient_id=$_POST['patient_id'])
{
	$patient=new Patient($con, $patient_id, $_POST['visit_date']);		
	
	if($trimester=$_POST['trimester'])
		$detail=$patient->getDetail($trimester);
	else
		$detail=$patient->checkPatient();
}

echo json_encode($detail);
?>

