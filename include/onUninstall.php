<?php
use XoopsModules\Tadtools\Utility;

function xoops_module_uninstall_es_exam(&$module) {
  GLOBAL $xoopsDB;

	$date=date("Ymd");

 	rename(XOOPS_ROOT_PATH."/uploads/es_exam",XOOPS_ROOT_PATH."/uploads/es_exam_bak_{$date}");

	return true;
}
 
?>
