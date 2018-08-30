<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
require_once ("../../class/Data.class");

session_start();

$action=$_GET['action'];
$table=$_GET['table'];
$id=$_GET['id'];
$login=$_SESSION[APPLICATION_ID.'_login'];
$_POST['data_entry_id']=$login['login_id'];
$save_data = new Action();
//print_r($_POST);
//add Roles
if(isset($_POST['role_id']) && ($_POST['role_id']>0)){
	
	$data=new Data();
	$detail=$data->getData($con, "a.id, a.name", TBL67." a", "", "");
	$checkPermission=$data->getData($con, "a.id", TBL68." a", array("role_id"=>$_POST['role_id']), "");
	
	$masterModules=$detail['detail'];
	
    $roleId = $_POST['role_id'];
            $modulePermissions = array();
			$save_data->setData($con, '', $table, array(role_id=>$roleId));
		    $rslt=$save_data->deleteData();//For old entry of data to update
    foreach($masterModules as $key => $val) {
                $modulePermissions[$key] = array(
                    'role_id' => $roleId,
                    'module_id' => $val['id'],
                    'add_permission' => isset($_POST['chkAdd']) ? isset($_POST['chkAdd'][$val['name']]) ? 1: 0 : 0,
                    'edit_permission' => isset($_POST['chkEdit']) ? isset($_POST['chkEdit'][$val['name']]) ? 1: 0 : 0,
                    'delete_permission' => isset($_POST['chkDelete']) ? isset($_POST['chkDelete'][$val['name']]) ? 1 : 0 : 0,
                    'view_permission' => isset($_POST['chkView']) ? isset($_POST['chkView'][$val['name']]) ? 1 : 0 : 0,
                    'data_entry_id' => $login['login_id'],
                );
				if(isset($checkPermission['detail']) && !empty($checkPermission['detail'])){
					
				    $save_data->setData($con, $modulePermissions[$key], $table, array(id=>"Set"));
					$rslt=$save_data->insertData();//For new entry of data to insert
					
					$save_data->setData($con, array(name=>$_POST['role_name']) , TBL66, array());
					$rslt=$save_data->updateData(array(id=>$_POST['role_id']));
					
				}else{
				$save_data->setData($con, $modulePermissions[$key], $table, array(id=>"Set"));	
				$rslt=$save_data->insertData();//For new entry of data to insert
				
				$save_data->setData($con, array(name=>$_POST['role_name']) , TBL66, array());
				$rslt=$save_data->updateData(array(id=>$_POST['role_id']));
				}
			
            }
}
//add other form
else
{
	$_POST=array_filter($_POST);
	$save_data->setData($con, $_POST, $table, array(id=>"Set"));

	if($action=="add")
		$rslt=$save_data->insertData();//For new entry of data to insert
	else
	if($action=="edit")
		$rslt=$save_data->updateData(array(id=>$id));//For old entry of data to update
}
echo json_encode($rslt);
?>

