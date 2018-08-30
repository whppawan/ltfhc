<?php
$action=$_REQUEST['action'];
$table1=TBL5;
$id=$_GET['id'];
$start=$_GET['start'];
$msg=$_GET['msg'];
$date=date("Y-m-d");
$time=date("Y-m-d H:i:s");
$page=PAGE13;
$page_name="?page=$page&parrent_page=$parrent_page";

if($action=='add'|| $action=='edit')
 $sub_page="form";
else
 $sub_page="list";

/*Its include the screen form/list page according the selection*/
include_once("include/content/".$page."_".$sub_page.".php");
?>