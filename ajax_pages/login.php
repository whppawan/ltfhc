<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");
require_once("../class/Action.class");
require_once ("../class/Data.class");

if($_POST['login_id'])
{
	$login_id=$_POST['login_id'];
	$password=$_POST['password'];
	$language=$_POST['language'];
	
	$a=array();
	
	require_once ("../class/Login.class");
	$login=new Login($con, $login_id, $password, $language);

			
	$rslt=$login->verify();
	$table1 =TBL68;	
	$data=new Data();
	$permission=$data->getData($con, "a.id, a.role_id, a.module_id, a.add_permission, a.edit_permission, a.delete_permission, a.view_permission, a.status", "$table1 a", array("role_id"=>$rslt['role_id']), "");

	$permission=$permission['detail'];
		if($rslt['status']==1)
		{
			if($rslt['auth_path'])
				$location=$rslt['auth_path'];
			else
				$location=$rslt['folder']."/".PAGE1.".php";

			if($location)
			{
				$rslt['auth_path']=$location;
				session_start();
				$rslt['permission']=$permission;
				$_SESSION[APPLICATION_ID.'_login']=$rslt;
				//print_r($_SESSION);
				$a['status'] = 1;
				$a['location'] = $location;
			}
		}
		else
		{
			$a['status'] = "0";
			$a['msg'] = $rslt['msg'];
			$login_id="";
			$password="";
			$location="";
		} 
	
}

echo json_encode($a);
?>

