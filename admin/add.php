<?php
/*-----------�ޤJ�ɮװ�--------------*/
$xoopsOption['template_main'] = "es_exam_adm_add.html";
include_once "header.php";
include_once "../function.php";
/*-----------function��--------------*/
//tad_assignment�s����
function tad_assignment_form($assn=""){
  global $xoopsDB,$xoopsTpl;

  //����w�]��
  if(!empty($assn)){
    $DBV=get_tad_assignment($assn);
  }else{
    $DBV=array();
  }

  //�w�]�ȳ]�w

  $assn=(!isset($DBV['assn']))?"":$DBV['assn'];
  $title=(!isset($DBV['title']))?"":$DBV['title'];
  $passwd=(!isset($DBV['passwd']))?"":$DBV['passwd'];
  $note=(!isset($DBV['note']))?"":$DBV['note'];
  $uid=(!isset($DBV['uid']))?"":$DBV['uid'];
  $open_show=(!isset($DBV['open_show']))?"1":$DBV['open_show'];
  $upload_mode=(!isset($DBV['upload_mode']))?"1":$DBV['upload_mode'];
  $ext_file=(!isset($DBV['ext_file']))?"":$DBV['ext_file'];
  $class_id=(!isset($DBV['class_id']))?"":$DBV['class_id'];
  $class_list= get_class_list() ;

  $op=(empty($assn))?"insert_tad_assignment":"update_tad_assignment";


  $xoopsTpl->assign('assn',$assn);
  $xoopsTpl->assign('title',$title);
  $xoopsTpl->assign('note',$note);
  $xoopsTpl->assign('passwd',$passwd);
  $xoopsTpl->assign('ext_file',$ext_file);
  $xoopsTpl->assign('upload_mode',$upload_mode);
  $xoopsTpl->assign('open_show',$open_show);
  $xoopsTpl->assign('class_list',$class_list);  
  $xoopsTpl->assign('class_id',$class_id);    
  $xoopsTpl->assign('op',$op);

}

//�s�W��ƨ�tad_assignment��
function insert_tad_assignment(){
  global $xoopsDB,$xoopsUser;
  $uid=$xoopsUser->getVar('uid');
 
  foreach ($_POST['class_id'] as $class_id =>$class ) { 
  	$sql = "insert into ".$xoopsDB->prefix("exam")." (`title`,class_id , `passwd`, `note`,`uid`,`open_show` ,upload_mode , ext_file ,create_date) 
   		values('{$_POST['title']}',  '$class'  ,'{$_POST['passwd']}','{$_POST['note']}','{$uid}','{$_POST['open_show']}' ,'{$_POST['upload_mode']}'  ,'{$_POST['ext_file']}' ,now()  )";
   	//echo $sql .'<br />';	
  	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  }
  
  //���o�̫�s�W��ƪ��y���s��
  $assn=$xoopsDB->getInsertId();
  return $assn;
}



//��stad_assignment�Y�@�����
function update_tad_assignment($assn=""){
  global $xoopsDB,$xoopsUser;
  $uid=$xoopsUser->getVar('uid');

  $sql = "update ".$xoopsDB->prefix("exam")." set  `title` = '{$_POST['title']}', `passwd` = '{$_POST['passwd']}',  `note` = '{$_POST['note']}',  `open_show` = '{$_POST['open_show']}'  , upload_mode='{$_POST['upload_mode']}'  , ext_file= '{$_POST['ext_file']}'   where assn='$assn'     " ;
  
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  return $assn;
}

/*-----------����ʧ@�P�_��----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
$assn = (!isset($_REQUEST['assn']))? "":intval($_REQUEST['assn']);

switch($op){

  //�s�W���
  case "insert_tad_assignment":
  insert_tad_assignment();
  header("location: index.php");
  break;

  //��J���
  case "tad_assignment_form";
  tad_assignment_form($assn);
  break;

  //�R�����
  case "delete_tad_assignment";
  delete_tad_assignment($assn);
  header("location: index.php");
  break;


  //��s���
  case "update_tad_assignment";
  update_tad_assignment($assn);
  header("location: index.php");
  break;


  //�w�]�ʧ@
  default:
  tad_assignment_form($assn);
  break;

}

/*-----------�q�X���G��--------------*/
include_once 'footer.php';
?>
