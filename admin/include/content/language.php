<?php
$action=$_REQUEST['action'];
$table1=TBL1;
$id=$_GET['id'];
$start=$_GET['start'];
$msg=$_GET['msg'];

//$page=PAGE11;
$page_name="?page=$page";

//if($action=='add'|| $action=='edit')
$sub_page="form";
//else
 //$sub_page="list";

/*Its include the screen form/list page according the selection*/

include_once("include/content/".$page."_".$sub_page.".php");
?>