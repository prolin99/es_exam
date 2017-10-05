<?php
/*-----------引入檔案區--------------*/

include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/
$_GET['id'] = intval($_GET['id']) ;

switch($_GET['do']){

	case "score";
		$_GET['setdata'] = floatval($_GET['setdata']) ;
		$sql = "update ".$xoopsDB->prefix("exam_files")." set    `score` = '{$_GET['setdata']}'   where asfsn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break;

	case "comment";
		$_GET['setdata'] = htmlspecialchars(addslashes($_GET['setdata'])  );
		$sql = "update ".$xoopsDB->prefix("exam_files")." set    `comment` = '{$_GET['setdata']}'   where asfsn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break;

  case "memo";
		$_GET['setdata'] = htmlspecialchars(addslashes($_GET['setdata'])  );
		$sql = "update ".$xoopsDB->prefix("exam_files")." set    `memo` = ''   where asfsn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break;

}
//echo $sql ;
