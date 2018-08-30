<?php
require_once('../include/config.php');

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

/*$input = "SmackFactory";

$encrypted = encryptIt( $input );
$decrypted = decryptIt( $encrypted );

echo $encrypted . '<br />' . $decrypted;*/

function encryptIt( $q ) {
    $cryptKey  = ENC_STRING;
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = ENC_STRING;
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}


//$_POST["ltfhcJSON"]='[{"login_id":"test", "hcw_first_name":"fname", "hcw_last_name":"lname", "hcw_loc":"Loc", "hcw_clinic_id":"3423", "hcw_username":"k1", "hcw_pwd":"123", "hcw_device_id":"sdf345sd2"}]';
$rslt=array("status"=>0, "msg"=>"No data to insert");
if(isset($_POST["ltfhcJSON"]))
{
	$json = $_POST["ltfhcJSON"];
	if (get_magic_quotes_gpc())
		$json = stripslashes($json);


	$data = json_decode($json);


	$indicator=array();


	$myfile = fopen("json_files/registration/".$data[0]->login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
	fwrite($myfile, $json);
	fclose($myfile);
	
	require_once('../include/connection.php');
	require_once('../class/Action.class');
	$action = new Action();
	$table1=TBL2;

	for($i=0; $i<sizeof($data); $i++)
	{
		$indicator['hcw_first_name']=$data[$i]->hcw_first_name;
		$indicator['hcw_last_name']=$data[$i]->hcw_last_name;
		$indicator['hcw_zone_id']=$data[$i]->hcw_zone;
		$indicator['hcw_zone']=$data[$i]->hcw_zone;
		$indicator['hcw_area_id']=$data[$i]->hcw_area;
		$indicator['hcw_area']=$data[$i]->hcw_area;
		$indicator['hcw_loc']=$data[$i]->hcw_loc;
		$indicator['hcw_clinic_id']=$data[$i]->hcw_clinic_id;
		$indicator['hcw_username']=$data[$i]->hcw_username;
		$indicator['hcw_pass']=encryptIt($data[$i]->hcw_pwd);
		$indicator['hcw_device_id']=$data[$i]->hcw_device_id;
		$indicator['data_entry_id']=$data[$i]->login_id;
		
		$action->setData($con, $indicator, $table1, array(hcw_username=>$indicator['hcw_username']));
		$rslt=$action->insertData();
	}
}	
if($rslt['status']==2)
	$rslt['status']=1;
echo json_encode($rslt);
?>