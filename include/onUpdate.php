<?php

function xoops_module_update_es_exam(&$module, $old_version) {

    if(!chk_add_gview()) go_update_add_gview();
    if(!chk_add_ip()) go_update_add_ip();


    return true;
}


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
