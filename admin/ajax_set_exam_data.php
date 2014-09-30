<?php
/*-----------引入檔案區--------------*/
 
include_once "header.php";
include_once "../function.php";
/*-----------function區--------------*/
//資料檢查
$_GET['id'] = intval($_GET['id']) ;
if ($_GET['id_mode']  == 'upload' ) 
	$_GET['do']='upload' ;	

if ($_GET['id_mode']  == 'openshow' ) 
	$_GET['do']='show' ;

switch($_GET['do']){
	//刪除資料
	case "pwd";
		$_GET['setdata']= htmlspecialchars(addslashes($_GET['setdata'])  );
		$sql = "update ".$xoopsDB->prefix("exam")." set    `passwd` = '{$_GET['setdata']}'   where assn='{$_GET['id']}'     " ;
		$xoopsDB->queryF($sql) ;
	break;
	case "upload";
		if ($_GET['setdata']  === 'true' )
			$setdata =1 ;
		else 
			$setdata =0 ;	

  		$sql = "update ".$xoopsDB->prefix("exam")." set    `upload_mode` = '$setdata'   where assn='{$_GET['id']}'     " ;
  		$xoopsDB->queryF($sql) ;
	break;
	case "show";

		//$_GET['setdata'] = intval($_GET['setdata']) ;
		if ($_GET['setdata']  === 'true' )
			$setdata =1 ;
		else 
			$setdata =0 ;			
  		$sql = "update ".$xoopsDB->prefix("exam")." set    `open_show` = '$setdata'   where assn='{$_GET['id']}'     " ;
  		$xoopsDB->queryF($sql) ;
	break;

}	
//echo $sql . $_GET['setdata']  ;