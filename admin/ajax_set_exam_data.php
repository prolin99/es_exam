<?php
/*-----------引入檔案區--------------*/
 
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/
switch($_GET['do']){
	//刪除資料
	case "pwd";
		$sql = "update ".$xoopsDB->prefix("exam")." set    `passwd` = '{$_GET['setdata']}'   where assn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break;
	case "upload";
  		$sql = "update ".$xoopsDB->prefix("exam")." set    `upload_mode` = '{$_GET['setdata']}'   where assn='{$_GET['id']}'     " ;
  		$xoopsDB->queryF($sql) ;
	break;
	case "show";
  		$sql = "update ".$xoopsDB->prefix("exam")." set    `open_show` = '{$_GET['setdata']}'   where assn='{$_GET['id']}'     " ;
  		$xoopsDB->queryF($sql) ;
	break;

}	
//echo $sql ;