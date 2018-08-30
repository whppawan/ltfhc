<?php
//$_POST["ltfhcJSON"]='{"login_id":"test", "max_id":"30000"}';
$rslt=array("status"=>0, "msg"=>"Indicators are empty.");
//if(isset($_POST["ltfhcJSON"]))
//{
	$json = $_POST["ltfhcJSON"];
	if (get_magic_quotes_gpc())
		$json = stripslashes($json);

	$data = json_decode($json);

	$login_id=$data->login_id;
	$max_id=$data->max_id?$data->max_id:0;
	
	/*$myfile = fopen("json_files/patient/".$login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
	fwrite($myfile, $_POST["ltfhcJSON"]);
	fclose($myfile);*/

	require_once ("../include/config.php");
	require_once ("../include/".PAGE6.".php");

	$table1=TBL18;

	$stmt = $con->prepare("SELECT a.id, a.patient_id, a.visit, a.component_id, a.component_name, a.component_value, a.language_code, a.tablet_entry_time, a.visit_time, a.data_entry_id FROM $table1 a WHERE data_entry_id='$login_id' AND a.id>$max_id ") or die($con->error);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $patient_id, $visit, $component_id, $component_name, $component_value, $language_code, $tablet_entry_time, $visit_time, $provider_id);
	$rslt['patient_detail']=array();
	if($stmt->num_rows()>0)
	{
		$rslt['status']=1;
		$rslt['msg']="Query Success";
	
		$temp=array();
		
		while($stmt->fetch())
		{
			$temp['id'] = $id;
			$temp['provider_id'] = $provider_id;
			$temp['patient_id'] = $patient_id;
			$temp['visit'] = $visit;
			$temp['entry_time'] = $tablet_entry_time;
			$temp['visit_time'] = $visit_time;
			$temp['component_id'] = $component_id;
			$temp['component_name'] = $component_name;
			$temp['component_value'] = $component_value;
			$temp['language_code'] = $language_code;
			array_push($rslt['patient_detail'], $temp);
			
			/*$rslt['values'] .="(";
			$rslt['values'] .="'".$patient_id."', ";
			$rslt['values'] .="'".$visit."', ";
			$rslt['values'] .="'".$component_id."', ";
			$rslt['values'] .="'".mysqli_real_escape_string($con, $component_name)."', ";
			$rslt['values'] .="'".mysqli_real_escape_string($con, $component_value)."', ";
			$rslt['values'] .="'".$language_code."', ";
			$rslt['values'] .="'".$tablet_entry_time."', ";
			$rslt['values'] .="'".$visit_time."', ";
			$rslt['values'] .="'".$provider_id."', ";
			$rslt['values'] .="'0', ";
			$rslt['values'] .="'1'";
			$rslt['values'] .=")";
			if($i<sizeof($data)-1)
				$rslt['values'] .=",";*/
		}
	}
	else
	{
		$rslt['status']=1;
		$rslt['msg']="No patient found";
		$rslt['patient_detail']=array();
	}
//}


echo json_encode($rslt);
?>

