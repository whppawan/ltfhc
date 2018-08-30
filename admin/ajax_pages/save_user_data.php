<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
require_once ("../../class/Data.class");
require_once("../../class/Password.class");
session_start();
$login=$_SESSION[APPLICATION_ID.'_login'];

//$table1="config_user_contact";
$action=$_GET['action'];
$table=$_GET['table'];
$id=$_GET['id'];
$_POST['data_entry_id']=$login['login_id'];

list($_POST['login_id'], $domain) = explode('@',$_POST['email']);
$password = ucfirst($_POST['login_id'])."@123";

$pass=new Password($con, $table);
//$_POST['password'] = $pass->Encrypt($password, $data);

$_POST['password']=$pass->Encrypt($password, ENC_STRING);;
	

$save_data = new Action();
$_POST=array_filter($_POST);
$save_data->setData($con, $_POST, $table, array(id=>"Set"));

if($action=="add")
{
	$rslt=$save_data->insertData();//For new entry of data to insert
	
	if($rslt)
	{
		$to=$_POST['email'];
		$_REQUEST['message']="LTFHC User";
		$email = "Do not reply";
		$subject = "LTFHC User Id and Password";
		$txt = "<p>Dear User,</p>
				<p>Your Account in ERCC has been created. Here are your login credentials.</p>
				<p>URL: ".URL.APPLICATION_NAME."</p>
				<p>Login Id: ".$_POST['login_id']." (You can also use email as login id)</p>
				<p>Password: $password</p>";
		//$txt .= $_REQUEST['message'];
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: LTFHC' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		mail($to,$subject,$txt,$headers);
	}
		
	$id=$rslt['insert_id'];
	
	/* if($existContact=='0'){
		
		$arrData= array();
	    $arrData['login_id']=$id;
	    $arrData['contact']=$_POST['contact'];
	    $arrData['data_entry_id']=$_POST['data_entry_id'];
	    $save_data->setData($con, $arrData, $table, array(id=>"Set"));
		$data_added = $save_data->insertData();
	} */
}
else
if($action=="edit"){
	$rslt=$save_data->updateData(array(id=>$id));//For old entry of data to update
  /* if($existContact==0){
	   $arrData= array();
	   $arrData['login_id']=$id;
	   $arrData['contact']=$_POST['contact'];
	   $arrData['data_entry_id']=$_POST['data_entry_id'];
	   $save_data->setData($con, $arrData, $table, array(id=>"Set"));
	   $save_data->insertData();
	} */
}

echo json_encode($rslt);
?>

