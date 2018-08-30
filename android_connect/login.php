<?php
//$_POST["ltfhcJSON"]='{"login_id":"k1", "password":"123"}';
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");

/*$input = "123";

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


$json = $_POST["ltfhcJSON"];

/*$myfile = fopen("json_files/patient/".$login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
fwrite($myfile, $json);
fclose($myfile);*/

if (get_magic_quotes_gpc())
	$json = stripslashes($json);
$data = json_decode($json);

$a=array();

$login_id=$data->login_id;
$password=$data->password;
//$login_id="test";
//$password="123";

$table1=TBL2;

$stmt = $con->prepare("SELECT hcw_username, hcw_pass FROM $table1 WHERE hcw_username = ? && status='1'") or die($con->error);
$stmt->bind_param( "s", $login_id); 
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hcw_username, $hcw_pass);
if($stmt->num_rows>0)
{
	$stmt->fetch();
	if(decryptIt($hcw_pass)==$password)
		$a['status'] = "1";
	else
	{
		$a['status'] = "0";
		$a['msg'] = "Incorrect password";
	}
}
else
{
	$a['status'] = "0";
	$a['msg'] = "Login id not found";
}

echo json_encode($a);
?>

