<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
session_start();

$action=$_GET['action'];
$table=$_GET['table'];
$id=$_GET['id'];
$login_id=$_SESSION[APPLICATION_ID.'_login_id'];

if($_GET['image_type']=="bg_image")
	$data = array(bg_image=>"");
else
if($_GET['image_type']=="component_image")
	$data = array(image=>"");


/*Creating class Action's object.*/
$save_data = new Action();

if($action=="edit")
{
	/*For old entry of data to delete the image*/
	$save_data->setData($con, $data, $table, array(id=>"Update"));
	$rslt=$save_data->updateData(array(id=>$id));
}

if($rslt['status']==1)
{
	//unlink();
	$rslt['msg']="Image has been deleted successfully";
}
echo json_encode($rslt);
?>

