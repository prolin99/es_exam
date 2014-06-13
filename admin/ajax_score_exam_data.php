<?php
/*-----------引入檔案區--------------*/
 
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/
switch($_GET['do']){

	case "score";

		$sql = "update ".$xoopsDB->prefix("exam_files")." set    `score` = '{$_GET['setdata']}'   where asfsn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break;
	
	case "comment";
		$sql = "update ".$xoopsDB->prefix("exam_files")." set    `comment` = '{$_GET['setdata']}'   where asfsn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break; 

}	
//echo $sql ;