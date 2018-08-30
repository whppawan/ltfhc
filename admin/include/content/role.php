<?php
$table1=TBL66	;
$status=1;
session_start();
$login=$_SESSION[APPLICATION_ID.'_login'];
//echo "<pre>";
//print_r($login);
$permissionRole = $login['permission']; 

require_once ("../class/Data.class");
$data=new Data();
$page=PAGE12;
$page_name="?page=$page";

if($action=$_REQUEST['action'])
	$page_name .="&action=$action";
if($id=$_REQUEST['id'])
	$page_name .="&id=$id";
if($msg=$_REQUEST['msg'])
	$page_name .="&msg=$msg";
if($start=$_REQUEST['start'])
	$page_name .="&start=$start";

if($_POST['filter'])
{
	echo"<script>
			window.location='$page_name';
		</script>";
}

if($action=='add'|| $action=='edit'){
 $sub_page="form";
}
else if($action=='permission'){
	$page="permission";
	$sub_page="list";
}
else{
 $sub_page="list";
}
/*Its include the screen form/list page according the selection*/
$permissionRole = $login['permission'];
        $permission = 0;

        foreach ($permissionRole as $key => $value) {
            if ($value["module_id"] == 4) {
               $permission = $value;
           }
        }
include_once("include/content/".$page."_".$sub_page.".php");
?>