<?php
require_once ("../include/config.php");
//$_POST["ltfhcJSON"]='{"login_id":"test", "max_id":"10"}';

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

$rslt=array("status"=>0, "msg"=>"Indicators are empty.");
//if(isset($_POST["ltfhcJSON"]))
//{
	$json = $_POST["ltfhcJSON"];
	if (get_magic_quotes_gpc())
		$json = stripslashes($json);

	$data = json_decode($json);

	$login_id=$data->login_id;
	$max_id=$data->max_id?$data->max_id:0;
	
	require_once ("../include/".PAGE6.".php");

	$table1=TBL2;;

	$stmt = $con->prepare("SELECT a.id, a.hcw_first_name, a.hcw_last_name, a.hcw_area, a.hcw_zone, a.hcw_clinic_id, a.hcw_username, a.hcw_pass, a.hcw_device_id FROM $table1 a WHERE a.id>$max_id AND a.status=1") or die($con->error);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $hcw_first_name, $hcw_last_name, $hcw_area, $hcw_zone, $hcw_clinic_id, $hcw_username, $hcw_pass, $hcw_device_id);
	$rslt['user_detail']=array();
	if($stmt->num_rows()>0)
	{
		$rslt['status']=1;
		$rslt['msg']="Query Success";
		
		$temp=array();
		while($stmt->fetch())
		{
			$temp['id'] = $id;
			$temp['hcw_first_name'] = $hcw_first_name?$hcw_first_name:"";
			$temp['hcw_last_name'] = $hcw_last_name?$hcw_last_name:"";
			$temp['hcw_area'] = $hcw_area?$hcw_area:"";
			$temp['hcw_zone'] = $hcw_zone?$hcw_zone:"";
			$temp['hcw_clinic_id'] = $hcw_clinic_id?$hcw_clinic_id:"";
			$temp['hcw_username'] = $hcw_username?$hcw_username:"";
			$temp['hcw_pass'] = $hcw_pass?decryptIt($hcw_pass):"";
			$temp['hcw_device_id'] = $hcw_device_id?$hcw_device_id:"";
			array_push($rslt['user_detail'], $temp);
		
		}
		
	}
	else
	{
		$rslt['status']=1;
		$rslt['msg']="No data found";
	}
//}
echo json_encode($rslt);
?>

