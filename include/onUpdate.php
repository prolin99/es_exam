<?php
use XoopsModules\Tadtools\Utility;
function xoops_module_update_es_exam(&$module, $old_version) {

    if(!chk_add_gview()) go_update_add_gview();
    if(!chk_add_ip()) go_update_add_ip();
    if(!chk_add_onlyTXT()) go_update_add_onlyTXT();
    if(!chk_add_uploadUrl()) go_update_add_uploadUrl();
    if(!chk_add_teamwork()) go_update_add_teamwork();

    return true;
}
//加入分組作業
function chk_add_teamwork(){
  global $xoopsDB;
  $sql="select count(`team_work`)  from ".$xoopsDB->prefix("exam");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_teamwork(){
  global $xoopsDB;

  $sql=" ALTER TABLE  " .$xoopsDB->prefix("exam") .  "  ADD `team_work`   enum('1','0') NOT NULL DEFAULT '0' ;  "   ;
  $xoopsDB->queryF($sql)  ;

  $sql=" ALTER TABLE  " .$xoopsDB->prefix("exam_files") .  "  ADD `team_sitid_list`   varchar(255) NOT NULL DEFAULT '' ;  "   ;
  $xoopsDB->queryF($sql)  ;
}


//加入只上傳網址  ------------------
function chk_add_uploadUrl(){
  global $xoopsDB;
  $sql="select count(`upload_url`)  from ".$xoopsDB->prefix("exam");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_uploadUrl(){
  global $xoopsDB;

  $sql=" ALTER TABLE  " .$xoopsDB->prefix("exam") .  "  ADD `upload_url`   enum('1','0') NOT NULL DEFAULT '0' ;  "   ;
  $xoopsDB->queryF($sql)  ;
}


//加入不上傳檔案，只撰寫文字  ------------------
function chk_add_onlyTXT(){
  global $xoopsDB;
  $sql="select count(`no_file`)  from ".$xoopsDB->prefix("exam");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_onlyTXT(){
  global $xoopsDB;

  $sql=" ALTER TABLE  " .$xoopsDB->prefix("exam") .  "  ADD `no_file`   enum('1','0') NOT NULL DEFAULT '0' ;  "   ;
  $xoopsDB->queryF($sql)  ;
}

//----加入雲端查看
function chk_add_gview(){
  global $xoopsDB;
  $sql="select count(`gview_mode`)  from ".$xoopsDB->prefix("exam");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_gview(){
  global $xoopsDB;

  $sql=" ALTER TABLE  " .$xoopsDB->prefix("exam") .  "  ADD `gview_mode`   enum('1','0') NOT NULL DEFAULT '0' ;  "   ;
 $xoopsDB->queryF($sql)  ;
}

//-----------------------加入 IP 、舊檔檢查-----------------------
function chk_add_ip(){
  global $xoopsDB;
  $sql="select count(`up_ip`)  from ".$xoopsDB->prefix("exam_files");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_ip(){
  global $xoopsDB;

  $sql=" ALTER TABLE  " .$xoopsDB->prefix("exam_files") .  "  ADD `old_file` tinyint(3) unsigned NOT NULL DEFAULT '0', ADD `up_ip` varchar(255) NOT NULL DEFAULT ''   ;  "   ;
  $xoopsDB->queryF($sql)  ;
}

?>
