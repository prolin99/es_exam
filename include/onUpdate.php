<?php

function xoops_module_update_tad_assignment(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if(!chk_chk1()) go_update1();
    if(!chk_chk2()) go_update2();

    $old_DateTime=XOOPS_ROOT_PATH."/modules/tad_assignment/class/DateTime";
    if(is_dir($old_DateTime)){
      delete_directory($old_DateTime);
    }
    return true;
}


function chk_chk1(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("tad_assignment_types");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update1(){
  global $xoopsDB;
  $sql="CREATE TABLE ".$xoopsDB->prefix("tad_assignment_types")." (
`type` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `type` )
);";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());


  $sql="INSERT INTO ".$xoopsDB->prefix("tad_assignment_types")." (`type`) VALUES
('application/rar'),
('application/x-rar-compressed'),
('application/arj'),
('application/excel'),
('application/gnutar'),
('application/octet-stream'),
('application/pdf'),
('application/powerpoint'),
('application/postscript'),
('application/plain'),
('application/rtf'),
('application/vocaltec-media-file'),
('application/wordperfect'),
('application/x-bzip'),
('application/x-bzip2'),
('application/x-compressed'),
('application/x-excel'),
('application/x-gzip'),
('application/x-latex'),
('application/x-midi'),
('application/x-msexcel'),
('application/x-rtf'),
('application/x-sit'),
('application/x-stuffit'),
('application/x-shockwave-flash'),
('application/x-troff-msvideo'),
('application/x-zip-compressed'),
('application/xml'),
('application/zip'),
('application/msword'),
('application/mspowerpoint'),
('application/vnd.ms-excel'),
('application/vnd.ms-powerpoint'),
('application/vnd.ms-word'),
('application/vnd.ms-word.document.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
('application/vnd.ms-word.template.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.wordprocessingml.template'),
('application/vnd.ms-powerpoint.template.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.presentationml.template'),
('application/vnd.ms-powerpoint.addin.macroEnabled.12'),
('application/vnd.ms-powerpoint.slideshow.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.presentationml.slideshow'),
('application/vnd.ms-powerpoint.presentation.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.presentationml.presentation'),
('application/vnd.ms-excel.addin.macroEnabled.12'),
('application/vnd.ms-excel.sheet.binary.macroEnabled.12'),
('application/vnd.ms-excel.sheet.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
('application/vnd.ms-excel.template.macroEnabled.12'),
('application/vnd.openxmlformats-officedocument.spreadsheetml.template'),
('audio/*'),
('image/*'),
('image/png'),
('image/jpg'),
('image/gif'),
('video/*'),
('multipart/x-zip'),
('multipart/x-gzip'),
('text/richtext'),
('text/plain'),
('text/xml'),
('application/vnd.oasis.opendocument.spreadsheet'),
('application/x-vnd.oasis.opendocument.spreadsheet')";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());
  return true;
}

//�ˬd�Y���O�_�s�b
function chk_chk2(){
  global $xoopsDB;
  $sql="select count(`up_time`) from ".$xoopsDB->prefix("exam_files");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

//�����s
function go_update2(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("exam_files")." ADD `up_time` datetime";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());

  return true;
}



//�إߥؿ�
function mk_dir($dir=""){
    //�Y�L�ؿ��W�٨q�Xĵ�i�T��
    if(empty($dir))return;
    //�Y�ؿ����s�b���ܫإߥؿ�
    if (!is_dir($dir)) {
        umask(000);
        //�Y�إߥ��Ѩq�Xĵ�i�T��
        mkdir($dir, 0777);
    }
}

//�����ؿ�
function full_copy( $source="", $target=""){
  if ( is_dir( $source ) ){
    @mkdir( $target );
    $d = dir( $source );
    while ( FALSE !== ( $entry = $d->read() ) ){
      if ( $entry == '.' || $entry == '..' ){
        continue;
      }

      $Entry = $source . '/' . $entry;
      if ( is_dir( $Entry ) ) {
        full_copy( $Entry, $target . '/' . $entry );
        continue;
      }
      copy( $Entry, $target . '/' . $entry );
    }
    $d->close();
  }else{
    copy( $source, $target );
  }
}


function rename_win($oldfile,$newfile) {
   if (!rename($oldfile,$newfile)) {
      if (copy ($oldfile,$newfile)) {
         unlink($oldfile);
         return TRUE;
      }
      return FALSE;
   }
   return TRUE;
}

function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}



//���Y��
function thumbnail($filename="",$thumb_name="",$type="image/jpeg",$width="120"){

  ini_set('memory_limit', '50M');
  // Get new sizes
  list($old_width, $old_height) = getimagesize($filename);

  $percent=($old_width>$old_height)?round($width/$old_width,2):round($width/$old_height,2);

  $newwidth = ($old_width>$old_height)?$width:$old_width * $percent;
  $newheight = ($old_width>$old_height)?$old_height * $percent:$width;

  // Load
  $thumb = imagecreatetruecolor($newwidth, $newheight);
  if($type=="image/jpeg" or $type=="image/jpg" or $type=="image/pjpg" or $type=="image/pjpeg"){
    $source = imagecreatefromjpeg($filename);
    $type="image/jpeg";
  }elseif($type=="image/png"){
    $source = imagecreatefrompng($filename);
    $type="image/png";
  }elseif($type=="image/gif"){
    $source = imagecreatefromgif($filename);
    $type="image/gif";
  }

  // Resize
  imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);

  header("Content-type: image/png");
  imagepng($thumb,$thumb_name);

  return;
  exit;
}
?>
