<?php
//載入XOOPS主設定檔（必要）
include_once "../../mainfile.php";
//載入自訂的共同函數檔
include_once "function.php";

//判斷是否對該模組有管理權限
$isAdmin=false;
if ($xoopsUser) {
  $module_id = $xoopsModule->getVar('mid');
  $isAdmin=$xoopsUser->isAdmin($module_id);
}

//回模組首頁
$interface_menu[_TAD_TO_MOD]="index.php";
$interface_icon[_TAD_TO_MOD]="fa-chevron-right";
$interface_menu[_MD_SHOW]="show.php";
if($isAdmin){
  $interface_menu[_TAD_TO_ADMIN]="admin/main.php";
  $interface_icon[_TAD_TO_ADMIN]="fa-chevron-right";
}

?>
