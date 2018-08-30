<?php
//$_POST["ltfhcJSON"]='[{"patient_id":"p1", "visit":"1", "component_id":"1", "component_name":"name", "component_value":"Test1", "language_code":"en", "tablet_entry_time":"0000-00-00", "visit_time":"0000-00-00", "login_id":"l1"},{"patient_id":"p2", "visit":"1", "component_id":"1", "component_name":"name", "component_value":"Test2", "language_code":"en", "tablet_entry_time":"0000-00-00", "visit_time":"0000-00-00", "login_id":"l1"}]';
//$_POST["ltfhcJSON"]=file_get_contents("json_files/patient/rprakash_10-Oct-2017_09-27-01.json");
$rslt = array("status"=>0, "msg"=>"Indicators are empty");
if(isset($_POST["ltfhcJSON"]))
{
	$json = $_POST["ltfhcJSON"];
	if (get_magic_quotes_gpc())
		$json = stripslashes($json);

	$data = json_decode($json);

	$login_id=$data[0]->login_id;
	$myfile = fopen("json_files/patient/".$login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
	fwrite($myfile, $json);
	fclose($myfile);
	
	require_once ("../include/config.php");
	require_once ("../include/".PAGE6.".php");
	require_once("../class/Action.class");

	$save_data = new action($con);
	
	for($i=0; $i<sizeof($data); $i++)
	{
		$values .="(";
		$values .="'".$data[$i]->patient_id."', ";
		$values .="'".$data[$i]->visit."', ";
		$values .="'".$data[$i]->component_id."', ";
		$values .="'".mysqli_real_escape_string($con, $data[$i]->component_name)."', ";
		$values .="'".mysqli_real_escape_string($con, $data[$i]->component_value)."', ";
		$values .="'".$data[$i]->language_code."', ";
		$values .="'".$data[$i]->entry_time."', ";
		$values .="'".$data[$i]->visit_time."', ";
		$values .="'".$data[$i]->login_id."'";
		$values .=")";
		if($i<sizeof($data)-1)
			$values .=",";
	}
	//set_time_limit(0);
	$query="INSERT IGNORE INTO ".TBL18." (patient_id, visit, component_id, component_name, component_value, language_code, tablet_entry_time, visit_time, data_entry_id) VALUES $values";
	$result = $con->query($query);


	if(!$con->error)
	{
		$rslt['status']=1;
		$rslt['msg']="Data has submited successfully";
	}
	else
	{
		$rslt['status']=0;
		$rslt['msg']=$con->error;
	}
	//echo $con->affected_rows;
	$con->close();
}
echo json_encode($rslt);
?>

