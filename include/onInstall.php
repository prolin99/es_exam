<?php
use XoopsModules\Tadtools\Utility;

function xoops_module_install_es_exam(&$module) {

	Utility::mk_dir(XOOPS_ROOT_PATH."/uploads/es_exam");

	return true;
}
 
?>
