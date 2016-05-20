<?php

function xoops_module_update_es_exam(&$module, $old_version) {

    if(!chk_add_gview()) go_update_add_gview();
 

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



?>
