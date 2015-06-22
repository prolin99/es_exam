<?php

function xoops_module_update_e_stud_import(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if(!chk_add_gview()) go_update_add_gview();


    return true;
}


function chk_add_gview(){
  global $xoopsDB;
  $sql="select count('gview_mode') from ".$xoopsDB->prefix("exam");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_log(){
  global $xoopsDB;

  $sql="ALTER TABLE  ".$xoopsDB->prefix("exam") .  "  ADD `gview_mode` ENUM('0','1') NOT NULL  DEFAULT '0' ''   ;
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());
}


?>
